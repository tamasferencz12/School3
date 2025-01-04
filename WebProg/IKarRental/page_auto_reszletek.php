<?php
require_once 'support/fuggvenyek.php';
session_start();

if (($_GET['action'] ?? '') === 'info') {
    echo json_encode(auto_foglalas_info());
    die();
}

$fid = $_SESSION['felhasznalo_id'] ?? null;
if ($fid) {
    $felhasznalo_storage = uj_storage('adatok/felhasznalok');
    $felhasznalo = $felhasznalo_storage->findById($fid);
}
$autoid = $_GET['id'] ?? '';
$auto = uj_storage('adatok/autok')->findById($autoid);

if (!isset($auto)) {
    atiranyit('index.php');
}
if (!isset($fid)) {
    atiranyit('page_login.php?referer=' . urlencode('page_auto_reszletek.php?id=' . $autoid));
}

if ($rid = auto_foglalas()) {
    atiranyit('page_successful_reservation.php?rid=' . $rid);
} else if (isset($_SESSION['hibak'])) {
    atiranyit('page_failed_reservation.php?id=' . $autoid);
}

?>

<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style.css" rel="stylesheet" />
    <title>IKarRental | Autó részletei</title>
</head>

<body>
    <header>
        <a class="IKarRental" href="index.php">IKarRental</a>
        <nav class="nav-bar">
            <?php if ($fid): ?>
                <a href="index.php">Főoldal</a>

                <?php if ($felhasznalo['admin']): ?>
                    <a href="page_admin.php">Admin felület</a>
                <?php endif; ?>
                <a href="request/logout.php">Kijelentkezés</a>
                <a href="user.php">
                    <div style="width: 50px; height: 50px; border-radius: 50%; background-color: #ffcc00; color: black; 
             display: flex; align-items: center; justify-content: center; font-size: 24px; margin-left: 10px;">
                        <?= strtoupper(substr($felhasznalo['nev'], 0, 1)) ?>
                    </div>
                </a>
            <?php else: ?>
                <a href="page_login.php">Bejelentkezés</a>
                <a href="page_register.php">Regisztráció</a>
            <?php endif; ?>
        </nav>
    </header>

    <main class="car-details">
        <div class="car-image">
            <img src="<?= htmlspecialchars($auto['image']) ?>" alt="<?= htmlspecialchars($auto['brand'] . ' ' . $auto['model']) ?>">
        </div>
        <div class="car-info">
            <h1><?= htmlspecialchars($auto['brand']) ?> <span><?= htmlspecialchars($auto['model']) ?></span></h1>
            <ul>
                <li><strong>Üzemanyag:</strong> <?= htmlspecialchars($auto['fuel_type']) ?></li>
                <li><strong>Gyártási év:</strong> <?= htmlspecialchars($auto['year']) ?></li>
                <li><strong>Váltó:</strong> <?= htmlspecialchars($auto['transmission']) ?></li>
                <li><strong>Férőhelyek száma:</strong> <?= htmlspecialchars($auto['passengers']) ?></li>
            </ul>
            <p class="price"><strong><?= number_format($auto['daily_price_huf'], 0, '.', ' ') ?> Ft</strong>/nap</p>
            <form method="POST">
                <div class="buttons filters">
                    <input type="hidden" id="autoid" name="autoid" value="<?= $autoid ?>">
                    <input type="date" id="date_from" name="date_from" placeholder="Dátum-tól">
                    <input type="date" id="date_to" name="date_to" placeholder="Dátum-ig">
                    <button type="submit" id="submit" disabled>Lefoglalom</button>
                </div>
            </form>
            <p class="price" id="text"></p>
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


<script>
    const autoid = document.getElementById('autoid');
    const dateFromInput = document.getElementById('date_from');
    const dateToInput = document.getElementById('date_to');
    const submitButton = document.getElementById('submit');
    const text = document.getElementById('text');

    function checkAndEnableSubmit() {
        const autoId = autoid.value;
        const dateFrom = dateFromInput.value;
        const dateTo = dateToInput.value;

        if (dateFrom && dateTo && autoId) {
            const queryString = `?action=info&id=${encodeURIComponent(autoId)}&date_from=${encodeURIComponent(dateFrom)}&date_to=${encodeURIComponent(dateTo)}`;

            fetch(`/page_auto_reszletek.php${queryString}`, {
                    method: 'GET',
                })
                .then(response => response.json())
                .then(data => {
                    console.log('Fetched JSON:', data);
                    if (data.error) {
                        text.innerHTML = data.error;
                        submitButton.disabled = true;
                    } else if (data.info) {
                        text.innerHTML = data.info;
                        submitButton.disabled = false;
                    }
                })
                .catch(error => {
                    console.error('Error fetching JSON:', error);
                    submitButton.disabled = true;
                });
        } else {
            submitButton.disabled = true;
        }
    }

    dateFromInput.addEventListener('change', checkAndEnableSubmit);
    dateToInput.addEventListener('change', checkAndEnableSubmit);
</script>


</html>