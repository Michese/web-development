<?php

namespace App\Service;

use GdImage;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileManagerService
{
    /**
     * @var string
     */
    private $postImageDirectory;

    /**
     * @param string $postImageDirectory
     */
    public function __construct(string $postImageDirectory = 'storage/')
    {
        $this->postImageDirectory = $postImageDirectory;
    }

    /**
     * @return mixed
     */
    public function getPostImageDirectory(): string
    {
        return $this->postImageDirectory;
    }


    public function imagePostUpload(string $file): string
    {
        $fileName = uniqid();

        try {
            $fileDecode = base64_decode($file);
            file_put_contents($this->getPostImageDirectory() . $fileName, $fileDecode);
        } catch (FileException $exception) {
            throw new \Exception($exception);
        }

        return $fileName;
    }

    public function getImage(string $fileName): string | null
    {
        $file = file_get_contents($this->getPostImageDirectory() . $fileName);
        return base64_encode($file);
    }
}