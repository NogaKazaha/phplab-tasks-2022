<?php

namespace strings;

class Strings implements StringsInterface {

    /**
     * @param string $input
     * @return string
     */
    public function snakeCaseToCamelCase(string $input): string {
        $input = explode('_', $input);

        for ($i = 1; $i < count($input); $i++) {
            $input[$i] = ucfirst($input[$i]);
        }

        return implode('', $input);
    }

    /**
     * @param string $input
     * @return string
     */
    public function mirrorMultibyteString(string $input): string {
        $input = explode(' ', $input);

        foreach($input as $key => $value) {
            $encoding = mb_detect_encoding($value);
            $length   = mb_strlen($value, $encoding);
            $reversed = '';

            while ($length-- > 0) {
                $reversed .= mb_substr($value, $length, 1, $encoding);
            }
            
            $input[$key] = $reversed;
        }

        return implode(' ', $input);
    }

    /**
     * @param string $noun
     * @return string
     */
    public function getBrandName(string $noun): string {
        $firstLetter = mb_substr($noun, 0, 1);
        $lastLetter  = mb_substr($noun, -1);

        if ($firstLetter === $lastLetter) {
            return ucfirst(substr($noun, 0, -1) . $noun);
        }

        return 'The ' . ucfirst($noun);
    }
}