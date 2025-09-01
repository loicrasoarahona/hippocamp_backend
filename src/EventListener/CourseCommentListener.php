<?php

namespace App\EventListener;

use App\Entity\CourseComment;
use App\Service\CourseCommentService;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Events;

#[AsEntityListener(event: Events::prePersist, method: 'prePersist', entity: CourseComment::class)]
class CourseCommentListener
{

    public function __construct(
        private CourseCommentService $courseCommentService
    ) {}

    public function prePersist(CourseComment $comment, PrePersistEventArgs $args)
    {
        // supprimer le dernier commentaire de l'utilisateur
        $student = $comment->getStudent();
        $course = $comment->getCourse();
        $this->courseCommentService->deleteLastComment($student, $course);
    }
}
