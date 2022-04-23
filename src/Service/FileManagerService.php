<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class FileManagerService
{
    private $targetDirectory;
    private $slugger;

    public function __construct($targetDirectory, SluggerInterface $slugger)
    {
        $this->targetDirectory = $targetDirectory;
        $this->slugger = $slugger;
    }

    public function upload(UploadedFile $file): string
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $fileName = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();

        $file->move($this->getTargetDirectory(), $fileName);

        return '\uploads\\' . $fileName;
    }

    public function delete(string $fileName): bool
    {
        $uploadFile = $this->load($fileName);
        return unlink($uploadFile);
    }

    public function load(string $fileName): UploadedFile
    {
        return new UploadedFile($this->getTargetDirectory() . $fileName, $fileName);
    }

    public function getTargetDirectory()
    {
        return $this->targetDirectory;
    }
}