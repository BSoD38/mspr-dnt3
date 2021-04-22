<?php
namespace App\Tests\FunctionalTests;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Classe pour tester le controller de la page d'accueil
 */
class HomeControllerTest extends WebTestCase {

    /**
     * Un test permettant de verifier que l'url de la page d'accueil est accessible et qu'elle contient le texte 'Bonjour'. Il faut simuler une connexion à un compte utilisateur
     * pour pouvoir accéder à cette url
     */
    public function testRender() {
        $client = static::createClient();
        $userRepository = static::$container->get(UserRepository::class);
        $user = $userRepository->findOneByEmail('remy@yahoo.fr');
        $client->loginUser($user);
        $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertStringContainsString('Bonjour', $client->getResponse()->getContent());
    }
}