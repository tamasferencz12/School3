<?php
require_once 'support/fuggvenyek.php';
session_start();

$fid = $_SESSION['felhasznalo_id'] ?? null;
if ($fid) {
    $felhasznalo_storage = uj_storage('adatok/felhasznalok');
    $felhasznalo = $felhasznalo_storage->findById($fid);
}
?>
<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style.css" rel="stylesheet" />
    <title>IKarRental | Profil</title>
</head>

<body>
    <header>
        <a class="IKarRental" href="index.php">IKarRental</a>
        <nav class="nav-bar">
            <a href="index.php">Főoldal</a>
            <a href="request/logout.php">Kijelentkezés</a>
            <a href="user.php">
                <div style="width: 50px; height: 50px; border-radius: 50%; background-color: #ffcc00; color: black; 
             display: flex; align-items: center; justify-content: center; font-size: 24px; margin-left: 10px;">
                    <?= strtoupper(substr($felhasznalo['nev'], 0, 1)) ?>
                </div>
            </a>
        </nav>
    </header>

    <main>
        <h2>Felhasználói Profil</h2>
        <div class="user-info">
            <div style="width: 50px; height: 50px; border-radius: 50%; background-color: #ffcc00; color: black; 
             display: flex; align-items: center; justify-content: center; font-size: 24px; margin-left: 10px;">
                <?= strtoupper(substr($felhasznalo['nev'], 0, 1)) ?>
            </div>
            <h3><?= htmlspecialchars($felhasznalo['nev']) ?></h3>
            <p><strong>Email:</strong> <?= htmlspecialchars($felhasznalo['email']) ?></p>
        </div>
    </main>
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