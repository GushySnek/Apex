<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    /**
     * @Route("/", name="home")
     */

    public function home() {
        return $this->render("page/home.html.twig");
    }

    /**
     * @Route("/characters", name="characters")
     */

    public function characters() {
        return $this->render("page/wiki.html.twig");
    }

    /**
     * @Route("/weapons", name="weapons")
     */

    public function weapons() {
        return $this->render("page/wiki.html.twig");
    }

    /**
     * @Route("/news", name="news")
     */

    public function news() {
        return $this->render("page/news.html.twig");
    }
}