<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class NewItemsControllerTest extends WebTestCase
{
    public function testHomePage(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');
        $this->assertResponseIsSuccessful();
        $this->assertPageTitleContains('Новости!');
        $this->assertResponseNotHasCookie('PHPSESSID');
        $this->assertSelectorExists('#app');
    }

    public function testNewItemPage(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/new/1');
        $this->assertResponseIsSuccessful();
        $this->assertPageTitleContains('Новости!');
        $this->assertResponseNotHasCookie('PHPSESSID');
        $this->assertSelectorExists('#app');
    }
}
