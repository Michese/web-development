<?php

namespace App\Service;

class ApiTokenService
{
    public function create(): string
    {
        return hash('sha256', rand());
    }
}