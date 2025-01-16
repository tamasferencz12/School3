<?php
function validate_email($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function validate_ram($ram)
{
    $ram = preg_replace('/[^0-9]/', '', $ram);
    return $ram >= 4 && $ram <= 64;
}

function validate_price($price, $type)
{
    if ($type == 'phone') {
        return $price >= 50000 && $price <= 300000;
    } elseif ($type == 'laptop') {
        return $price >= 100000 && $price <= 1000000;
    } elseif ($type == 'pc') {
        return $price >= 30000 && $price <= 600000;
    }
    return false;
}
$name = $_GET['name'] ?? '';
$stock = $_GET['stock'] ?? '';
$type = $_GET['type'] ?? '';
$specifications = $_GET['specifications'] ?? '';

// Hibák tárolása
$errors = [];

// Név ellenőrzése
if (empty($name)) {
    $errors[] = "A név megadása kötelező!";
} elseif (strlen($name) < 8) {
    $errors[] = "A névnek legalább 8 karakter hosszúnak kell lennie!";
}

// Darabszám ellenőrzése
if (empty($stock)) {
    $errors[] = "A darabszám megadása kötelező!";
} elseif (!is_numeric($stock)) {
    $errors[] = "A darabszámnak számnak kell lennie!";
} elseif ($stock < 20 || $stock > 100) {
    $errors[] = "A darabszámnak 20 és 100 között kell lennie!";
}

// Típus ellenőrzése
$valid_types = ['laptop', 'phone', 'pc'];
if (!in_array($type, $valid_types)) {
    $errors[] = "A termék típusa nem megfelelő!";
}

// Specifikációk ellenőrzése
if (empty($specifications)) {
    $errors[] = "A specifikációk megadása kötelező!";
} else {
    $spec_parts = explode(",", $specifications);

    if (count($spec_parts) != 3) {
        $errors[] = "A specifikáció három, vesszővel elválasztott elemből kell álljon!";
    } else {
        // E-mail ellenőrzése
        if (!validate_email(trim($spec_parts[0]))) {
            $errors[] = "A beszállító e-mail címének érvényesnek kell lennie!";
        }

        // RAM mennyiség ellenőrzése
        if (!validate_ram(trim($spec_parts[1]))) {
            $errors[] = "A RAM mennyiségnek 4 és 64 GB között kell lennie!";
        }

        // Ár ellenőrzése
        $price = trim($spec_parts[2]);
        if (!is_numeric($price) || !validate_price($price, $type)) {
            $errors[] = "A termék ára nem megfelelő!";
        }
    }
}

// Ha vannak hibák, visszatérünk az űrlaphoz és kiírjuk őket
if (!empty($errors)) {
    foreach ($errors as $error) {
        echo "<p class='error'>$error</p>";
    }
    return;
}

// Sikeres validáció esetén a termék sorszámának generálása
$product_number = substr($name, 0, 2) . $stock . substr($type, 0, 2) . date('d,H,i');

// Sikeres mentés visszajelzés
echo "<div id='success'><h2>Új termék elmentve! - $product_number</h2></div>";
