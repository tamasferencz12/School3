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

$post_data = post_data();
if (!empty($post_data)) {
    $rid = auto_foglalas($post_data);
    if ($rid === false) {
        atiranyit('page_failed_reservation.php?id=' . $autoid);
    } else {
        atiranyit('page_successful_reservation.php?rid=' . $rid);
    }
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
                    <button type="button" id="submit" disabled>Lefoglalom</button>
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

    function showPopup(content) {
        const popup = document.createElement('div');
        popup.id = 'popupContainer';
        popup.style.position = 'fixed';
        popup.style.top = '50%';
        popup.style.left = '50%';
        popup.style.transform = 'translate(-50%, -50%)';
        popup.style.backgroundColor = '#fff';
        popup.style.padding = '20px';
        popup.style.border = '1px solid #ccc';
        popup.style.boxShadow = '0 4px 6px rgba(0, 0, 0, 0.1)';
        popup.style.zIndex = '1000';
        popup.style.width = '80%';
        popup.style.maxWidth = '600px';
        popup.style.maxHeight = '80%';
        popup.style.overflowY = 'auto';

        popup.innerHTML = content;

        const closeButton = document.createElement('button');
        closeButton.textContent = 'Close';
        closeButton.style.marginTop = '10px';
        closeButton.style.backgroundColor = '#f44336';
        closeButton.style.color = '#fff';
        closeButton.style.border = 'none';
        closeButton.style.padding = '10px 20px';
        closeButton.style.cursor = 'pointer';
        closeButton.style.borderRadius = '4px';

        closeButton.addEventListener('click', () => {
            document.body.removeChild(popup);
            document.body.removeChild(overlay);
        });

        popup.appendChild(closeButton);

        const overlay = document.createElement('div');
        overlay.id = 'popupOverlay';
        overlay.style.position = 'fixed';
        overlay.style.top = '0';
        overlay.style.left = '0';
        overlay.style.width = '100%';
        overlay.style.height = '100%';
        overlay.style.backgroundColor = 'rgba(0, 0, 0, 0.5)';
        overlay.style.zIndex = '999';

        overlay.addEventListener('click', () => {
            document.body.removeChild(popup);
            document.body.removeChild(overlay);
        });

        document.body.appendChild(overlay);
        document.body.appendChild(popup);
    }

    function submitForm() {
        const autoId = autoid.value;
        const dateFrom = dateFromInput.value;
        const dateTo = dateToInput.value;

        submitButton.disabled = true;

        const queryString = `?id=${encodeURIComponent(autoId)}`;


        if (dateFrom && dateTo && autoId) {
            fetch(`/page_auto_reszletek.php${queryString}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        autoid: autoId,
                        date_from: dateFrom,
                        date_to: dateTo
                    }),
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.text();
                })
                .then(pageContent => {
                    console.log('Fetched Page Content:', pageContent);
                    showPopup(pageContent);
                    submitButton.disabled = false;
                })
                .catch(error => {
                    console.error('Error fetching JSON:', error);
                    submitButton.disabled = true;
                });
        }

    }

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
    submitButton.addEventListener('click', submitForm);
</script>


</html>