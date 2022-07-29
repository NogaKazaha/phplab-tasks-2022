<?php

namespace basics;

class Basics implements BasicsInterface {

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
            $quater = 'first';
        } elseif ($minute > 15 && $minute <= 30) {
            $quater = 'second';
        } elseif ($minute > 30 && $minute <= 45) {
            $quater = 'third';
        } elseif ($minute > 45 && $minute <= 59 || $minute == 0) {
            $quater = 'fourth';
        }

        return $quater;
    }

    /**
     * @param int $year
     * @return bool
     * @throws \InvalidArgumentException
     */
    public function isLeapYear(int $year): bool {
        $this->validator->isYearException($year);

        if ($year % 4 === 0) {
            if ($year % 100 === 0) {
                if ($year % 400 === 0) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return true;
            }
        } else {
            return false;
        }
    }

    /**
     * @param string $input
     * @return bool
     * @throws \InvalidArgumentException
     */
    public function isSumEqual(string $input): bool {
        $this->validator->isValidStringException($input);
        
        $firstStr = substr($input, 0, 3);
        $secondStr = substr($input, 3, 6);

        $firstSum = array_sum(str_split($firstStr));
        $secondSum = array_sum(str_split($secondStr));

        if ($firstSum === $secondSum) {
            return true;
        } else {
            return false;
        }
    }
}