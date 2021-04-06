<?php
namespace App\Tests\FunctionalTests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoginControllerTest extends WebTestCase {

    public function renderTest() {
        $client = static::createClient();
        $client->request('GET', '/login');

        $this->assertResponseIsSuccessful('Response ok');
        $this->assertStringContainsString('Please sign in', $client->getResponse()->getContent(), 'String ok');
    }
}