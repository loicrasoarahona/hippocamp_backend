<?php

namespace App\Controller;

use App\Entity\CourseForum;
use App\Entity\CourseForumReply;
use App\Service\CourseForumReplyService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/normal_api/course_forums')]
class CourseForumController extends AbstractController
{

    public function __construct(
        private EntityManagerInterface $em,
        private CourseForumReplyService $courseForumReplyService,
        private SerializerInterface $serializer
    ) {}

    #[Route('/replies', methods: ['GET'])]
    public function findReplies(Request $request)
    {
        $forum_id = $request->query->get('forum_id');
        if (empty($forum_id)) {
            return new JsonResponse("Undefined parameter forum_id", 400);
        }

        $replies = $this->em->getRepository(CourseForumReply::class)->createQueryBuilder('reply')
            ->select()
            ->where('reply.forum=:forum_id')
            ->setParameter('forum_id', $forum_id)
            ->orderBy('reply.timestamp', 'ASC')
            ->getQuery()
            ->getResult();

        foreach ($replies as $reply) {
            $reply->displayName = $this->courseForumReplyService->getDisplayName($reply);
        }

        $normalized = $this->serializer->normalize($replies);

        return new JsonResponse($normalized);
    }
}
