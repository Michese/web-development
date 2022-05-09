<?php

namespace App\Tests\Api;


use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;

class UserApiTest extends ApiTestCase
{
    /**
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     */
    public function testLogin(): void
    {
        $response = static::createClient()->request( 'POST', '/api/login', [ 'json' => ['email' => 'michese@mail.ru', 'password' => 'qwer1234']]);
        $this->assertResponseIsSuccessful();
        $responseArray = $response->toArray();
        $this->assertIsArray($responseArray);
        $this->assertArrayHasKey('token', $responseArray);
        $token = $responseArray['token'];
        $this->assertIsString($token);
    }
}
