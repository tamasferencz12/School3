<?php
require_once '../support/fuggvenyek.php';
session_start();

$fid = $_SESSION['felhasznalo_id'] ?? null;
$felhasznalo_storage = uj_storage('../adatok/felhasznalok');
$felhasznalo = $felhasznalo_storage->findById($fid);

if (!$felhasznalo['admin']) {
    atiranyit('index.php');
    exit;
}

$brand = $_POST['brand'] ?? '';
$model = $_POST['model'] ?? '';
$year = $_POST['year'] ?? '';
$transmission = $_POST['transmission'] ?? '';
$fuel_type = $_POST['fuel_type'] ?? '';
$passengers = $_POST['passengers'] ?? '';
$daily_price_huf = $_POST['daily_price_huf'] ?? '';
$image = $_FILES['image'] ?? null;

if ($image && $image['error'] === UPLOAD_ERR_OK) {
    $target_dir = "../adatok/kepek/";
    $target_file = $target_dir . basename($image['name']);
    if (move_uploaded_file($image['tmp_name'], $target_file)) {
        $autok_storage = uj_storage('adatok/autok');
        $new_car = [
            'brand' => $brand,
            'model' => $model,
            'year' => $year,
            'transmission' => $transmission,
            'fuel_type' => $fuel_type,
            'passengers' => $passengers,
            'daily_price_huf' => $daily_price_huf,
            'image' => $target_file,
        ];
        $autok_storage->add($new_car);
        atiranyit('admin.php');
        exit;
    } else {
        echo "Sorry, there was an error uploading your image.";
    }
} else {
    echo "Invalid image upload.";
}
