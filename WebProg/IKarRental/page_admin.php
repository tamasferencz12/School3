<?php
require_once 'support/fuggvenyek.php';
session_start();
$fid = $_SESSION['felhasznalo_id'] ?? null;
$hibak = munkamenet_valtozo('hibak');

if (!isset($fid)) {
    atiranyit('page_login.php');
}

$felhasznalo_storage = uj_storage('adatok/felhasznalok');
$felhasznalo = $felhasznalo_storage->findById($fid);

if (!$felhasznalo['admin']) {
    atiranyit('index.php');
}

$auto = [
    "id" => "",
    "brand" => "",
    "model" => "",
    "year" => "",
    "transmission" => "Automata",
    "fuel_type" => "Hybrid",
    "passengers" => 5,
    "daily_price_huf" =>  "",
    "image" => ""
];
if (isset($_GET['cid']) && $_GET['cid'] >= 0) {
    $autok_storage = uj_storage('adatok/autok');
    $auto = $autok_storage->findById($_GET['cid']);
}

$action = $_GET['action']  ?? 'update';


if (($_POST['action'] ?? false) === 'update'  && auto_mentes_hozzaadas()) {
    atiranyit('index.php');
}
if (($_POST['action'] ?? false) === 'delete'  && auto_torles()) {
    atiranyit('index.php');
}
?>

<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style.css" rel="stylesheet" />
    <title>Admin -
        <?php if ($auto['id']): ?>
            Edit Car <?= htmlspecialchars($auto['brand']) ?> <?= htmlspecialchars($auto['model']) ?>
        <?php else: ?>
            Add New Car
        <?php endif; ?>
    </title>
</head>

<header>
    <a class="IKarRental" href="index.php">IKarRental</a>
    <nav class="nav-admin">
        <a href="index.php">Főoldal</a>
        <a href="page_admin.php">Új autó hozzáadása </a>
        <a href="request/logout.php">Kijelentkezés</a>
        <a href="user.php">
            <div style="width: 50px; height: 50px; border-radius: 50%; background-color: #ffcc00; color: black; 
             display: flex; align-items: center; justify-content: center; font-size: 24px; margin-left: 10px;">
                <?= strtoupper(substr($felhasznalo['nev'], 0, 1)) ?>
            </div>
        </a>
    </nav>
</header>

<main class="new-car-main">
    <h2 class="new-car-header">
        <?php if ($auto['id']): ?>
            <?= htmlspecialchars($auto['brand']) ?> <?= htmlspecialchars($auto['model']) ?> szerkesztése
        <?php else: ?>
            Új autó hozzáadása
        <?php endif; ?>
    </h2>

    <form action="page_admin.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="action" value="<?= $action  ?>">

        <?php if ($auto['id']): ?>
            <input type="hidden" name="autoid" id="autoid" value="<?= $auto['id'] ?>">
        <?php endif; ?>
        <div class="new-car-form-group">
            <label for="brand">Márka:</label>
            <input id="brand" class="new-car-input" name="brand" type="text" value="<?= $auto['brand'] ?>" required />
        </div>
        <div class="new-car-form-group">
            <label for="model">Típus:</label>
            <input id="model" class="new-car-input" name="model" type="text" value="<?= $auto['model'] ?>" required />
        </div>
        <div class="new-car-form-group">
            <label for="year">Évjárat:</label>
            <input id="year" class="new-car-input" name="year" type="number" value="<?= $auto['year'] ?>" required />
        </div>
        <div class="new-car-form-group">
            <label for="transmission">Váltó:</label>
            <select class="new-car-select" name="transmission" required>
                <option value="Automata"
                    <?php if ($auto['transmission'] === 'Automata'): ?>
                    selected
                    <?php endif; ?>>Automata</option>
                <option value="Manuális"
                    <?php if ($auto['transmission']  === 'Manuális'): ?>
                    selected
                    <?php endif; ?>>Manuális</option>
            </select>
        </div>
        <div class="new-car-form-group">
            <label for="fuel_type">Üzemanyag:</label>
            <select class="new-car-select" name="fuel_type" required>
                <option value="Benzin"
                    <?php if ($auto['fuel_type'] === 'Benzin'): ?>
                    selected
                    <?php endif; ?>>Benzin</option>
                <option value="Dízel"
                    <?php if ($auto['fuel_type'] === 'Dízel'): ?>
                    selected
                    <?php endif; ?>>Dízel</option>
                <option value="Hibrid"
                    <?php if ($auto['fuel_type'] === 'Hibrid'): ?>
                    selected
                    <?php endif; ?>>Hibrid</option>
            </select>
        </div>
        <div class="new-car-form-group">
            <label for="passengers">Férőhelyek száma:</label>
            <input id="passengers" class="new-car-input" name="passengers" type="number" min="1" value="<?= $auto['passengers'] ?>" required />
        </div>
        <div class="new-car-form-group">
            <label for="daily_price_huf">Napi ár (HUF):</label>
            <input id="daily_price_huf" class="new-car-input" name="daily_price_huf" type="number" min="15000" max="99999" value="<?= $auto['daily_price_huf'] ?>" required />
        </div>
        <div class="new-car-form-group">
            <?php if ($auto['image']): ?>
                <img class="edit-img" src="<?= htmlspecialchars($auto['image']) ?>" alt="<?= htmlspecialchars($auto['brand'] . ' ' . $auto['model']) ?>">
            <?php endif; ?>
            <label for="image">Kép:</label>
            <input id="image" class="new-car-input" name="image" type="file" accept="image/*"
                <?php if (!$auto['id']): ?>
                required
                <?php endif; ?> />
        </div>

        <?php if ($action === 'delete'): ?>
            <input type="submit" value="Törlés" class="delete-car-submit-button" />
        <?php else: ?>
            <?php if ($auto['id']): ?>
                <input type="submit" value="Mentés" class="new-car-submit-button" />
            <?php else: ?>
                <input type="submit" value="Hozzáadás" class="new-car-submit-button" />
            <?php endif; ?>
        <?php endif; ?>

    </form>

    <?php if (isset($_SESSION['hibak']) && count($_SESSION['hibak']) > 0): ?>
        <ul class="error-list">
            <?php foreach ($_SESSION['hibak'] as $hiba): ?>
                <li><?= $hiba ?></li>
            <?php endforeach; ?>
        </ul>
        <?php unset($_SESSION['hibak']); ?>
    <?php endif; ?>
</main>

<footer class="footer">
    <p>&copy; 2025 IKarRental | Minden jog fenntartva</p>
    <p>Fejlesztette: FT</p>
    <div class="social-icons">
        <a href="#" class="social-icon">Facebook</a>
        <a href="#" class="social-icon">Twitter</a>
        <a href="#" class="social-icon">Instagram</a>
    </div>
</footer>

</html>