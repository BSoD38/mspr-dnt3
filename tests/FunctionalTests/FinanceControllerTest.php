<?php
namespace App\Tests\FunctionalTests;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Classe pour tester le controller de la page finance
 */
class FinanceControllerTest extends WebTestCase {

    /**
     * Un test permettant de verifier que l'url de la page finance est accessible et qu'elle contient le texte 'Dépense total'. Il faut simuler une connexion à un compte utilisateur
     * pour pouvoir accéder à cette url
     */
    public function testRender() {
        $client = static::createClient();
        $userRepository = static::$container->get(UserRepository::class);
        $user = $userRepository->findOneByEmail('remy@yahoo.fr');
        $client->loginUser($user);
        $client->request('GET', '/finance');

        $this->assertResponseIsSuccessful();
        $this->assertStringContainsString('Dépense total', $client->getResponse()->getContent());
    }
}