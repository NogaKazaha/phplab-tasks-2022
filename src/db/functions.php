<?php

// implements DRY principle
require_once('../web/functions.php');

const LOGGING_TIME_FORMAT = 'Y/m/d h:i:s';
const SORTING_PARAMS_NAMES = ['name' => 'Name', 'code' => 'Code', 'state' => 'State', 'city' => 'City'];
const DEFAULT_SORT_VALUE = 'name';
const QUERY_SORT = 'sort';
const QUERY_ORDER = 'order';
const DEFAULT_ORDER = 'asc';
const LOG_FILE = './errors.log';

function baseSqlQuery(): string
{
    $sqlQuery = <<<'SQL'
    SELECT airports.id, airports.name, airports.code, airports.address, airports.timezone,
    cities.name AS city, states.name AS state FROM airports INNER JOIN cities
    ON airports.city_id = cities.id INNER JOIN states ON airports.state_id = states.id
    SQL;

    return $sqlQuery;
}

function getAirportsData(\PDO $pdo): array
{
    $query = baseSqlQuery();

    return fetchData($pdo, $query);
}

function filteredAirports(\PDO $pdo): array
{
    $query = baseSqlQuery() . createFilteringQuery();

    return fetchData($pdo, $query, getBindParamValues());
}

function displayedAirports(\PDO $pdo): array
{
    $sqlQuery = baseSqlQuery() . createFilteringQuery() . createSortQuery() . createPaginationQuery();
    
    return fetchData($pdo, $sqlQuery, getBindParamValues());
}

function createFilteringQuery(): string
{
    return " WHERE airports.name LIKE :first_letter AND states.name LIKE :state";
}

function getQueryValue(string $query) : string
{
    return $_GET[$query] ?? '';
}

function createSortQuery(): string
{
    $sortingParam = in_array(getQueryValue(QUERY_SORT), array_keys(SORTING_PARAMS_NAMES))
        ? getQueryValue(QUERY_SORT)
        : DEFAULT_SORT_VALUE;
    $sortingOrder = in_array(getQueryValue(QUERY_ORDER), ['asc','desc'])
        ? getQueryValue(QUERY_ORDER)
        : DEFAULT_ORDER;

    return " ORDER BY $sortingParam $sortingOrder";
}

function createPaginationQuery() : string
{
    $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
    $offset = ($currentPage - 1) * 10;
    $limit = 10;

    return isset($_GET['page']) ? " LIMIT $limit OFFSET $offset" : "";
}

function fetchData(\PDO $pdo, string $query, array $bindParamsValues = []): bool|array
{
    try {
        $sth = $pdo->prepare($query);
        $sth->setFetchMode(\PDO::FETCH_ASSOC);
        $sth->execute($bindParamsValues);
        $result = $sth->fetchAll();
    } catch (PDOException $e) {
        writeToLog("Error in $query execution. Reason: " . $e->getMessage());
        die();
    }
    return $result;
}

function setUrl(string $param, string $value = null): string
{
    if(empty($_GET)){
        return "?$param=$value";
    }

    $url = $_SERVER['REQUEST_URI'];

    if (strpos($url, $param) !== false) {
        $url = preg_replace("/$param=[^&]*/", "$param=$value", $url);
    } else {
        $url .= "&$param=$value";
    }

    return $url;
}

function getPagesRange(array $airports): array
{
    return range(1, ceil(count($airports) / 10));
}

function getActivePage(): int
{
    return isset($_GET['page']) ? $_GET['page'] : 1;
}

function setActivePageClass(int $page): string
{
    return $page === getActivePage()
    ? "page-item active"
    : "page-item";
}

function getBindParamValues(): array
{
    return [
        'first_letter' => getQueryValue(QUERY_FILTER_BY_FIRST_LETTER) . "%",
        'state' => getQueryValue(QUERY_FILTER_BY_STATE) ?: "%"
    ];
}

function writeToLog(string $message): void
{
    $loggingTime = date(LOGGING_TIME_FORMAT);
    $record = "[$loggingTime] " . $message . PHP_EOL;
    if(!is_file(LOG_FILE)) {
        file_put_contents(LOG_FILE, $record);
    }
    $content = file_get_contents(LOG_FILE);
    $content .= $record;
    file_put_contents(LOG_FILE, $content);
}
