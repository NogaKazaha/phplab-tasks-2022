<?php

use PHPUnit\Framework\TestCase;

class SayHelloArgumentWrapperTest extends TestCase
{
    protected $functions;

    protected function setUp(): void
    {
        $this->functions = new functions\Functions();
    }

    public function exceptionValuesProvider(): array
    {
        return [
            [null],
            [new \stdClass()],
            [1.1],
            [array()],
            [new \DateTime()],
        ];
    }


    /**
     * @dataProvider exceptionValuesProvider
     * @expectedException \InvalidArgumentException
     */
    public function testException($exceptionValuesProvider)
    {
        $this->expectException(InvalidArgumentException::class);

        $this->functions->sayHelloArgumentWrapper($exceptionValuesProvider);
    }
}