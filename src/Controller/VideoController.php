<?php

namespace App\Controller;

use App\Entity\Video;
use App\Form\VideoFormType;
use Symfony\Component\Uid\UuidV4;
use App\Repository\VideoRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class VideoController extends AbstractController
{
    /**
     * @var ManagerRegistry
     */
    private ManagerRegistry $manager;

    /**
     * @var VideoRepository
     */
    private VideoRepository $videoRepository;

    public function __construct(ManagerRegistry $manager, VideoRepository $videoRepository) {
        $this->manager = $manager;
        $this->videoRepository = $videoRepository;
    }

    /**
     * @Route("/create", name="video_create", methods={"GET", "POST"})
     */
    public function create(Request $request): Response
    {
        $form = $this->createForm(VideoFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $em = $this->manager->getManager();
            $em->persist($data);
            $em->flush();

            $response = new Response();
            $response->setStatusCode(Response::HTTP_CREATED);
            $response->setContent('
                <html>
                    <body>
                        <h1>Le film ou la série a été ajouté avec succès</h1>
                    </body>
                </html>
            ');
            return $response;
        }

        return $this->render('video/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/get-all", name="video_get-all", methods={"GET"})
     */
    public function getAll(): JsonResponse
    {
        $videos = $this->videoRepository->findAll();
        $videosDto = [];
        foreach ($videos as $video) {
            $videosDto[] = Video::toArray($video);
        }
        return $this->json($videosDto);
    }

    /**
     * @Route("/get/{id}", name="video_get-by-id", methods={"GET"})
     */
    public function getById(string $id): JsonResponse
    {
        if (!UuidV4::isValid($id)) {
            throw new BadRequestHttpException('Uuid non valide');
        }
        $video = $this->videoRepository->findOneBy(['id' => $id]);
        if (!$video) {
            return $this->createNotFoundException('Le film ou la série que vous cherchez n\'existe pas');
        }
        return $this->json(Video::toArray($video));
    }
}
