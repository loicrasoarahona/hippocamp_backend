<?php

namespace App\Service;

use App\Entity\CoursePrivateChat;
use App\Entity\CoursePrivateChatAnnouncement;
use App\Entity\Student;
use App\Entity\StudentCourse;
use Doctrine\ORM\EntityManagerInterface;

class StudentCourseService
{


    public function __construct(private EntityManagerInterface $em) {}

    public function createDefaultChat(StudentCourse $studentCourse)
    {
        // vérifier que l'élève est inscrit au cours
        if (!empty($studentCourse->getRegisteredAt())) {
            $chatExistant = $this->em->getRepository(CoursePrivateChat::class)->createQueryBuilder('chat')
                ->select()
                ->where('chat.student=:student_id')
                ->andWhere('chat.course=:course_id')
                ->setParameter('student_id', $studentCourse->getStudent())
                ->setParameter('course_id', $studentCourse->getCourse())
                ->getQuery()
                ->getResult();
            // créer le chat s'il n'en a pas
            if (empty($chatExistant)) {
                $newChat = new CoursePrivateChat();
                $newChat->setCourse($studentCourse->getCourse());
                $newChat->setStudent($studentCourse->getStudent());

                // enregistrement
                $this->em->persist($newChat);
                $this->em->flush();

                // créer l'annonce
                $annonce = new CoursePrivateChatAnnouncement();
                $annonce->setContent("Bienvenue dans ce cours : " . $studentCourse->getCourse()->getName());
                $annonce->setChat($newChat);

                // enregistrement
                $this->em->persist($annonce);
                $this->em->flush();
            }
        }
    }

    public function getStudentProgression(StudentCourse $studentCourse)
    {
        $countChapters = 0;
        $endedChapters = 0;

        $course = $studentCourse->getCourse();
        $parts = $course->getCourseParts();
        foreach ($parts as $part) {
            $countChapters += count($part->getCourseChapters());
        }
        $endedChapters = count($studentCourse->getEndedChapters());

        return $endedChapters * 100 / $countChapters;
    }
}
