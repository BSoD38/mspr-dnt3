<?php


namespace App\Tests\UnitTests;


use App\Entity\Stock;
use PHPUnit\Framework\TestCase;

/**
 * Classe pour tester les méthodes liées à la gestion des stocks
 */
class StockTest extends TestCase
{
    /**
     * Un test de la fonction calculatePrice(). On vérifie qu'un objet ayant un prix unitaire de 6€ et une quantité de 11 coûtera bien au total 66€
     */
    public function testCalculatePrice()
    {
        $stock = new Stock();
        $stock->setPrice(6);
        $stock->setCount(11);
        $this->assertEquals(66, $stock->calculatePrice());
    }
}