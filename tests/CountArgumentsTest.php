<?php 

use PHPUnit\Framework\TestCase;

class CountArgumentsTest extends TestCase
{
    protected $functions;

    protected function setUp(): void
    {
        $this->functions = new functions\Functions();
    }

    /**
     * @dataProvider positiveDataProvider
     */
    public function testPositive($input, $expected)
    {   
        if(is_array($input)) {
            $this->assertEquals($expected, $this->functions->countArguments(...$input));
        } else if (!$input) {
            $this->assertEquals($expected, $this->functions->countArguments());
        } else {
            $this->assertEquals($expected, $this->functions->countArguments($input));
        }
    }

    public function positiveDataProvider(): array
    {
        return [
            [null, [
                'argument_count' => 0,
                'argument_values' => [],
            ]],
            ['string', [
                'argument_count' => 1,
                'argument_values' => ['string'],
            ]],
            [['string1', 'string2'], [
                'argument_count' => 2,
                'argument_values' => ['string1', 'string2'],
            ]],
        ];
    }
}