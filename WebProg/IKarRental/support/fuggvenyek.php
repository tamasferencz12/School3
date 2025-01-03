<?php
require_once 'storage.php';
function atiranyit($cel)
{
    header("Location: $cel");
    die;
}

function munkamenet_valtozo($valtozonev, $alapertek = [])
{
    $eredmeny = $_SESSION[$valtozonev] ?? $alapertek;
    $_SESSION[$valtozonev] = $alapertek;
    return $eredmeny;
}

function uj_storage($filenev)
{
    $json_kezelo = new JsonIO("$filenev.json");
    return new Storage($json_kezelo);
}

function autok_szures(array $autok): array
{
    $passengers = $_GET['passengers'] ?? '';
    $date_from = $_GET['date_from'] ?? '';
    $date_to = $_GET['date_to'] ?? '';
    $transmission = $_GET['transmission'] ?? '';
    $min_price = $_GET['min_price'] ?? '';
    $max_price = $_GET['max_price'] ?? '';
    $szurt_autok = [];
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $szurt_autok = array_filter($autok, function ($car) use ($passengers, $transmission, $min_price, $max_price) {
            $matches = true;

            if ($passengers && $car['passengers'] != $passengers) {
                $matches = false;
            }

            if ($transmission && $car['transmission'] != $transmission) {
                $matches = false;
            }

            if ($min_price && $car['daily_price_huf'] < $min_price) {
                $matches = false;
            }

            if ($max_price && $car['daily_price_huf'] > $max_price) {
                $matches = false;
            }

            return $matches;
        });
    }

    return [
        $passengers,
        $date_from,
        $date_to,
        $transmission,
        $min_price,
        $max_price,
        empty($szurt_autok) ? $autok : $szurt_autok
    ];
}


function auto_mentes_hozzaadas()
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $autoId = $_POST['autoid'] ?? uniqid();
        $brand = $_POST['brand'] ?? '';
        $model = $_POST['model'] ?? '';
        $year = $_POST['year'] ?? '';
        $transmission = $_POST['transmission'] ?? '';
        $fuel_type = $_POST['fuel_type'] ?? '';
        $passengers = $_POST['passengers'] ?? '';
        $daily_price_huf = $_POST['daily_price_huf'] ?? '';
        $image = $_FILES['image'] ?? null;
        $errors = [];

        if (empty($brand) || empty($model) || empty($year) || empty($transmission) || empty($fuel_type) || empty($passengers) || empty($daily_price_huf)) {
            $errors[] = "Minden mezőt ki kell tölteni.";
        }

        if ($image && $image['error'] === UPLOAD_ERR_OK) {
            $target_dir = "adatok/kepek/";
            $target_file = $target_dir . basename($image['name']);
            if (!move_uploaded_file($image['tmp_name'], $target_file)) {
                $errors[] = "Hiba történt a kép feltöltésekor.";
            }
        } else if (!isset($_POST['autoid'])) {
            $errors[] = "Kép nem lett feltöltve vagy nem megfelelő formátumú.";
        }


        if (empty($errors)) {
            $autok_storage = uj_storage('adatok/autok');
            $car = [
                'id' => $autoId,
                'brand' => $brand,
                'model' => $model,
                'year' => $year,
                'transmission' => $transmission,
                'fuel_type' => $fuel_type,
                'passengers' => $passengers,
                'daily_price_huf' => $daily_price_huf,
                'image' => $target_file
            ];

            if ($_POST['autoid']) {
                if (!$car['image']) {
                    $car['image'] = $autok_storage->findById($car['id'])['image'];
                }
                $autok_storage->update($autoId, $car);
            } else {
                $autok_storage->add($car);
            }

            return true;
        } else {
            $_SESSION['hibak'] = $errors;
        }
    }
    return false;
}


function auto_torles()
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $autoId = $_POST['autoid'] ?? false;
        if ($autoId === false) {
            $errors[] = "Nincs kiválasztott autó.";
        }
        if (empty($errors)) {
            $autok_storage = uj_storage('adatok/autok');
            $autok_storage->delete($autoId);
            return true;
        } else {
            $_SESSION['hibak'] = $errors;
        }
    }
    return false;
}