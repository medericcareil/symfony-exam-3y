<?php

namespace App\Controller;

use App\Repository\VideoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @var VideoRepository
     */
    private VideoRepository $videoRepository;

    public function __construct(VideoRepository $videoRepository) {
        $this->videoRepository = $videoRepository;
    }

    /**
     * @Route("/", name="home")
     */
    public function home(): Response
    {
        return $this->render('home/index.html.twig', [
            'videos' => $this->videoRepository->findAll(),
        ]);
    }
}
