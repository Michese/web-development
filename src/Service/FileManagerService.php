<?php

namespace App\Service;

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
    public function __construct(string $postImageDirectory)
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

    /**
     * @param UploadedFile $file
     * @return string
     * @throws \Exception
     */
    public function imagePostUpload(UploadedFile $file): string
    {
        $fileName = uniqid() . '.' . $file->guessExtension();

        try {
            $file->move($this->getPostImageDirectory(), $fileName);
        } catch (FileException $exception) {
            throw new \Exception($exception);
        }

        return $fileName;
    }

}