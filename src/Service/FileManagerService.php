<?php

namespace App\Service;

use JetBrains\PhpStorm\Pure;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class FileManagerService
{
    private string $postImageDirectory;

    /**
     * @param string $postImageDirectory
     */
    public function __construct(string $postImageDirectory = "\\storage\\")
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
     * @throws \Exception
     */
    public function imagePostUpload(string $file): string
    {
        $fileName = uniqid();

        try {
            $fileDecode = base64_decode($file);
            file_put_contents(__DIR__ . $this->getPostImageDirectory() . $fileName, $fileDecode);
        } catch (FileException $exception) {
            throw new \Exception($exception);
        }

        return $fileName;
    }

    #[Pure] public function getImage(string $fileName): string | null
    {
        $file = file_get_contents(__DIR__ . $this->getPostImageDirectory() . $fileName);
        return base64_encode($file);
    }
}
