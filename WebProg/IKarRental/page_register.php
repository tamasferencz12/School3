<?php
require_once 'support/fuggvenyek.php';
session_start();
$fid = $_SESSION['felhasznalo_id'] ?? null;
$hibak = munkamenet_valtozo('hibak');

if (isset($fid)) {
    atiranyit('index.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $passwordConfirm = $_POST['password_confirm'] ?? '';
    $name = $_POST['name'] ?? '';
    $errors = [];

    if (empty($email) || empty($password) || empty($passwordConfirm) || empty($name)) {
        $errors[] = "Minden mezőt ki kell tölteni.";
    }

    if ($password !== $passwordConfirm) {
        $errors[] = "A jelszavak nem egyeznek.";
    }

    $users = json_decode(file_get_contents('adatok/felhasznalok.json'), true);
    if (array_key_exists($email, $users)) {
        $errors[] = "Az e-mail cím már regisztrálva van.";
    }

    if (empty($errors)) {
        $userId = uniqid();
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $users[$userId] = [
            'nev' => $name,
            'email' => $email,
            'jelszo' => $hashedPassword,
            'admin' => false,
            'id' => $userId
        ];

        file_put_contents('adatok/felhasznalok.json', json_encode($users, JSON_PRETTY_PRINT));

        atiranyit('page_login.php');
    } else {
        $_SESSION['hibak'] = $errors;
    }
}
?>

<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style.css" rel="stylesheet" />
    <title>IKarRental | Regisztráció</title>
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
        <h2>Regisztráció</h2>
    </div>

    <form class="login-form" action="page_register.php" method="POST">
        <div class="form-group">
            <label for="name">Név:</label>
            <input id="name" class="login-usrn-label" name="name" type="text" required />
        </div>
        <div class="form-group">
            <label for="email">E-mail:</label>
            <input id="email" class="login-usrn-label" name="email" type="email" required />
        </div>
        <div class="form-group">
            <label for="password">Jelszó:</label>
            <input id="password" class="login-pswd-label" name="password" type="password" required />
        </div>
        <div class="form-group">
            <label for="password_confirm">Jelszó megerősítése:</label>
            <input id="password_confirm" class="login-pswd-label" name="password_confirm" type="password" required />
        </div>
        <input type="submit" value="Regisztráció" class="submit-button" />
    </form>

    <?php if (isset($_SESSION['hibak']) && count($_SESSION['hibak']) > 0): ?>
        <ul class="error-list">
            <?php foreach ($_SESSION['hibak'] as $hiba): ?>
                <li><?= $hiba ?></li>
            <?php endforeach; ?>
        </ul>
        <?php unset($_SESSION['hibak']); ?>
    <?php endif; ?>
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