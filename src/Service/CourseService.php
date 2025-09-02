<?php

namespace App\Service;

use App\Entity\Course;
use App\Entity\CourseComment;
use Doctrine\ORM\EntityManagerInterface;

class CourseService
{

    public function __construct(
        private EntityManagerInterface $em
    ) {}

    public function getAverageRating(Course $course)
    {
        $qb = $this->em->getRepository(CourseComment::class)->createQueryBuilder('comment')
            ->select('AVG(comment.rating) as avgRating')
            ->groupBy('comment.course')
            ->having('comment.course = :courseId')
            ->setParameter('courseId', $course->getId());

        try {
            return (float) $qb->getQuery()
                ->getSingleScalarResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            return 0;
        }
    }
}
