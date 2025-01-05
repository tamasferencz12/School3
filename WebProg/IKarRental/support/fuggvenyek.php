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

function post_data(): array
{
    $post_data = file_get_contents('php://input');
    return !empty($post_data) ? json_decode($post_data, true) : [];
}

function autok_szures(array $autok): array
{
    $passengers = $_GET['passengers'] ?? '';
    $date_from = $_GET['date_from'] ?? '';
    $date_from_timestamp = empty($date_from) ? 0 : strtotime($date_from);
    $date_to = $_GET['date_to'] ?? '';
    $date_to_timestamp = empty($date_to) ? 0 : strtotime($date_to);

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

        if ($date_from_timestamp > 0 || $date_to_timestamp > 0 && $date_from_timestamp <= $date_to_timestamp) {
            $foglalasok_storage = uj_storage('adatok/foglalasok');
            $auto_foglalasok = array_filter($foglalasok_storage->findAll(), function ($foglalas) use ($date_from_timestamp, $date_to_timestamp) {
                if (
                    ($date_from_timestamp > 0 && $date_to_timestamp == 0 && strtotime($foglalas['date_to']) >= $date_from_timestamp) ||
                    ($date_from_timestamp == 0 && $date_to_timestamp > 0 && strtotime($foglalas['date_to']) <= $date_to_timestamp) ||
                    ($date_to_timestamp > 0 && $date_from_timestamp > 0 && strtotime($foglalas['date_from']) <= $date_to_timestamp && strtotime($foglalas['date_from']) >= $date_from_timestamp)
                ) {
                    return true;
                }
                return false;
            });
            $foglalt_autok = !empty($auto_foglalasok) ? array_column($auto_foglalasok, "autoid") : [];
            $szurt_autok = !empty($foglalt_autok) ? array_filter(
                $szurt_autok,
                function ($car) use ($foglalt_autok) {
                    return !in_array($car['id'], $foglalt_autok);
                }
            ) : $szurt_autok;
        }
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

function auto_foglalas(array $data)
{
    unset($_SESSION['hibak']);

    $fid = $_SESSION['felhasznalo_id'] ?? null;
    $autoId = $data['autoid'] ?? false;
    $date_from = $data['date_from'] ?? false;
    $date_to = $data['date_to'] ?? false;
    if ($autoId === false) {
        $errors[] = "Nincs kiválasztott autó.";
    }

    if (!$date_from || !$date_to) {
        $errors[] = "Nincs kiválasztott időintervallum.";
    } else if (strtotime($date_from . " 23:59:00") < strtotime('now')) {
        $errors[] = "Helytelen a kiválasztott időintervallum (múlt).";
    } else if (strtotime($date_from) > strtotime($date_to)) {
        $errors[] = "Helytelen a kiválasztott időintervallum.";
    }


    if (empty($errors)) {
        $foglalasok_storage = uj_storage('adatok/foglalasok');
        $auto_foglalasok = $foglalasok_storage->findAll(['autoid' => $autoId]);
        if (!empty($auto_foglalasok)) {

            $auto_foglalasok = array_filter($auto_foglalasok, function ($foglalas) use ($date_from, $date_to) {
                if (strtotime($foglalas['date_to']) < strtotime($date_from) || strtotime($date_to) < strtotime($foglalas['date_from'])) {
                    return false;
                }
                return true;
            });

            if (!empty($auto_foglalasok)) {

                $intervallumok = array_map(function ($item) {
                    return "{$item['date_from']}-{$item['date_to']}";
                }, $auto_foglalasok);

                $_SESSION['hibak'][] = "Foglalt a(z) intervallumban: " . join(", ", $intervallumok);
                return false;
            }
        }

        $foglalas = [
            "autoid" => $autoId,
            "userid" => $fid,
            "date_from" => $date_from,
            "date_to" => $date_to
        ];
        return $foglalasok_storage->add($foglalas);
    } else {
        $_SESSION['hibak'] = $errors;
    }

    return false;
}


function auto_foglalas_info(): array
{
    $autoId = $_GET['id'] ?? false;
    $date_from = $_GET['date_from'] ?? false;
    $date_to = $_GET['date_to'] ?? false;

    if (!$date_from || !$date_to) {
        return ['error' => "Nincs kiválasztott időintervallum."];
    } else if (strtotime($date_from . " 23:59:00") < strtotime('now')) {
        return ['error' => "Helytelen a kiválasztott időintervallum (múlt)."];
    } else if (strtotime($date_from) > strtotime($date_to)) {
        return ['error' => "Helytelen a kiválasztott időintervallum."];
    }

    $foglalasok_storage = uj_storage('adatok/foglalasok');
    $auto_foglalasok = $foglalasok_storage->findAll(['autoid' => $autoId]);
    if (!empty($auto_foglalasok)) {
        $auto_foglalasok = array_filter($auto_foglalasok, function ($foglalas) use ($date_from, $date_to) {
            if (strtotime($foglalas['date_to']) < strtotime($date_from) || strtotime($date_to) < strtotime($foglalas['date_from'])) {
                return false;
            }
            return true;
        });

        if (!empty($auto_foglalasok)) {
            $intervallumok = array_map(function ($item) {
                return "{$item['date_from']}-{$item['date_to']}";
            }, $auto_foglalasok);

            return ['error' => "Foglalt a(z) intervallumban: " . join(", ", $intervallumok)];
        }
    }

    $days = abs((strtotime($date_to) - strtotime($date_from)) / (60 * 60 * 24)) + 1;
    $daily_price_huf = uj_storage('adatok/autok')->findById($autoId)['daily_price_huf'];
    return ['info' => " $days napra, osszesen " . ($days * $daily_price_huf) . " Ft"];
}
