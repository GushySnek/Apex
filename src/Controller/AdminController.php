<?php


namespace App\Controller;


use App\Entity\Contact;
use App\Entity\Hero;
use App\Entity\News;
use App\Entity\Tag;
use App\Entity\Weapon;
use App\Form\HeroType;
use App\Form\NewsType;
use App\Form\TagType;
use App\Form\WeaponType;
use App\Repository\ContactRepository;
use App\Repository\HeroRepository;
use App\Repository\NewsRepository;
use App\Repository\TagRepository;
use App\Repository\WeaponRepository;
use App\Service\ImageUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdminController
 * @package App\Controller
 * @Route("admin/")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("weapons/list", name="weaponsList")
     * @param WeaponRepository $weaponRepository
     * @return Response
     */

    public function weaponsList(WeaponRepository $weaponRepository) {
        $list = $weaponRepository->findAll();
        return $this->render('admin/weapons-list.html.twig', ['list' => $list]);
    }

    /**
     * @Route("weapons/create", name="weaponCreate")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param ImageUploader $imageUploader
     * @return Response
     */

    public function weaponCreate(Request $request, EntityManagerInterface $entityManager, ImageUploader $imageUploader) {
        $weapon = new Weapon();
        $form = $this->createForm(WeaponType::class, $weapon);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageUploader->uploadOneFileFromForm($form);

            $this->createWeaponsTag($weapon, $entityManager);

            $entityManager->persist($weapon);
            $entityManager->flush();

            return $this->redirectToRoute("weaponsList");
        }

        return $this->render('admin/weapons-create.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("weapons/edit/{id}", name="weaponEdit")
     * @param Weapon $weapon
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param ImageUploader $imageUploader
     * @return RedirectResponse|Response
     */
    public function weaponEdit(Weapon $weapon, Request $request, EntityManagerInterface $entityManager, ImageUploader $imageUploader) {
        $form = $this->createForm(WeaponType::class, $weapon);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageUploader->uploadOneFileFromForm($form);

            $entityManager->persist($weapon);
            $entityManager->flush();

            return $this->redirectToRoute("weaponsList", ["slug" => $weapon->getSlug()]);
        }

        return $this->render("admin/weapons-create.html.twig", ['form' => $form->createView()]);
    }

    /**
     * @Route("weapons/delete/{id}", name="weaponDelete")
     * @param Weapon $weapon
     * @param EntityManagerInterface $entityManager
     * @return RedirectResponse|Response
     */
    public function weaponDelete(Weapon $weapon, EntityManagerInterface $entityManager) {
        $entityManager->remove($weapon);
        $entityManager->flush();

        return $this->redirectToRoute("weaponsList");
    }

    /**
     * @Route("heroes/list", name="heroesList")
     * @param HeroRepository $characterRepository
     * @return Response
     */
    public function heroesList(HeroRepository $characterRepository) {
        $list = $characterRepository->findAll();
        return $this->render('admin/heroes-list.html.twig', ['list' => $list]);
    }

    /**
     * @Route("heroes/create", name="heroCreate")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param ImageUploader $imageUploader
     * @return Response
     */

    public function heroCreate(Request $request, EntityManagerInterface $entityManager, ImageUploader $imageUploader) {
        $hero = new Hero();
        $form = $this->createForm(HeroType::class, $hero);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageUploader->uploadFilesFromForm($form);
            $imageUploader->uploadOneFileFromForm($form);

            $this->createHeroesTag($hero, $entityManager);

            $entityManager->persist($hero);
            $entityManager->flush();

            return $this->redirectToRoute("heroesList");
        }

        return $this->render('admin/heroes-create.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("heroes/edit/{id}", name="heroEdit")
     * @param Hero $hero
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param ImageUploader $imageUploader
     * @return RedirectResponse|Response
     */
    public function heroEdit(Hero $hero, Request $request, EntityManagerInterface $entityManager, ImageUploader $imageUploader) {
        $form = $this->createForm(HeroType::class, $hero);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageUploader->uploadFilesFromForm($form);
            $imageUploader->uploadOneFileFromForm($form);

            $entityManager->persist($hero);
            $entityManager->flush();

            return $this->redirectToRoute("heroesList", ["slug" => $hero->getSlug()]);
        }

        return $this->render('admin/heroes-create.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("heroes/delete/{id}", name="heroDelete")
     * @param Hero $hero
     * @param EntityManagerInterface $entityManager
     * @return RedirectResponse|Response
     */
    public function heroDelete(Hero $hero, EntityManagerInterface $entityManager) {
        $entityManager->remove($hero);
        $entityManager->flush();

        return $this->redirectToRoute("heroesList");
    }

    /**
     * @Route("news/list", name="newsList")
     * @param NewsRepository $newsRepository
     * @return Response
     */

    public function newsList(NewsRepository $newsRepository) {
        $list = $newsRepository->findAll();
        return $this->render('admin/news-list.html.twig', ['list' => $list]);
    }

    /**
     * @Route("news/create", name="newsCreate")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param ImageUploader $imageUploader
     * @return Response
     */

    public function newsCreate(Request $request, EntityManagerInterface $entityManager, ImageUploader $imageUploader) {
        $news = new News();
        $form = $this->createForm(NewsType::class, $news);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageUploader->uploadOneFileFromForm($form);

            $entityManager->persist($news);
            $entityManager->flush();

            return $this->redirectToRoute("newsList");
        }

        return $this->render('admin/news-create.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("news/edit/{id}", name="newsEdit")
     * @param News $news
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param ImageUploader $imageUploader
     * @return RedirectResponse|Response
     */
    public function newsEdit(News $news, Request $request, EntityManagerInterface $entityManager, ImageUploader $imageUploader) {
        $form = $this->createForm(NewsType::class, $news);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageUploader->uploadOneFileFromForm($form);

            $entityManager->persist($news);
            $entityManager->flush();

            return $this->redirectToRoute("newsList", ["slug" => $news->getSlug()]);
        }

        return $this->render("admin/news-create.html.twig", ['form' => $form->createView()]);
    }

    /**
     * @Route("news/delete/{id}", name="newsDelete")
     * @param News $news
     * @param EntityManagerInterface $entityManager
     * @return RedirectResponse|Response
     */
    public function newsDelete(News $news, EntityManagerInterface $entityManager) {
        $entityManager->remove($news);
        $entityManager->flush();

        return $this->redirectToRoute("newsList");
    }

    /**
     * @Route("tags/list", name="tagsList")
     * @param TagRepository $tagRepository
     * @return Response
     */

    public function tagsList(TagRepository $tagRepository) {
        $list = $tagRepository->findAll();
        return $this->render('admin/tags-list.html.twig', ['list' => $list]);
    }

    /**
     * @Route("tags/create", name="tagsCreate")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return Response
     */

    public function tagsCreate(Request $request, EntityManagerInterface $entityManager) {
        $tag = new Tag();
        $tag->setCategory(true);
        $form = $this->createForm(TagType::class, $tag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($tag);
            $entityManager->flush();

            return $this->redirectToRoute("tagsList");
        }

        return $this->render('admin/tags-create.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("tags/edit/{id}", name="tagsEdit")
     * @param Tag $tag
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return RedirectResponse|Response
     */
    public function tagsEdit(Tag $tag, Request $request, EntityManagerInterface $entityManager) {
        $form = $this->createForm(TagType::class, $tag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($tag);
            $entityManager->flush();

            return $this->redirectToRoute("tagsList");
        }

        return $this->render("admin/tags-create.html.twig", ['form' => $form->createView()]);
    }

    /**
     * @Route("tags/delete/{id}", name="tagsDelete")
     * @param Tag $tag
     * @param EntityManagerInterface $entityManager
     * @return RedirectResponse|Response
     */
    public function tagsDelete(Tag $tag, EntityManagerInterface $entityManager) {
        $entityManager->remove($tag);
        $entityManager->flush();

        return $this->redirectToRoute("tagsList");
    }

    /**
     * @Route("contacts/list", name="contactsList")
     * @param ContactRepository $contactRepository
     * @return Response
     */

    public function contactsList(ContactRepository $contactRepository) {
        $list = $contactRepository->findAll();
        return $this->render('admin/contact-list.html.twig', ['list' => $list]);
    }

    /**
     * @Route("contacts/delete/{id}", name="contactsDelete")
     * @param Contact $contact
     * @param EntityManagerInterface $entityManager
     * @return RedirectResponse|Response
     */
    public function contactsDelete(Contact $contact, EntityManagerInterface $entityManager) {
        $entityManager->remove($contact);
        $entityManager->flush();

        return $this->redirectToRoute("contactsList");
    }

    private function createWeaponsTag(Weapon $weapon, EntityManagerInterface $entityManager) {
        $nameTag = new Tag();
        $nameTag->setName($weapon->getName())
                ->setType('weapons')
                ->setCategory(false);;

        $weapon->setTag($nameTag);

        $entityManager->persist($nameTag);
    }

    private function createHeroesTag(Hero $hero, EntityManagerInterface $entityManager) {
        $nameTag = new Tag();
        $nameTag->setName($hero->getName())
                ->setType('heroes')
                ->setCategory(false);

        $hero->setTag($nameTag);

        $entityManager->persist($nameTag);
    }
}