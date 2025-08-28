<?php

namespace App\Controller;

use App\Entity\StudentCourse;
use App\Entity\User;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/normal_api/student_courses', name: 'api_student_courses')]
class StudentCourseController extends AbstractController
{

    public function __construct(private EntityManagerInterface $em, private SerializerInterface $serializer) {}

    #[Route('/admitStudent', methods: ['POST'])]
    public function admitStudent(Request $request)
    {
        $body = json_decode($request->getContent());

        if (empty($body->userId)) {
            return new JsonResponse("empty userId", 400);
        }
        if (empty($body->id)) {
            return new JsonResponse("empt id", 400);
        }

        $item = $this->em->getRepository(StudentCourse::class)->find($body->id);
        if (empty($item)) {
            throw "item non trouvé";
        }
        $user = $this->em->getRepository(User::class)->find($body->userId);
        if (empty($user)) {
            throw "user non trouvé";
        }

        $item->setRegisteredBy($user);
        $item->setRegisteredAt(new DateTimeImmutable());
        $this->em->persist($item);
        $this->em->flush();

        $normalized = $this->serializer->normalize($item, null, ["groups" => ["studentCourse:collection"]]);
        return new JsonResponse($normalized);
    }

    #[Route('/nb_pending_requests', methods: ['GET'])]
    public function nbPendingRequests(Request $request)
    {
        $retour = $this->em->getRepository(StudentCourse::class)->createQueryBuilder('e')
            ->select('COUNT(e.id)')
            ->where('e.registeredAt IS NULL')
            ->getQuery()
            ->getSingleScalarResult();

        return new JsonResponse($retour);
    }
}
