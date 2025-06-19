<?php

namespace App\EventListener;

use App\Entity\Course;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;

#[AsEntityListener(event: Events::preUpdate, method: 'preUpdate', entity: Course::class)]
class CourseListener
{

    public function __construct(
        private string $courseCoversDirectory // injecté via services.yaml
    ) {}

    public function preUpdate(Course $course, PreUpdateEventArgs $event): void
    {
        if ($event->hasChangedField('image')) {
            $oldImage = $event->getOldValue('image');

            if ($oldImage) {
                $filePath = $this->courseCoversDirectory . '/' . $oldImage;
                if (file_exists($filePath)) {
                    unlink($filePath); // supprime l'ancien fichier
                }
            }
        }
    }
}
