<?php

/** @var \PDO $pdo */
require_once './pdo_ini.php';
require_once './functions.php';

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <title>Airports</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>
<body>
<main role="main" class="container">

    <h1 class="mt-5">US Airports</h1>
    <div class="alert alert-dark">
        Filter by first letter:

        <?php foreach (getUniqueFirstLetters(getAirportsData($pdo)) as $letter): ?>
            <a href="<?=setUrl(QUERY_FILTER_BY_FIRST_LETTER, $letter);?>"><?= $letter ?></a>
        <?php endforeach; ?>

        <a href="<?=$_SERVER['PHP_SELF'];?>" class="float-right">Reset all filters</a>
    </div>
    <table class="table">
        <thead>
        <tr>
            <?php foreach (SORTING_PARAMS_NAMES as $name => $displayedName): ?>
                <th scope="col"><a href="<?=setUrl('sort', $name);?>"> <?=$displayedName;?> </a></th>
            <?php endforeach; ?>
            <th scope="col">Address</th>
            <th scope="col">Timezone</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach (displayedAirports($pdo) as $airport): ?>
        <tr>
            <td><?= $airport['name'] ?></td>
            <td><?= $airport['code'] ?></td>
            <td><a href="<?=setUrl(QUERY_FILTER_BY_STATE, $airport['state']);?>"">
                <?= $airport['state'] ?></a></td>
            <td><?= $airport['city'] ?></td>
            <td><?= $airport['address'] ?></td>
            <td><?= $airport['timezone'] ?></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php if(displayedAirports($pdo)): ?>
        <nav aria-label="Navigation">
            <ul class="pagination justify-content-center">
                <?php foreach(getPagesRange(filteredAirports($pdo)) as $pageNum): ?>
                    <li class="<?= setActivePageClass($pageNum); ?>">
                        <a class="page-link" href="<?= getPage($pageNum);?>"> <?= $pageNum; ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </nav>

    <?php else: echo "No data "; ?>
    <?php endif; ?>
</main>
</html>
