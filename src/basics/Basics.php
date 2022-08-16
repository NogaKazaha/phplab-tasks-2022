<?php

namespace basics;

class Basics implements BasicsInterface {
    const FIRST_THREE_START_INDEX = 0;
    const FIRST_THREE_END_INDEX = 3;
    const LAST_THREE_INDEX = -3;

    /**
     * @var BasicsValidator
     */
    private $validator;
    
    public function __construct(BasicsValidator $validator) {
        $this->validator = $validator;
    }

    /**
     * @param int $minute
     * @return string
     * @throws \InvalidArgumentException
     */
    public function getMinuteQuarter(int $minute): string {
        $this->validator->isMinutesException($minute);
        
        if ($minute > 0 && $minute <= 15) {
            return 'first';
        } 
        
        if ($minute > 15 && $minute <= 30) {
            return 'second';
        } 
        
        if ($minute > 30 && $minute <= 45) {
            return 'third';
        } 
        
        if ($minute > 45 && $minute <= 59 || $minute == 0) {
            return 'fourth';
        }
    }

    /**
     * @param int $year
     * @return bool
     * @throws \InvalidArgumentException
     */
    public function isLeapYear(int $year): bool {
        $this->validator->isYearException($year);

        return date('L', strtotime("$year-01-01")) ? true : false;
    }

    /**
     * @param string $input
     * @return bool
     * @throws \InvalidArgumentException
     */
    public function isSumEqual(string $input): bool {
        $this->validator->isValidStringException($input);
        
        $firstStr = substr($input, self::FIRST_THREE_START_INDEX, self::FIRST_THREE_END_INDEX);
        $secondStr = substr($input, self::LAST_THREE_INDEX);

        $firstSum = array_sum(str_split($firstStr));
        $secondSum = array_sum(str_split($secondStr));

        return $firstSum === $secondSum ? true : false;
    }
}