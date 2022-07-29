<?php

namespace arrays;

class Arrays implements ArraysInterface {

    /**
     * @param array $input
     * @return array
     */
    public function repeatArrayValues(array $input): array {
        $result = [];

        if(empty($input)) {
            return $result;
        }

        foreach ($input as $value) {
            for($i = 0; $i < $value; $i++) {
                $result[] = $value;
            }
        }

        return $result;
    }

    /**
     * @param array $input
     * @return int
     */
    public function getUniqueValue(array $input): int {
        $minZero = 0;

        if(empty($input)) {
            return $minZero;
        }

        $countValues = array_count_values($input);
        $newArr = [];

        foreach($countValues as $value => $count) {
            if($count === 1) {
                array_push($newArr, $value);
            }
        }

        if(!$newArr) {
            return $minZero;
        }

        $minUnique = min($newArr);

        return $minUnique;

    }

    /**
     * @param array $input
     * @return array
     */
    public function groupByTag(array $input): array {
        $result = [];

        if(empty($input)) {
            return $result;
        }

        foreach($input as $value) {
            $tags = $value['tags'];
            $names = $value['name'];

            foreach($tags as $tag) {
                if(!isset($result[$tag])) {
                    $result[$tag] = [];
                }

                array_push($result[$tag], $names);
                sort($result[$tag]);
            }
            
        }

        ksort($result);

        return $result;
    }
}