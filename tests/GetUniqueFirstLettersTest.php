<?php

use PHPUnit\Framework\TestCase;

class GetUniqueFirstLettersTest extends TestCase
{
    public function testGetUniqueFirstLetters()
    {
        $testArray = [
            [
                'name' => 'Andorra la Vella'
            ], 
            [
                'name' => 'Kabul'
            ], 
            [
                'name' => 'Baku'
            ], 
            [
                'name' => 'Tirana'
            ], 
            [
                'name' => 'Yerevan'
            ]
        ];
        $uniqueFirstLetters = getUniqueFirstLetters($testArray);
        $this->assertEquals(['A', 'B', 'K', 'T', 'Y'], $uniqueFirstLetters);
    }
}