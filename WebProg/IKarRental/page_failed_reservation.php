<?php
require_once 'support/fuggvenyek.php';
session_start();
$fid = $_SESSION['felhasznalo_id'] ?? null;
$id = $_GET['id'] ?? '';

if (!isset($fid) || !isset($id)) {
    atiranyit('index.php');
}
if ($fid) {
    $felhasznalo_storage = uj_storage('adatok/felhasznalok');
    $felhasznalo = $felhasznalo_storage->findById($fid);
}

$auto = uj_storage('adatok/autok')->findById($id);

if (!$auto) {
    atiranyit('index.php');
}

?>

<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sikertelen Foglalás</title>
    <link href="style.css" rel="stylesheet" />
</head>

<body>
    <div class="booking">
        <div class="booking-icon failed">
            <span>x</span>
        </div>
        <h1 class="booking-title">Sikertelen foglalás!</h1>
        <p class="booking-description">
            A(z) <strong><?= $auto['brand'] ?> <?= $auto['model'] ?></strong> sikertelen foglalasi kiserlet!
        </p>
        <?php if (isset($_SESSION['hibak']) && count($_SESSION['hibak']) > 0): ?>
            <ul class="error-list">
                <?php foreach ($_SESSION['hibak'] as $hiba): ?>
                    <li><?= $hiba ?></li>
                <?php endforeach; ?>
            </ul>
            <?php unset($_SESSION['hibak']); ?>
        <?php endif; ?>

        <a href="page_auto_reszletek.php?id=<?= $id ?>" class="booking-button">Vissza az autóra</a>
    </div>
</body>

</html>