<?php

namespace strings;

class Strings implements StringsInterface {
    const ZERO_INDEX = 0;
    const ONE_INDEX = 1;
    const LAST_CHAR_INDEX = -1;
    const ENC_1251 = 'windows-1251';

    /**
     * @param string $input
     * @return string
     */
    public function snakeCaseToCamelCase(string $input): string {

        return preg_replace_callback(
            '/_(.)/',
            function($match) {
                var_dump($match);
                return strtoupper($match[self::ONE_INDEX]); // getting the char after _
            },
            $input
        );
    }

    /**
     * @param string $input
     * @return string
     */
    public function mirrorMultibyteString(string $input): string {
        $input = explode(' ', $input);

        $result = array_map(function($value) {
            $encoding = mb_detect_encoding($value);
            $str = iconv($encoding, self::ENC_1251,$value);
            $string = strrev($str);
            return $str = iconv(self::ENC_1251, $encoding, $string);
        }, $input);

        return implode(' ', $result);
    }

    /**
     * @param string $noun
     * @return string
     */
    public function getBrandName(string $noun): string {
        $firstLetter = mb_substr($noun, self::ZERO_INDEX, self::ONE_INDEX);  // getting first letter of noun
        $lastLetter  = mb_substr($noun, self::LAST_CHAR_INDEX);              // getting last letter of noun

        if ($firstLetter === $lastLetter) {
            return ucfirst(substr($noun, self::ZERO_INDEX, self::LAST_CHAR_INDEX) . $noun);
        }

        return 'The ' . ucfirst($noun);
    }
}