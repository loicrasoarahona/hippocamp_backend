<?php

namespace App\Controller;

use App\Entity\CourseChapter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/normal_api/course_parts')]
class CoursePartController extends AbstractController
{

    public function __construct(private EntityManagerInterface $em, private SerializerInterface $serializer) {}

    #[Route('/first_course_chapter', methods: ['GET'])]
    public function findFirstCourseChapter(Request $request)
    {
        $course_part_id = $request->query->get('course_part_id');
        if (empty($course_part_id)) {
            return new JsonResponse("Empty course_part_id", 400);
        }

        $chapters = $this->em->getRepository(CourseChapter::class)->createQueryBuilder('chapter')
            ->select()
            ->where('chapter.coursePart=:course_part_id')
            ->setParameter('course_part_id', $course_part_id)
            ->orderBy('chapter.yIndex', 'ASC')
            ->addOrderBy('chapter.id', 'ASC')
            ->getQuery()
            ->getResult();

        if (!empty($chapters)) {
            $retour = $chapters[0];
            $normalized = $this->serializer->normalize($retour);
            return new JsonResponse($normalized);
        }

        return new JsonResponse(null);
    }
}
