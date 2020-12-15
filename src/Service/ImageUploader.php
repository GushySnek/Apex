<?php


namespace App\Service;


use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class ImageUploader
{
    private $imagesPath;

    public function __construct($imagesPath)
    {
        $this->imagesPath = $imagesPath;
    }


    public function uploadFilesFromForm(FormInterface $form)
    {
        $skillsForm = $form->get('skills');
        foreach ($skillsForm as $skillForm) {
            $this->uploadOneFileFromForm($skillForm);
        }
    }

    public function uploadOneFileFromForm(FormInterface $form)
    {
        $imageFile = $form->get('image')->getData();
        if ($imageFile) {
            $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
            // this is needed to safely include the file name as part of the URL
            $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
            $newFilename = $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();

            // Move the file to the directory where brochures are stored
            try {
                $imageFile->move(
                    $this->imagesPath,
                    $newFilename
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }
            $form->getData()->setImage($newFilename);
        }
    }
}