<?php

namespace App\Service;


use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CookieService
{
    public function sendCookie(string $key, $value): void
    {
        $cookie = new Cookie($key, $value, time() + ( 7 * 24 * 60 * 60));
        $res = new Response();
        $res->headers->setCookie($cookie);
        $res->send();
    }

    public function clearCookie(string $cookie): void
    {
        $res = new Response();
        $res->headers->clearCookie($cookie);
        $res->send();
    }

    public function getCookie(string $key)
    {

//        $res = new Response();
//        $cookie = new Cookie();
//
//        return
    }

    public function checkApiToken(Request $request): bool
    {
        $cookieApiToken = $request->cookies->get('apiToken');
        $sessionApiToken = $request->getSession()->get('apiToken');
        return $cookieApiToken == $sessionApiToken;
    }
}