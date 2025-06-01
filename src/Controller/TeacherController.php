<?php

namespace App\Controller;

use App\Entity\Teacher;
use App\Entity\User;
use App\Entity\UserRole;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/normal_api/teachers', name: 'api_teachers_')]
class TeacherController extends AbstractController
{
    public function __construct(private EntityManagerInterface $em, private SerializerInterface $serializer) {}

    #[Route('/create-teacher', methods: ['POST'])]
    public function createTeacher(Request $request): JsonResponse
    {

        $data = json_decode($request->getContent(), true);

        if (
            empty($data) || empty($data['name']) || empty($data['surname']) || empty($data['email']) || empty($data['password']) || empty($data['address']) || empty($data['birthdate'])
        ) {
            return $this->json(['error' => 'Invalid data'], 400);
        }

        $this->em->getConnection()->beginTransaction();

        // find student role
        $role = $this->em->getRepository(UserRole::class)->findOneBy(['name' => 'teacher']);
        if (empty($role)) {
            return $this->json(['error' => 'undefined student role'], 500);
        }

        try {
            // 1. Création de l'utilisateur
            $user = new User();
            $user->setEmail($data['email']);
            $user->setPassword($data['password']);
            $user->setRole($role);
            $this->em->persist($user);

            // 2. Création du teacher associé
            $teacher = new Teacher();
            $teacher->setMUser($user);
            $teacher->setName($data['name']);
            $teacher->setSurname($data['surname']);
            $teacher->setEmail($data['email']);
            $teacher->setAddress($data['address']);
            $teacher->setBirthdate(new DateTime($data['birthdate']));

            $this->em->persist($teacher);

            $this->em->flush();
            $this->em->getConnection()->commit();

            $normalized = $this->serializer->normalize($teacher);

            return $this->json($normalized, 201);
        } catch (\Throwable $e) {
            $this->em->getConnection()->rollBack();
            return $this->json([
                'error' => 'Transaction failed',
                'details' => $e->getMessage()
            ], 500);
        }
    }
}
