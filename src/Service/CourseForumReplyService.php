<?php

namespace App\Service;

use App\Entity\Administrator;
use App\Entity\CourseForumReply;
use App\Entity\Student;
use App\Entity\Teacher;
use App\Type\DisplayName;
use Doctrine\ORM\EntityManagerInterface;

class CourseForumReplyService
{

    public function __construct(
        private EntityManagerInterface $em
    ) {}

    public function getDisplayName(CourseForumReply $reply)
    {
        $user = $reply->getMUser();
        $roleName = $user->getRole()->getName();
        $retour = new DisplayName();

        if ($roleName == 'student') {
            $student = $this->em->getRepository(Student::class)->createQueryBuilder('student')->select()
                ->where('student.m_user=:userId')
                ->setParameter('userId', $user->getId())
                ->getQuery()
                ->getResult();
            if (!empty($student)) {
                $retour->name = $student[0]->getName();
                $retour->surname = $student[0]->getSurname();
                $retour->email = $student[0]->getEmail();
                $retour->role = 'student';
            }
        } else if ($roleName == 'teacher') {
            $teacher = $this->em->getRepository(Teacher::class)->createQueryBuilder('teacher')->select()
                ->where('teacher.m_user=:userId')
                ->setParameter('userId', $user->getId())
                ->getQuery()
                ->getResult();
            if (!empty($teacher)) {
                $retour->name = $teacher[0]->getName();
                $retour->surname = $teacher[0]->getSurname();
                $retour->email = $teacher[0]->getEmail();
                $retour->role = 'teacher';
            }
        } else if ($roleName == 'admin') {
            $admin = $this->em->getRepository(Administrator::class)->createQueryBuilder('admin')->select()
                ->where('admin.m_user=:userId')
                ->setParameter('userId', $user->getId())
                ->getQuery()
                ->getResult();
            if (!empty($admin)) {
                $retour->name = $admin[0]->getName();
                $retour->surname = $admin[0]->getSurname();
                $retour->email = $admin[0]->getEmail();
                $retour->role = 'admin';
            }
        }

        return $retour;
    }
}
