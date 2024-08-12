<?php

namespace App\Controller;

use App\Repository\EvcProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
#[Route('/image', name: 'app_image_')]
class ImageController extends AbstractController
{

    public function __construct(
        protected EntityManagerInterface $entityManager,
        protected EvcProductRepository $prodRepo
    ){

    }

    #[Route('/upload', name: 'upload', methods: ['POST'])]
    public function upload(Request $request): JsonResponse
    {
        $data = $request->request->all();
        $files = $request->files->all();
        $fileNames = [];
        foreach ($files['files'] as $file) {
            // Example: Move the file to a directory
            $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $newFilename = uniqid().'-'.$this->sanitizeString($originalFilename).".".$file->guessExtension();
            array_push($fileNames, $newFilename);
            try {
                $file->move(
                    $data['folder'],
                    $newFilename
                );
            } catch (FileException $e) {
                return new JsonResponse(['status' => 'error', 'message' => 'File upload failed'], 500);
            }
        }
        $this->{$data['entity']."Update"}(id: $data['id'], fileNames: $fileNames,folder: $data['folder']);
        return $this->json($data);
    }

    public function EvcProductUpdate($id, array $fileNames, string $folder){
        $entity = $this->prodRepo->find($id);
        $images = $entity->getProdImage();
        foreach ($fileNames as $fileName) {
            array_push($images,$folder."/".$fileName);
        }
        $entity->setProdImage($images);
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }

    function sanitizeString(string $input): string {
        $normalized = iconv('UTF-8', 'ASCII//TRANSLIT', $input);
        $sanitized = preg_replace('/[^a-zA-Z0-9\s]/', '', $normalized);
        $sanitized = preg_replace('/\s+/', '-', $sanitized);
        $sanitized = strtolower($sanitized);
        return trim($sanitized, '-');
    }
}