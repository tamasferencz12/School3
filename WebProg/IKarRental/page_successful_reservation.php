<?php
require_once 'support/fuggvenyek.php';
session_start();
$fid = $_SESSION['felhasznalo_id'] ?? null;
$rid = $_GET['rid'] ?? '';

if (!isset($fid) || !isset($rid)) {
    atiranyit('index.php');
}

if ($fid) {
    $felhasznalo_storage = uj_storage('adatok/felhasznalok');
    $felhasznalo = $felhasznalo_storage->findById($fid);
}

$foglalas = uj_storage('adatok/foglalasok')->findById($rid);

if (!$foglalas) {
    atiranyit('index.php');
}

$foglalas['user'] = uj_storage('adatok/felhasznalok')->findById($foglalas['userid']);
$foglalas['car'] = uj_storage('adatok/autok')->findById($foglalas['autoid']);

?>

<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sikeres Foglalás</title>
    <link href="style.css" rel="stylesheet" />
</head>

<body>
    <div class="booking">
        <div class="booking-icon">
            <span>✔</span>
        </div>
        <h1 class="booking-title">Sikeres foglalás!</h1>
        <p class="booking-description">
            A(z) <strong><?= $foglalas['car']['brand'] ?> <?= $foglalas['car']['model'] ?></strong> sikeresen lefoglalva
            <?= $foglalas['date_from'] ?> - <?= $foglalas['date_to'] ?> intervallumra.
            Foglalásod státuszát a profiloldaladon követheted nyomon.
        </p>
        <a href="user.php" class="booking-button">Profilom</a>
    </div>
</body>

</html>