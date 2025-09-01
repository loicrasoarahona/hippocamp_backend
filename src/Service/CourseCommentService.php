<?php

namespace App\Service;

use App\Entity\Course;
use App\Entity\CourseComment;
use App\Entity\Student;
use Doctrine\ORM\EntityManagerInterface;

class CourseCommentService
{

    public function __construct(
        private EntityManagerInterface $em
    ) {}

    public function deleteLastComment(Student $student, Course $course)
    {
        $results = $this->em->getRepository(CourseComment::class)->createQueryBuilder('comment')
            ->select()
            ->where('comment.student=:studentId')
            ->andWhere('comment.course=:courseId')
            ->setParameter('studentId', $student->getId())
            ->setParameter('courseId', $course->getId())
            ->getQuery()
            ->getResult();

        if (!empty($results)) {
            $row = $results[0];
            $this->em->remove($row);
            $this->em->flush();
        }
    }
}
