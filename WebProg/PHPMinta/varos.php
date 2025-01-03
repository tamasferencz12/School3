<?php
require 'data.php';
$index = $_GET['id'];
$city = $cities[$index];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Gyakorló ZH</title>
</head>

<body>
    <h1><?= $city->name ?></h1>
    <div>Ország: <?= $city->country ?></div>
    <div>Lakosság: <?= $city->population ?> fő</div>
</body>

</html>