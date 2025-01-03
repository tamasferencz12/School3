<?php
require_once '../support/fuggvenyek.php';
session_start();

$form_data = [
    'mail' => $_POST['mail'] ?? '',
    'jszo' => $_POST['jszo'] ?? ''
];

$felhasznalo_storage = uj_storage('../adatok/felhasznalok');
$felhasznalo = $felhasznalo_storage->findOne([
    'email' => $form_data['mail']
]);

$hibak = [];

if (
    !isset($felhasznalo) ||
    !password_verify($form_data['jszo'], $felhasznalo['jelszo'])
) {
    $hibak[] = 'Hibás E-mail vagy jelszó!';
}


if (count($hibak) == 0) {
    $_SESSION['felhasznalo_id'] = $felhasznalo['id'];
    atiranyit('../index.php');
} else {
    $_SESSION['hibak'] = $hibak;
    atiranyit('../page_login.php');
}
