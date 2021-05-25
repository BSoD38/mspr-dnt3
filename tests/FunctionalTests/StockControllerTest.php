<?php
namespace App\Tests\FunctionalTests;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Classe pour tester le controller de la page de gestion des stocks
 */
class StockControllerTest extends WebTestCase {

    /**
     * Un test permettant de verifier que l'url de la page de gestion des stocks est accessible et qu'elle contient le texte 'Liste des objets du stock'.
     * Il faut simuler une connexion à un compte utilisateur pour pouvoir accéder à cette url
     */
    public function testRender() {
        $client = static::createClient();
        $userRepository = static::$container->get(UserRepository::class);
        $user = $userRepository->findOneByEmail('remy@yahoo.fr');
        $client->loginUser($user);
        $client->request('GET', '/stock');

        $this->assertResponseIsSuccessful();
        $this->assertStringContainsString('Liste des objets du stock', $client->getResponse()->getContent());
    }
}