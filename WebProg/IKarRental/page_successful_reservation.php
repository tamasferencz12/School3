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
    <header>
        <a class="IKarRental" href="index.php">IKarRental</a>
        <nav class="nav-bar">
            <?php if ($fid): ?>
                <a href="user.php">
                    <div style="width: 50px; height: 50px; border-radius: 50%; background-color: #ffcc00; color: black; 
             display: flex; align-items: center; justify-content: center; font-size: 24px; margin-left: 10px;">
                        <?= strtoupper(substr($felhasznalo['nev'], 0, 1)) ?>
                    </div>
                </a>
            <?php endif; ?>
        </nav>
    </header>
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
    <footer class="footer">
        <p>&copy; 2025 IKarRental | All rights reserved</p>
        <p>Developed by FT</p>
        <div class="social-icons">
            <a href="#" class="social-icon">Facebook</a>
            <a href="#" class="social-icon">Twitter</a>
            <a href="#" class="social-icon">Instagram</a>
        </div>
    </footer>
</body>

</html>