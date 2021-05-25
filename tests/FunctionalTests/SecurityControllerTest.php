<?php
namespace App\Tests\FunctionalTests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Classe pour tester le controller de sécurité
 */
class SecurityControllerTest extends WebTestCase {

    /**
     * Un test permettant de verifier que l'url de la page de login est accessible et qu'elle contient le texte 'Connectez-vous'
     */
    public function testRender() {
        $client = static::createClient();
        $client->request('GET', '/login');

        $this->assertResponseIsSuccessful();
        $this->assertStringContainsString('Connectez-vous', $client->getResponse()->getContent());
    }
}