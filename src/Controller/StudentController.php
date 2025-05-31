<?php

namespace App\Controller;

use App\Entity\Student;
use App\Entity\User;
use App\Entity\UserRole;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/normal_api/students', name: 'api_students_')]
class StudentController extends AbstractController
{

    public function __construct(private SerializerInterface $serializer) {}

    #[Route('/signup', methods: ['POST'])]
    public function createWithUser(
        Request $request,
        EntityManagerInterface $em,
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);

        if (
            empty($data) || empty($data['name']) || empty($data['surname']) || empty($data['email']) || empty($data['password']) || empty($data['address']) || empty($data['birthdate'])
        ) {
            return $this->json(['error' => 'Invalid data'], 400);
        }

        $em->getConnection()->beginTransaction();

        // find student role
        $role = $em->getRepository(UserRole::class)->findOneBy(['name' => 'student']);
        if (empty($role)) {
            return $this->json(['error' => 'undefined student role'], 500);
        }

        try {
            // 1. Création de l'utilisateur
            $user = new User();
            $user->setEmail($data['email']);
            $user->setPassword($data['password']);
            $user->setRole($role);
            $em->persist($user);

            // 2. Création du student associé
            $student = new Student();
            $student->setMUser($user);
            $student->setName($data['name']);
            $student->setSurname($data['surname']);
            $student->setEmail($data['email']);
            $student->setAddress($data['address']);
            $student->setBirthdate(new DateTime($data['birthdate']));

            $em->persist($student);

            $em->flush();
            $em->getConnection()->commit();

            $normalized = $this->serializer->normalize($student);

            return $this->json($normalized, 201);
        } catch (\Throwable $e) {
            $em->getConnection()->rollBack();
            return $this->json([
                'error' => 'Transaction failed',
                'details' => $e->getMessage()
            ], 500);
        }
    }
}
