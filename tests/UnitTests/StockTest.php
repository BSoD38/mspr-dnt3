<?php


namespace App\Tests\UnitTests;


use App\Entity\Stock;
use PHPUnit\Framework\TestCase;

class StockTest extends TestCase
{
    public function testCalculatePrice()
    {
        $stock = new Stock();
        $stock->setPrice(6);
        $stock->setCount(11);
        $this->assertEquals(66, $stock->calculatePrice());
    }
}