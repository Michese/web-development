<?php

namespace App\Tests\Api;


use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;

class NewItemsApiTest extends ApiTestCase
{
    /**
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     */
    public function testNewItemGetCollection(): void
    {
        $response = static::createClient()->request('GET', '/api/new_items?page=1');
        $this->assertResponseIsSuccessful();
        $answerArray = $response->toArray();
        $this->assertIsArray($answerArray);
        $this->assertArrayHasKey('hydra:member', $answerArray);
        $resultArray = $answerArray['hydra:member'];
        $this->assertIsArray($resultArray);
        $this->assertCount(3, $resultArray);
        $this->assertArrayHasKey('hydra:totalItems', $answerArray);
        $totalItems = $answerArray['hydra:totalItems'];
        $this->assertIsInt($totalItems);
        $this->assertEquals(3, $totalItems);
        $this->assertJsonContains(['@id' => '/api/new_items']);
    }

    /**
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     */
    public function testNewItemPostItem(): void
    {
        $response = static::createClient()->request('POST', '/api/login', ['json' => ['email' => 'michese@mail.ru', 'password' => 'qwer1234']]);
        $responseArray = $response->toArray();
        $token = $responseArray['token'];

        $errorResponse = static::createClient()->request('POST', '/api/new_items', [
            'json' => $this->postData()]);

        $this->assertEquals(401, $errorResponse->getStatusCode());

        $errorResponse = static::createClient()->request('POST', '/api/new_items', [
            'headers' => ['Authorization' => "Bearer $token"],
            'json' => $this->postErrorData()]);

        $this->assertEquals(500, $errorResponse->getStatusCode());

        $response = static::createClient()->request('POST', '/api/new_items', [
            'headers' => ['Authorization' => "Bearer $token"],
            'json' => $this->postData()]);

        $answerArray = $response->toArray();
        $this->assertIsArray($answerArray);
        $this->assertArrayHasKey('result', $answerArray);
        $result = $answerArray['result'];
        $this->assertIsInt($result);
    }

    private function postErrorData(): array
    {
        return [
            'title' => 'test title',
            'description' => 'test description',
            'image' => '\uploads\1.jpg'
        ];
    }

    private function postData(): array
    {
        return [
            'title' => 'test title',
            'description' => 'test description',
            'text' => 'test text',
            'image' => '\uploads\1.jpg'
        ];
    }
}
