<?php

namespace App\Controller;

use App\Entity\ContentBlock;
use App\Entity\CoursePage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/normal_api/course_pages')]
class CoursePageController extends AbstractController
{

    public function __construct(private SerializerInterface $serializer, private EntityManagerInterface $em) {}

    #[Route('', methods: ['POST'])]
    public function save(Request $request)
    {
        $data = $request->getContent();
        $entity = $this->serializer->deserialize(
            $request->getContent(),
            CoursePage::class,
            'json',
            [AbstractNormalizer::GROUPS => ['coursePage:create']]
        );

        // vérifier l'existence du dosser
        $uploadDir = $this->getParameter('kernel.project_dir') . '/public/uploads/content_blocks_images';
        if (!is_dir($uploadDir)) {
            if (!mkdir($uploadDir, 0775, true) && !is_dir($uploadDir)) {
                return new JsonResponse(['error' => 'Failed to create upload directory'], 500);
            }
        }

        // déplacer les images temporaires vers le vrai dossier
        $blocks = $entity->getContentBlocks();
        foreach ($blocks as $item) {
            if ($item->getType()->getName() == 'image') {
                $oldImagePath = $this->getParameter('kernel.project_dir') . '/public/uploads/temp_content_blocks_image/' . $item->getContent();
                $newImagePath = $this->getParameter('kernel.project_dir') . '/public/uploads/content_blocks_images/' . $item->getContent();
                try {
                    // Déplacer le fichier
                    rename($oldImagePath, $newImagePath);
                } catch (\Throwable $th) {
                }
            }
        }

        // save
        $this->em->persist($entity);
        $this->em->flush();

        $normalized = $this->serializer->normalize($entity, null, ["groups" => "coursePage:read"]);

        return new JsonResponse($normalized, 201);
    }
}
