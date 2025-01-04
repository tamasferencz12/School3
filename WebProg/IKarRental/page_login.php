<?php
require_once 'support/fuggvenyek.php';
session_start();
$fid = $_SESSION['felhasznalo_id'] ?? null;
$hibak = munkamenet_valtozo('hibak');
$referer = $_GET['referer'] ?? null;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style.css" rel="stylesheet" />
    <title>IKarRental | <?= $cim ?></title>
</head>
<header>
    <a class="IKarRental" href="index.php">IKarRental</a>
    <nav>
        <?php if ($fid): ?>
            <a href="request/logout.php">Kijelentkezés</a>
        <?php else: ?>
            <a href="page_login.php">Bejelentkezés</a>
            <a href="page_register.php">Regisztráció</a>
        <?php endif; ?>
    </nav>
</header>

<main class="main">
    <div class="login_page">
        <h2>Bejelentkezés</h2>
    </div>

    <form class="login-form" action="request/login.php" method="POST">
        <input type="hidden" name="referer" value="<?= $referer ?>">
        <div class="form-group">
            <label for="mail">E-mail</label>
            <input id="mail" class="login-usrn-label" name="mail" type="text" required />
        </div>
        <div class="form-group">
            <label for="jszo">Jelszó</label>
            <input id="jszo" class="login-pswd-label" name="jszo" type="password" required />
        </div>
        <input type="submit" value="Bejelentkezés" class="submit-button" />
    </form>

    <?php if (count($hibak) > 0): ?>
        <ul class="error-list">
            <?php foreach ($hibak as $hiba): ?>
                <li><?= $hiba ?></li>
            <?php endforeach ?>
        </ul>
    <?php endif ?>
    <footer class="footer">
        <p>&copy; 2025 IKarRental | All rights reserved</p>
        <p>Developed by FT</p>
        <div class="social-icons">
            <a href="#" class="social-icon">Facebook</a>
            <a href="#" class="social-icon">Twitter</a>
            <a href="#" class="social-icon">Instagram</a>
        </div>
    </footer>
</main>

</html>