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
        return $this->render("page/characters.html.twig");
    }

    /**
     * @Route("/weapons", name="weapons")
     */

    public function weapons() {
        return $this->render("page/weapons.html.twig");
    }

    /**
     * @Route("/news", name="news")
     */

    public function news() {
        return $this->render("page/news.html.twig");
    }

    /**
     * @Route("/news-details", name="news-details")
     */

    public function newsDetails() {
        return $this->render("page/news-details.html.twig");
    }

    /**
     * @Route("/contact", name="contact")
     */

    public function contact() {
        return $this->render("page/contact.html.twig");
    }

    /**
     * @Route("/profile-connect", name="profile-connect")
     */

    public function profileConnect() {
        return $this->render("page/profile-connect.html.twig");
    }

    /**
     * @Route("/profile-create", name="profile-create")
     */

    public function profileCreate() {
        return $this->render("page/profile-create.html.twig");
    }

    /**
     * @Route("/profile-edit", name="profile-edit")
     */

    public function profileEdit() {
        return $this->render("page/profile-edit.html.twig");
    }
}