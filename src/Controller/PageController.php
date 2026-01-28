<?php

namespace App\Controller;

use App\Repository\MenuSectionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PageController extends AbstractController
{

    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('page/index.html.twig');
    }

    #[Route('/carte', name: 'menu')]
    public function menu(MenuSectionRepository $menuSectionRepo): Response
    {
        $sections = $menuSectionRepo->findBy([], ['position' => 'ASC']);

        return $this->render('page/menu.html.twig', [
            'sections' => $sections
        ]);
    }

    #[Route('/reservation', name: 'reservation')]
    public function reservation(): Response
    {
        return $this->render('page/reservation.html.twig');
    }

    #[Route('/informations', name: 'informations')]
    public function informations(): Response
    {
        return $this->render('page/informations.html.twig');
    }

    #[Route('/jeux', name: 'games')]
    public function games(): Response
    {
        return $this->render('page/games.html.twig');
    }

}
