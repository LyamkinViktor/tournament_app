<?php

namespace App\Controller;

use App\Repository\TournamentRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainPageController extends AbstractController
{
    private int $tournamentsPerPage = 3;

    /**
     * @Route("/", name="app_main_page")
     */
    public function index(TournamentRepository $tournamentRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $tournamentsQuery = $tournamentRepository->findAllQuery();

        $pagination = $paginator->paginate(
            $tournamentsQuery,
            $request->query->getInt('page', 1),
            $this->tournamentsPerPage
        );

        return $this->render('main_page/index.html.twig', [
            'controller_name' => 'MainPageController',
            'pagination' => $pagination,
        ]);
    }
}
