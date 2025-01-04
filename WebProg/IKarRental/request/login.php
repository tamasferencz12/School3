<?php
require_once '../support/fuggvenyek.php';
session_start();

$form_data = [
    'mail' => $_POST['mail'] ?? '',
    'jszo' => $_POST['jszo'] ?? '',
    'referer' => $_POST['referer'] ?? '',
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
    $page = $form_data['referer'] ?? 'index.php';
    atiranyit("../" . urldecode($page));
} else {
    $_SESSION['hibak'] = $hibak;
    atiranyit('../page_login.php');
}
