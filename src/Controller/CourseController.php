<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/normal_api/courses')]
class CourseController extends AbstractController
{

    public function __construct() {}

    #[Route('/upload_image', methods: ['POST'])]
    public function uploadImage(Request $request)
    {
        $file = $request->files->get('image'); // 'file' = nom du champ

        // vérifier le dossier et le créer s'il n'existe pas
        $uploadDir = $this->getParameter('kernel.project_dir') . '/public/uploads/course_covers';
        if (!is_dir($uploadDir)) {
            if (!mkdir($uploadDir, 0775, true) && !is_dir($uploadDir)) {
                return new JsonResponse(['error' => 'Failed to create upload directory'], 500);
            }
        }

        if (!$file) {
            return new JsonResponse(['error' => 'No file uploaded'], 400);
        }


        $filename = uniqid() . '.' . $file->guessExtension();


        try {
            $file->move($uploadDir, $filename);
        } catch (FileException $e) {
            return new JsonResponse($e, 500);
        }

        return new JsonResponse([
            'message' => 'File uploaded successfully',
            'filename' => $filename
        ]);
    }
}
