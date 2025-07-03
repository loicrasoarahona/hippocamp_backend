<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/normal_api/content_blocks')]
class ContentBlockController extends AbstractController
{

    public function __construct() {}

    #[Route('/upload_temp_image', methods: ['POST'])]
    public function uploadTempImage(Request $request)
    {
        $file = $request->files->get('image'); // 'file' = nom du champ

        // vérifier le dossier et le créer s'il n'existe pas
        $uploadDir = $this->getParameter('kernel.project_dir') . '/public/uploads/temp_content_blocks_image';
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

    #[Route('/delete_temp_image', methods: ['POST'])]
    public function deleteTempImage(Request $request)
    {
        $fileName = json_decode($request->getContent())->filename;

        if (!$fileName) {
            return new JsonResponse("missing filename data", 400);
        }

        $path = $this->getParameter('kernel.project_dir') . '/public/uploads/temp_content_blocks_image/' . $fileName;

        if (file_exists($path)) {
            if (unlink($path)) {
                echo "Le fichier a été supprimé avec succès.";
            } else {
                echo "Erreur lors de la suppression du fichier.";
            }
        }

        return new JsonResponse();
    }
}
