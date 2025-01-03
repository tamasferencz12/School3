<?php
require_once 'fuggvenyek.php';
die;

$uj_csatorna = (object)[
    'nev' => $urlap_adat->nev,
    'influencer' => $urlap_adat->influencer,
    'kep' => $urlap_adat->kep,
    'feliratkozok' => 0
];

$csatornak_ext = json_decode(file_get_contents('adatok/csatornak.json'));
$csatornak_ext[] = $uj_csatorna;
file_put_contents('adatok/csatornak.json', json_encode($csatornak_ext, JSON_PRETTY_PRINT));
atiranyit('inxex.php');
