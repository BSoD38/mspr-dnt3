<?php
namespace App\Tests\FunctionalTests;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Classe pour tester le controller de la page des ressources humaines
 */
class RHControllerTest extends WebTestCase {

    /**
     * Un test permettant de verifier que l'url de la page des ressources humaines est accessible et qu'elle contient le texte 'Gestion des services et des salariés'.
     * Il faut simuler une connexion à un compte utilisateur pour pouvoir accéder à cette url
     */
    public function testRender() {
        $client = static::createClient();
        $userRepository = static::$container->get(UserRepository::class);
        $user = $userRepository->findOneByEmail('remy@yahoo.fr');
        $client->loginUser($user);
        $client->request('GET', '/rh');

        $this->assertResponseIsSuccessful();
        $this->assertStringContainsString('Gestion des services et des salariés', $client->getResponse()->getContent());
    }
}