<?php
require_once 'support/fuggvenyek.php';
session_start();

$fid = $_SESSION['felhasznalo_id'] ?? null;
$felhasznalo = ['admin' => false];
if ($fid) {
  $felhasznalo_storage = uj_storage('adatok/felhasznalok');
  $felhasznalo = $felhasznalo_storage->findById($fid);
}
$autok_storage = uj_storage('adatok/autok');

[
  $passengers,
  $date_from,
  $date_to,
  $transmission,
  $min_price,
  $max_price,
  $filtered_cars
] = autok_szures($autok_storage->findAll());

?>

<!DOCTYPE html>
<html lang="hu">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="style.css" rel="stylesheet" />
  <title>IKarRental | Főoldal</title>
</head>

<body>
  <header>
    <a class="IKarRental" href="index.php">IKarRental</a>
    <nav class="nav-bar">
      <?php if ($fid): ?>
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
      <?php else: ?>
        <a href="page_login.php">Bejelentkezés</a>
        <a href="page_register.php">Regisztráció</a>
      <?php endif; ?>
    </nav>
  </header>
  <main>
    <div class="hero">
      <h2>Kölcsönözz autókat könnyedén!</h2>
      <?php if (!$fid): ?>
        <a class="register-button" href="page_register.php">Regisztráció</a>
      <?php endif; ?>
    </div>

    <div class="filters">
      <form method="GET">
        <input type="number" name="passengers" value="<?php echo $passengers ?>" placeholder="0 férőhely" min="1">
        <input type="date" name="date_from" placeholder="Dátum-tól" value="<?= $date_from ?>">
        <input type="date" name="date_to" placeholder="Dátum-ig" value="<?= $date_to ?>">
        <select name="transmission">
          <option value="">Váltó típusa</option>
          <option value="Automata"
            <?php if ($transmission === 'Automata'): ?>
            selected
            <?php endif; ?>>Automata</option>
          <option value="Manuális"
            <?php if ($transmission === 'Manuális'): ?>
            selected
            <?php endif; ?>>Manuális</option>
        </select>
        <label for="min_price">Ár-tól:</label>
        <input type="number" name="min_price" value="<?php echo $min_price ?>" id="min_price" min="15000" max="99999" step="1000">
        <label for="max_price">Ár-ig:</label>
        <input type="number" name="max_price" value="<?php echo $max_price ?>" id="max_price" min="15000" max="99999" step="1000">
        <button type="submit">Szűrés</button>
      </form>
    </div>

    <div class="car-grid">
      <?php foreach ($filtered_cars as $auto): ?>
        <div class="car-card">
          <?php if ($felhasznalo['admin']): ?>
            <div class="action-btns-container">
              <a class="delete-btn" href="page_admin.php?action=delete&cid=<?= $auto['id'] ?>">Törles</a>
              <a class="edit-btn" href="page_admin.php?cid=<?= $auto['id'] ?>">Szerkeszt</a>
            </div>
          <?php endif; ?>
          <img src="<?= htmlspecialchars($auto['image']) ?>" alt="<?= htmlspecialchars($auto['brand'] . ' ' . $auto['model']) ?>">
          <div class="car-grid-text">
            <a href="page_auto_reszletek.php?id=<?= $auto['id'] ?>" class="car-card-brand"><?= htmlspecialchars($auto['brand']) ?> <?= htmlspecialchars($auto['model']) ?></a>
            <p class="car-card-price"><strong>Ár: <?= htmlspecialchars($auto['daily_price_huf']) ?> Ft/nap</strong></p>
            <p><?= htmlspecialchars($auto['passengers']) ?> férőhely - <?= htmlspecialchars($auto['transmission']) ?></p>
            <?php if (!$felhasznalo['admin']): ?>
              <a class="reserve-btn" href="page_auto_reszletek.php?id=<?= $auto['id'] ?>">Foglalás</a>
            <?php endif; ?>
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