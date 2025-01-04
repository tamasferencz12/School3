<?php
require_once 'support/fuggvenyek.php';
session_start();

$fid = $_SESSION['felhasznalo_id'] ?? null;
if ($fid) {
    $felhasznalo_storage = uj_storage('adatok/felhasznalok');
    $felhasznalo = $felhasznalo_storage->findById($fid);
} else {
    atiranyit("index.php");
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $rid = $_POST['rid'] ?? false;
    if ($rid) {
        uj_storage('adatok/foglalasok')->delete($rid);
    }
}
$filter = $felhasznalo['admin'] ? [] : ['userid' => $fid];
$reservations = uj_storage('adatok/foglalasok')->findAll($filter);

$auto_storage = uj_storage('adatok/autok');
$user_storage = $felhasznalo['admin']  ? uj_storage('adatok/felhasznalok') : null;

$reservations = array_map(function ($reservation) use ($auto_storage, $user_storage) {
    $reservation['auto'] = $auto_storage->findById($reservation['autoid']);
    if ($user_storage) {
        $reservation['user'] = $user_storage->findById($reservation['userid']);
    }
    return $reservation;
}, $reservations);



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
            <?php if ($felhasznalo['admin']): ?>
                <a href="page_admin.php">Új autó hozzáadása </a>
            <?php endif; ?>
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

        <div class="car-grid">
            <?php foreach ($reservations as $reservation): ?>
                <div class="car-card">
                    <img src="<?= htmlspecialchars($reservation['auto']['image']) ?>" alt="<?= htmlspecialchars($reservation['auto']['brand'] . ' ' . $reservation['auto']['model']) ?>">
                    <div class="car-grid-text">
                        <span><?= htmlspecialchars($reservation['auto']['brand'] . ' ' . $reservation['auto']['model']) ?></span>
                        <p class="car-card-price"><strong>
                                <?php if (isset($reservation['user'])): ?>
                                    <?= htmlspecialchars($reservation['user']['nev']) ?> <br>
                                <?php else: ?>
                                    Lefoglalva:
                                <?php endif; ?>
                                <?= htmlspecialchars($reservation['date_from']) . '-' . htmlspecialchars($reservation['date_to']) ?>
                            </strong>
                        </p>
                        <p><?= htmlspecialchars($reservation['auto']['passengers']) ?> férőhely - <?= htmlspecialchars($reservation['auto']['transmission']) ?></p>
                        <form method="POST">
                            <div class="buttons">
                                <input type="hidden" name="rid" value="<?= $reservation['id'] ?>">
                                <button type="submit" style="background-color: red; color:white;">
                                    <?php if (isset($reservation['user'])): ?>
                                        Törlés
                                    <?php else: ?>
                                        Lemondás
                                    <?php endif; ?>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
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