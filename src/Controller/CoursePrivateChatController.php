<?php

namespace App\Controller;

use App\Entity\CoursePrivateChat;
use App\Entity\CoursePrivateChatMessage;
use App\Service\CoursePrivateChatService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;


#[Route('/normal_api/course_private_chats')]
class CoursePrivateChatController extends AbstractController
{

    public function __construct(
        private EntityManagerInterface $em,
        private SerializerInterface $serializer,
        private CoursePrivateChatService $coursePrivateChatService
    ) {}

    #[Route('/recherche_avancee', methods: ['GET'])]
    public function recherche_avancee(Request $request)
    {

        $results = $this->em->getRepository(CoursePrivateChatMessage::class)->createQueryBuilder('cpcm')->select('cpcm,MAX(cpcm.timestamp)')
            ->getQuery()
            ->getResult();

        $normalized = $this->serializer->normalize($results);

        return new JsonResponse($normalized);
    }

    #[Route('/search', methods: ['GET'])]
    public function search(Request $request)
    {

        // filters
        $student_name = $request->query->get('student_name');
        $course = $request->query->get('course_id');
        $teacher = $request->query->get('teacher_id');
        $student = $request->query->get('student_id');


        $query = $this->em->getRepository(CoursePrivateChat::class)->createQueryBuilder('chat')
            ->select();


        if (!empty($teacher)) {
            $query
                ->join('chat.course', 'course')
                ->join('course.teachers', 'teacher')
                ->andWhere('teacher.id IN (:teachers)')
                ->setParameter('teachers', [$teacher]);
        }

        if (!empty($student)) {
            $query->andWhere('chat.student=:student')
                ->setParameter('student', $student);
        }

        if (!empty($student_name)) {
            $query->join('chat.student', 'student');
            $query->andWhere(
                $query->expr()->orX(
                    $query->expr()->like('LOWER(student.name)', ':student_name'),
                    $query->expr()->like('LOWER(student.surname)', ':student_name')
                )
            );
            $query->setParameter('student_name', '%' . $student_name . '%');
        }
        if (!empty($course)) {
            $query->andWhere('chat.course=:course');
            $query->setParameter('course', $course);
        }

        // order by last message
        $query->leftJoin('chat.lastMessage', 'lastMessage')
            ->leftJoin('chat.lastAnnouncement', 'lastAnnouncement')
            ->addSelect("
                (CASE 
                    WHEN lastMessage.timestamp IS NULL THEN lastAnnouncement.timestamp
                    WHEN lastAnnouncement.timestamp IS NULL THEN lastMessage.timestamp
                    WHEN lastMessage.timestamp > lastAnnouncement.timestamp THEN lastMessage.timestamp
                    ELSE lastAnnouncement.timestamp
                END) AS HIDDEN mostRecent
            ")
            ->addSelect('(CASE WHEN lastMessage.timestamp IS NULL and lastAnnouncement.timestamp IS NULL THEN 1 ELSE 0 END) AS HIDDEN nullsLast')
            ->addOrderBy('nullsLast', 'ASC')
            ->addOrderBy('mostRecent', 'DESC');

        $totalItems = count($query->getQuery()->getResult());
        $itemPerPage = 30;

        // pagination
        $page = $request->query->get('page', 1);
        $member = $query->setMaxResults($itemPerPage)->setFirstResult($itemPerPage * ($page - 1))->getQuery()->getResult();


        // serialization
        $normalized = $this->serializer->normalize($member, null, ["groups" => ["coursePrivateChat:collection"]]);

        return new JsonResponse(["totalItems" => $totalItems, "member" => $normalized]);
    }


    // #[Route('/lastMessages', methods: ['GET'])]
    // public function lastMessages(Request $request) {
    //     $chat_id = $request->query->get('chat_id');

    //     if(empty($chat_id)) {
    //         return new JsonResponse("empty chat_id", 400);
    //     }

    //     $retour = $this->em->getRepository(CoursePrivateChatMessage::class)->createQueryBuilder('message')
    //     ->select()
    //     ->where('message.chat=:chat_id')
    //     ->setParameter('chat_id', $chat_id)
    //     ->orderBy('message.timestamp', 'DESC')
    //     ->setMaxResults(5)
    //     ;
    // }
}
