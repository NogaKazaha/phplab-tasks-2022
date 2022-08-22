<?php

const ZERO_INDEX = 0;
const FIRST_INDEX = 1;
const QUERY_NAME = 'name';
const QUERY_FILTER_BY_FIRST_LETTER = 'filter_by_first_letter';
const QUERY_FILTER_BY_STATE = 'filter_by_state';
const QUERY_SORT = 'sort';
const QUERY_PAGE = 'page';
const QUERY_STATE = 'state';
const QUERY_REQUEST_URI = 'REQUEST_URI';
const PAGE_SIZE_AND_RANGE = 5;

/**
 * The $airports variable contains array of arrays of airports (see airports.php)
 * What can be put instead of placeholder so that function returns the unique first letter of each airport name
 * in alphabetical order
 *
 * Create a PhpUnit test (GetUniqueFirstLettersTest) which will check this behavior
 *
 * @param  array  $airports
 * @return string[]
 */
function getUniqueFirstLetters(array $airports)
{
    $uniqueFirstLetters = [];

    array_map(function ($airport) use (&$uniqueFirstLetters) {
        $firstLetter = mb_substr($airport[QUERY_NAME], ZERO_INDEX, FIRST_INDEX);
        
        if (!in_array($firstLetter, $uniqueFirstLetters)) {
            $uniqueFirstLetters[] = $firstLetter;
        }
    }, $airports);

    sort($uniqueFirstLetters);

    return $uniqueFirstLetters;
}

function filterByFirstLetter(array $airports) {
    if(isset($_GET[QUERY_FILTER_BY_FIRST_LETTER])) {
        $filteringLetter = $_GET[QUERY_FILTER_BY_FIRST_LETTER];
        $filteredAirports = array_filter($airports, function ($airport) use ($filteringLetter) {
            return mb_substr($airport[QUERY_NAME], ZERO_INDEX, FIRST_INDEX) === $filteringLetter;
        });
    
       return $filteredAirports;
    }

    return $airports;
}

function filterByState(array $airports) {
    if(isset($_GET[QUERY_FILTER_BY_STATE])) {
        $filteringState = $_GET[QUERY_FILTER_BY_STATE];

        if(str_contains($filteringState, '_')) {
            return array_filter($airports, function ($airport) use ($filteringState) {
                return $airport[QUERY_STATE] === implode(' ', explode('_', $filteringState));
            });
        }

        return array_filter($airports, function ($airport) use ($filteringState) {
            return $airport[QUERY_STATE] === $filteringState;
        });
    }

    return $airports;
}

function sortByParam(array $airports) {
    if(isset($_GET[QUERY_SORT])) {
        $sorting = $_GET[QUERY_SORT];
        $sortedAirports = array_column($airports, $sorting);
        array_multisort($sortedAirports, SORT_ASC, $airports);
    
       return $airports;
    }

    return $airports;
}

function paginate(array $airports) {
    if(isset($_GET[QUERY_PAGE])) {
        $airports = array_values($airports);
        $airports =  array_filter($airports, function($airport) use ($airports) {
            if(displayAirport($airport, $airports)) {
                return $airport;
            }
        });
    }
    return $airports;
}

function displayAirport(array $airport, array $airports): bool
{
    return floor(array_search($airport, $airports) / PAGE_SIZE_AND_RANGE) == currentPage() - 1;
}

function addParamsTouUrl(string $param) {
    $url = $_SERVER[QUERY_REQUEST_URI];

    $paramName = explode('=', $param)[0];

    if(empty($_GET)) {
        return $url . '?' . $param;
    }

    if(in_array($paramName, array_keys($_GET))) {
        $url = str_replace($paramName . '=' . $_GET[$paramName], $param, $url);
    } else {
        $url = $url . '&' . $param;
    }

    return $url;
}

function getBasicAirportsArray() {
    return include './airports.php';

}

function calcPagesRange() {
    return range(
        1, 
        (int)(ceil(
            count(
                filterByState(
                    filterByFirstLetter(
                        getBasicAirportsArray()  
                    )
                )
            ) / PAGE_SIZE_AND_RANGE)
        )
    );
}

function currentPage(): int
{
    $page = 1;
    if(
        isset($_GET[QUERY_PAGE]) && in_array(
            $_GET[QUERY_PAGE], 
            calcPagesRange()
        )
    ) {
        $page = $_GET[QUERY_PAGE];
    }
    
    return $page;
}

function pagesRange() {
    $firstDisplayedPage = (currentPage() - PAGE_SIZE_AND_RANGE) < 1 ? 1 : currentPage() - PAGE_SIZE_AND_RANGE;
    $lastDisplayedPage = (currentPage() + PAGE_SIZE_AND_RANGE) > calcPagesRange()[count(calcPagesRange()) - 1] ? calcPagesRange()[count(calcPagesRange()) - 1] : currentPage() + PAGE_SIZE_AND_RANGE;
    return range($firstDisplayedPage, $lastDisplayedPage);

}

function activePage($page) {
    return $page === currentPage()
        ? "page-item active"
        : "page-item";
}

function getPage($page) {
    $url = $_SERVER[QUERY_REQUEST_URI];

    if(count($_GET) > 0 && !isset($_GET[QUERY_PAGE])) {
        $url .= '&page=' . $page;
    }

    if(count($_GET) === 0) {
        $url .= '?page=' . $page;
    }

    if(isset($_GET[QUERY_PAGE])) {
        $url = str_replace('page=' . $_GET['page'], 'page=' . $page, $url);
    }

    return $url;
}
