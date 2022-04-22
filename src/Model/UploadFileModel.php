<?php

namespace App\Model;

use Symfony\Component\Validator\Constraints as Assert;

class UploadFileModel
{
    /**
     * @Assert\NotBlank()
     */
    public $filename;
    /**
     * @Assert\NotBlank()
     */
    public $data;
}