<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\String\Slugger\SluggerInterface;

class ImageUploader
{
    private $slugger;
    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function upload($form, string $fieldName)
    {
        /** @var UploadedFile $imgFile */
        $imgFile = $form->get($fieldName)->getData();

        if ($imgFile) {
            $originalFilename = pathinfo($imgFile->getClientOriginalName(), PATHINFO_FILENAME);

            $safeFilename = $this->slugger->slug($originalFilename);

            
            $newFile = $safeFilename . '-' . uniqid() . '.' . $imgFile->guessExtension();

            try {
                $imgFile->move('uploads', $newFile);

                return $newFile;
            } catch (FileException $e) {
            }

            return false;
        }
    }
}
