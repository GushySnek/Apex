<?php


namespace App\Controller;


use App\Entity\Comment;
use App\Entity\Contact;
use App\Entity\Hero;
use App\Entity\News;
use App\Entity\User;
use App\Entity\Weapon;
use App\Form\CommentType;
use App\Form\ContactType;
use App\Form\RegisterType;
use App\Search\Search;
use App\Form\SearchFormType;
use App\Repository\HeroRepository;
use App\Repository\NewsRepository;
use App\Repository\WeaponRepository;
use App\Service\ImageUploader;
use App\Service\MenuGenerator;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class DefaultController extends AbstractController
{

    /**
     * @Route("/", name="home")
     * @param Request $request
     * @param HeroRepository $heroRepository
     * @param WeaponRepository $weaponRepository
     * @param NewsRepository $newsRepository
     * @return Response
     */

    public function home(Request $request, HeroRepository $heroRepository, WeaponRepository $weaponRepository, NewsRepository $newsRepository)
    {
        $searchQuery = new Search();
        $form = $this->createForm(SearchFormType::class, $searchQuery);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $heroes = $heroRepository->findSearchResults($searchQuery);
            $weapons = $weaponRepository->findSearchResults($searchQuery);
            $newsList = $newsRepository->findSearchResults($searchQuery);
            return $this->render("page/search-results.html.twig", ["heroes" => $heroes, "weapons" => $weapons, "newsList" => $newsList]);
        }

        $newsList = $newsRepository->findWithLimit(3);
        return $this->render("page/home.html.twig", ['form' => $form->createView(), 'newsList' => $newsList]);
    }

    /**
     * @Route("/heroes", name="heroes")
     * @param HeroRepository $heroRepository
     * @param MenuGenerator $menuGenerator
     * @return Response
     */

    public function heroes(HeroRepository $heroRepository, MenuGenerator $menuGenerator)
    {
        $result = $heroRepository->findAll();

        $menu = $menuGenerator->generateHeroesMenu('heroesTag');

        return $this->render('page/characters.html.twig', ['heroes' => $result, 'menu' => $menu]);
    }

    /**
     * @Route("/heroes/{slug}", name="heroesShow")
     * @param Hero $hero
     * @param HeroRepository $heroRepository
     * @param MenuGenerator $menuGenerator
     * @return Response
     */

    public function heroesShow(Hero $hero, HeroRepository $heroRepository, MenuGenerator $menuGenerator)
    {
        $heroes = $heroRepository->findAll();

        $menu = $menuGenerator->generateHeroesMenu('heroesTag');

        return $this->render("page/characters.html.twig", ['heroes' => $heroes, 'heroDetails' => $hero, 'menu' => $menu]);
    }

    /**
     * @Route("/heroesTag/{name}", name="heroesTag")
     * @param $name
     * @param HeroRepository $heroRepository
     * @param MenuGenerator $menuGenerator
     * @return Response
     */

    public function heroesTag($name, HeroRepository $heroRepository, MenuGenerator $menuGenerator)
    {
        $heroes = $heroRepository->findByTag($name);

        $menu = $menuGenerator->generateHeroesMenu('heroesTag');

        return $this->render("page/characters.html.twig", ['heroes' => $heroes, 'menu' => $menu]);
    }

    /**
     * @Route("/weapons", name="weapons")
     * @param WeaponRepository $weaponRepository
     * @param MenuGenerator $menuGenerator
     * @return Response
     */

    public function weapons(WeaponRepository $weaponRepository, MenuGenerator $menuGenerator)
    {
        $result = $weaponRepository->findAll();

        $menu = $menuGenerator->generateWeaponsMenu('weaponsTag');

        return $this->render('page/weapons.html.twig', ['weapons' => $result, 'menu' => $menu]);
    }

    /**
     * @Route("/weapons/{slug}", name="showWeapon")
     * @param Weapon $weapon
     * @param WeaponRepository $weaponRepository
     * @param MenuGenerator $menuGenerator
     * @return Response
     */

    public function showWeapon(Weapon $weapon, WeaponRepository $weaponRepository, MenuGenerator $menuGenerator)
    {
        $result = $weaponRepository->findAll();

        $menu = $menuGenerator->generateWeaponsMenu('weaponsTag');

        return $this->render('page/weapons.html.twig', ['weapons' => $result, 'weaponDetails' => $weapon, 'menu' => $menu]);
    }

    /**
     * @Route("/weaponsTag/{name}", name="weaponsTag")
     * @param $name
     * @param WeaponRepository $weaponRepository
     * @param MenuGenerator $menuGenerator
     * @return Response
     */

    public function weaponsTag($name, WeaponRepository $weaponRepository, MenuGenerator $menuGenerator)
    {
        $result = $weaponRepository->findByTag($name);

        $menu = $menuGenerator->generateWeaponsMenu('weaponsTag');

        return $this->render('page/weapons.html.twig', ['weapons' => $result, 'menu' => $menu]);
    }

    /**
     * @Route("/news/{page<\d+>}", name="news")
     * @param int $page
     * @param NewsRepository $newsRepository
     * @param PaginatorInterface $paginator
     * @param MenuGenerator $menuGenerator
     * @return Response
     */

    public function news($page = 1, NewsRepository $newsRepository, PaginatorInterface $paginator, MenuGenerator $menuGenerator)
    {
        $result = $newsRepository->findAll();
        $featured = array_shift($result);

        $page = $paginator->paginate(
            $result,
            $page,
            3
        );

        $menu = $menuGenerator->generateNewsMenu('newsTag');

        return $this->render('page/news.html.twig', ['newsList' => $page, 'featured' => $featured, 'menu' => $menu]);
    }

    /**
     * @Route("/news/{name}/{page<\d+>}", name="newsTag")
     * @param $name
     * @param int $page
     * @param NewsRepository $newsRepository
     * @param PaginatorInterface $paginator
     * @param MenuGenerator $menuGenerator
     * @return Response
     */

    public function newsTag($name, $page = 1, NewsRepository $newsRepository, PaginatorInterface $paginator, MenuGenerator $menuGenerator)
    {
        $result = $newsRepository->findByTag($name);
        $featured = array_shift($result);

        $page = $paginator->paginate(
            $result,
            $page,
            3
        );

        $menu = $menuGenerator->generateNewsMenu('newsTag');

        return $this->render('page/news.html.twig', ['newsList' => $page, 'featured' => $featured, 'menu' => $menu]);
    }

    /**
     * @Route("/news-details/{slug}", name="news-details")
     * @param Request $request
     * @param News $news
     * @param EntityManagerInterface $entityManager
     * @return Response
     */

    public function newsDetails(Request $request, News $news, EntityManagerInterface $entityManager)
    {
        $comment = new Comment();
        $comment->setNewsId($news);
        $comment->setUserId($this->getUser());
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($comment);
            $entityManager->flush();

            return $this->redirectToRoute("news-details", ['slug' => $news->getSlug()]);
        }

        return $this->render('page/news-details.html.twig', ['news' => $news, 'form' => $form->createView()]);
    }

    /**
     * @Route("/deleteComment/{slug}/{id<\d+>}", name="deleteComment")
     * @param $slug
     * @param Comment $comment
     * @param EntityManagerInterface $entityManager
     * @return Response
     */

    public function deleteComment($slug, Comment $comment, EntityManagerInterface $entityManager)
    {
        $entityManager->remove($comment);
        $entityManager->flush();

        return $this->redirectToRoute("news-details", ['slug' => $slug]);
    }

    /**
     * @Route("/contact", name="contact")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return RedirectResponse|Response
     */

    public function contact(Request $request, EntityManagerInterface $entityManager)
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($contact);
            $entityManager->flush();

            return $this->redirectToRoute("home");
        }

        return $this->render("page/contact.html.twig", ['form' => $form->createView()]);
    }

    /**
     * @Route("/profile-create", name="profile-create")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param UserPasswordEncoderInterface $userPasswordEncoder
     * @param ImageUploader $imageUploader
     * @return RedirectResponse|Response
     */

    public function profileCreate(Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $userPasswordEncoder, ImageUploader $imageUploader)
    {
        $user = new User();
        $user->setRoles(['ROLE_USER']);
        $form = $this->createForm(RegisterType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageUploader->uploadOneFileFromForm($form);
            $user->setPassword($userPasswordEncoder->encodePassword($user, $user->getPassword()))
                 ->eraseCredentials();

            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('home');
        }

        return $this->render('page/profile-create.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/profile/edit", name="profileEdit")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param UserPasswordEncoderInterface $userPasswordEncoder
     * @param ImageUploader $imageUploader
     * @return RedirectResponse|Response
     */

    public function profileEdit(Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $userPasswordEncoder, ImageUploader $imageUploader)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_REMEMBERED');

        $user = $this->getUser();
        $form = $this->createForm(RegisterType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageUploader->uploadOneFileFromForm($form);
            $user->setPassword($userPasswordEncoder->encodePassword($user, $user->getPassword()))
                 ->eraseCredentials();

            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('home');
        }

        return $this->render('page/profile-create.html.twig', ['form' => $form->createView()]);
    }
}