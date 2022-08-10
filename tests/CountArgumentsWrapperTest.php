<?php

use PHPUnit\Framework\TestCase;

class CountArgumentsWrapperTest extends TestCase
{
    protected $functions;

    protected function setUp(): void
    {
        $this->functions = new functions\Functions();
    }

    public function exceptionValuesProvider(): array
    {
        return [
            [['string1', 'test', null]],
            [[1, 'test2']],
            [[array()]],
            [[new \DateTime()]],
        ];
    }


    /**
     * @dataProvider exceptionValuesProvider
     * @expectedException \InvalidArgumentException
     */
    public function testException($exceptionValuesProvider)
    {
        $this->expectException(InvalidArgumentException::class);

        $this->functions->countArgumentsWrapper($exceptionValuesProvider);
    }
}