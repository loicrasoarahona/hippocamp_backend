<?php

namespace App\Controller;

use App\Entity\Course;
use App\Entity\CoursePart;
use App\Service\CourseService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/normal_api/courses')]
class CourseController extends AbstractController
{

    public function __construct(
        private EntityManagerInterface $em,
        private SerializerInterface $serializer,
        private CourseService $courseService
    ) {}

    #[Route('/nb_students', methods: ['GET'])]
    public function nbStudents(Request $request)
    {
        $course_id = $request->query->get('course_id');
        if (empty($course_id))
            return new JsonResponse("empty course_id parameter", 400);

        $course = $this->em->getRepository(Course::class)->find($course_id);
        if (empty($course))
            return new JsonResponse("course not found", 500);

        $retour = $this->courseService->getNbStudents($course);
        return new JsonResponse($retour);
    }

    #[Route('/student_course_statistic', methods: ['GET'])]
    public function studentCourseStatistic()
    {
        $retour = $this->courseService->getStudentCourseStatistic();
        $normalized = $this->serializer->normalize($retour);

        return new JsonResponse($normalized);
    }

    #[Route('/average_rating', methods: ['GET'])]
    public function findAverageRating(Request $request)
    {
        $course_id = $request->query->get('course_id');

        if (empty($course_id))
            return new JsonResponse("Empty course_id param", 400);

        $course = $this->em->getRepository(Course::class)->find($course_id);
        if (empty($course)) {
            return new JsonResponse("course not found");
        }

        $retour = $this->courseService->getAverageRating($course);

        return new JsonResponse($retour);
    }

    #[Route('/first_course_part', methods: ['GET'])]
    public function findFirstCoursePart(Request $request)
    {
        $courseId = $request->query->get('course_id');

        if (empty($courseId)) {
            return new JsonResponse("Empty course_id", 400);
        }

        $parts = $this->em->getRepository(CoursePart::class)->createQueryBuilder('part')
            ->where('part.course=:course_id')
            ->setParameter('course_id', $courseId)
            ->orderBy('part.yIndex', 'ASC')
            ->addOrderBy('part.id', 'ASC')
            ->getQuery()
            ->getResult();

        if (!empty($parts)) {
            $retour = $parts[0];
            $normalized = $this->serializer->normalize($retour);
            return new JsonResponse($normalized);
        }

        return new JsonResponse(null);
    }

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

    #[Route('/upload_video', methods: ['POST'])]
    public function uploadVideo(Request $request)
    {
        $video = $request->files->get('video');

        if ($video) {
            // vérifier le dossier et le créer s'il n'existe pas
            $uploadDir = $this->getParameter('kernel.project_dir') . '/public/uploads/videos';
            if (!is_dir($uploadDir)) {
                if (!mkdir($uploadDir, 0775, true) && !is_dir($uploadDir)) {
                    return new JsonResponse(['error' => 'Failed to create upload directory'], 500);
                }
            }


            $originalFilename = pathinfo($video->getClientOriginalName(), PATHINFO_FILENAME);
            $newFilename = uniqid() . '.' . $video->guessExtension();

            try {
                $video->move($uploadDir, $newFilename);
            } catch (FileException $e) {
                return $this->json(['error' => 'Erreur lors de l\'upload'], 500);
            }

            return $this->json(['success' => true, 'filename' => $newFilename]);
        }

        return $this->json(['error' => 'Fichier non trouvé'], 400);
    }

    #[Route('/delete_video', methods: ['POST'])]
    public function deleteTempImage(Request $request)
    {
        $fileName = json_decode($request->getContent())->filename;

        if (!$fileName) {
            return new JsonResponse("missing filename data", 400);
        }

        $path = $this->getParameter('kernel.project_dir') . '/public/uploads/videos/' . $fileName;

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
