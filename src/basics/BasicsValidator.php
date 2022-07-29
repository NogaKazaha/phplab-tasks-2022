<?php

namespace basics;

class BasicsValidator implements BasicsValidatorInterface {

    /**
     * @param int $minute
     * @throws \InvalidArgumentException
     */
    public function isMinutesException(int $minute): void {
        if ($minute < 0 || $minute > 60) {
            throw new \InvalidArgumentException('Minute must be between 0 and 60');
        }
    }
    
    /**
     * @param int $year
     * @throws \InvalidArgumentException
     */
    public function isYearException(int $year): void {
        if ($year < 1900) {
            throw new \InvalidArgumentException('Year must be greater than 0');
        }
    }
    
    /**
     * @param string $input
     * @throws \InvalidArgumentException
     */
    public function isValidStringException(string $input): void {
        if (strlen($input) !== 6) {
            throw new \InvalidArgumentException('Input must be 6 characters or less');
        }
    }
}