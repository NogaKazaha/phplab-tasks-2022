<?php

/** @var \PDO $pdo */
require_once './pdo_ini.php';

foreach (require_once('../web/airports.php') as $item) {
    $sth = $pdo->prepare('SELECT id FROM cities WHERE name = :name');
    $sth->setFetchMode(\PDO::FETCH_ASSOC);
    $sth->execute(['name' => $item['city']]);
    $city = $sth->fetch();

    if (!$city) {
        $sth = $pdo->prepare('INSERT INTO cities (name) VALUES (:name)');
        $sth->execute(['name' => $item['city']]);
        $cityId = $pdo->lastInsertId();
    } else {
        $cityId = $city['id'];
    }

    $sth = $pdo->prepare('SELECT id FROM states WHERE name = :name');
    $sth->setFetchMode(\PDO::FETCH_ASSOC);
    $sth->execute(['name' => $item['state']]);
    $state = $sth->fetch();

    if (!$state) {
        $sth = $pdo->prepare('INSERT INTO states (name, code) VALUES (:name, :code)');
        $sth->execute(['name' => $item['state'],'code' => $item['code']]);
        $stateId = $pdo->lastInsertId();
    } else {
        $stateId = $state['id'];
    }

    $sth = $pdo->prepare('SELECT id FROM airports WHERE name = :name');
    $sth->setFetchMode(\PDO::FETCH_ASSOC);
    $sth->execute(['name' => $item['name']]);
    $airport = $sth->fetch();

    if (!$airport) {
        $sth = $pdo->prepare(
            'INSERT INTO airports (name, code, address, timezone, city_id, state_id) VALUES (:name,:code,:address,:timezone,:city_id,:state_id)');
        $sth->execute([
           'name' => $item['name'],
           'code' => $item['code'],
           'address'=> $item['address'],
           'timezone' => $item['timezone'],
           'city_id' => $cityId,
            'state_id' => $stateId
            ]
        );
        $airportId = $pdo->lastInsertId();
    } else {
        $airportId = $airport['id'];
    }
}