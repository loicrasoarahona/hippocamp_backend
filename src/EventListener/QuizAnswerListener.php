<?php

namespace App\EventListener;

use App\Entity\QuizAnswer;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\PostPersistEventArgs;
use Doctrine\ORM\Events;

#[AsEntityListener(event: Events::postPersist, method: 'postPersist', entity: QuizAnswer::class)]
#[AsEntityListener(event: Events::preUpdate, method: 'preUpdate', entity: QuizAnswer::class)]
class QuizAnswerListener
{

    public function __construct(private EntityManagerInterface $em) {}

    public function postPersist(QuizAnswer $quizAnswer, PostPersistEventArgs $args)
    {
        $this->assignScore($quizAnswer);
        $this->em->flush();
    }

    public function preUpdate(QuizAnswer $quizAnswer)
    {
        $this->assignScore($quizAnswer);
    }

    private function assignScore(QuizAnswer &$quizAnswer): void
    {
        // cette fonction a pour but d'assigner une note /20 à l'objet en fonction des options choisies

        // récupérer les options choisies par l'utilisateur
        $chosenOptions = $quizAnswer->getChosenOptions()->toArray();

        // itérer toutes les options des questions, les compter et compter les réponses fausses
        $questions = $quizAnswer->getQuiz()->getQuestions();
        $countOptions = 0;
        $countMistakes = 0;

        foreach ($questions as $question) {
            foreach ($question->getOptions() as $option) {
                $countOptions++;
                if ($option->isCorrect()) {
                    if (!$this->containsOption($chosenOptions, $option->getId())) {
                        $countMistakes++;
                    }
                } else {
                    if ($this->containsOption($chosenOptions, $option->getId())) {
                        $countMistakes++;
                    }
                }
            }
        }

        // règle de trois
        $userCorrects = $countOptions - $countMistakes;
        $score = ($userCorrects * 20) / $countOptions;
        $quizAnswer->setScore($score);
    }

    // Fonction utilitaire pour rechercher un id dans une liste d'objets
    private function containsOption(array $options, $id): bool
    {
        foreach ($options as $opt) {
            if ($opt->getId() === $id) {
                return true;
            }
        }
        return false;
    }
}
