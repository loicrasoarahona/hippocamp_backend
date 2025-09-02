<?php

namespace App\Service;

use App\Entity\Teacher;
use Doctrine\ORM\EntityManagerInterface;

class TeacherService
{

    public function __construct(
        private EntityManagerInterface $em
    ) {}

    public function getNbUnAuthorizedTeachers()
    {
        $qb = $this->em->getRepository(Teacher::class)->createQueryBuilder('teacher')
            ->select('count(teacher.id)')
            ->where('teacher.authorized=false');

        try {
            return (float) $qb->getQuery()
                ->getSingleScalarResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            return 0;
        }
    }
}
