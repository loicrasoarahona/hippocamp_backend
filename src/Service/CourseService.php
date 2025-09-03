<?php

namespace App\Service;

use App\Entity\Course;
use App\Entity\CourseComment;
use App\Entity\StudentCourse;
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

    public function getStudentCourseStatistic()
    {
        // D’abord récupérer le total
        $total = $this->em->getRepository(StudentCourse::class)->createQueryBuilder('sc')
            ->select('COUNT(sc.id)')
            ->getQuery()
            ->getSingleScalarResult();

        $retour = $this->em->getRepository(Course::class)->createQueryBuilder('c')
            ->select('c as course', 'count(studentCourse.id) as nbRequests', '(count(studentCourse.id) * 100.0 / :total) AS percentage')
            ->leftJoin(StudentCourse::class, 'studentCourse', 'WITH', 'studentCourse.course = c')
            ->groupBy('c.id')
            ->setParameter('total', $total)
            ->orderBy('percentage', 'DESC')
            ->getQuery()
            ->getResult();


        return $retour;
    }

    public function getNbStudents(Course $course)
    {
        $qb = $this->em->getRepository(StudentCourse::class)->createQueryBuilder('studentCourse')
            ->select('COUNT(studentCourse.id)')
            ->where('studentCourse.course=:courseId')
            ->andWhere('studentCourse.registeredAt IS NOT null')
            ->setParameter('courseId', $course->getId());

        try {
            return (float) $qb->getQuery()
                ->getSingleScalarResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            return 0;
        }
    }
}
