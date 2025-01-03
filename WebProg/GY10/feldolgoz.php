<?php
require_once 'fuggvenyek.php';
session_start();

function elofeldolgoz($get_parameter_nev, $alapertek = '')
{
    return trim($_GET[$get_parameter_nev] ?? $alapertek);
}

$helyes_besorolasok = ['nincs', '12', '16', '18'];
//helyes származások
$helyes_kategoriak = ['akc', 'rom', 'kal', 'dra'];

$urlap_adat = (object)[
    'cim'       => elofeldolgoz('cim'),
    'ev'        => elofeldolgoz('ev', 0),
    'besorolas' => elofeldolgoz('besorolas'),
    'szarmazas' => elofeldolgoz('szarmazas'),
    'kategoria' => array_map(
        function ($kat) {
            return trim($kat);
        },
        $_GET['kategoria'] ?? []
    )
];

$hibak = [];

if (strlen($urlap_adat->cim) == 0) {
    //nincs push, hnem ilyen kapcsos zárójel utána
    $hibak[] = 'A film címének megadása kötelező!';
} else if (strlen($urlap_adat->cim) < 5) { // nyilván ez egy hülye limit, de gyakorlunk
    $hibak[] = 'A film címe minimum 5 karakzter hosszú legyen!';
} else if (strlen($urlap_adat->cim) > 100) {
    $hibak[] = 'A film címe legfeljebb 100 karakter hosszú legyen!';
} // esetleg ellenőrizni, hogy van-e ilyen című film már

if (!is_numeric($urlap_adat->ev)) {
    $hibak[] = 'Az év szám legyen!';
} else if (intval($urlap_adat->ev) != floatval($urlap_adat->ev)) {
    $hibak[] = 'Az év egész szám legyen!';
    // deMorgan
    // nemA vagy nemB == nem(A és B)
    // nemA és nemB == nem(A vagy B)
    //}else if(intval($urlap_adat->ev) < 1850 || intval($urlap_adat->ev) > 2024){
} else if (!(intval($urlap_adat->ev) >= 1850 && intval($urlap_adat->ev) <= 2024)) {
    $hibak[] = 'Az év legyen 1850 és 2024 közt!';
}

if (!in_array($urlap_adat->besorolas, $helyes_besorolasok)) {
    $hibak[] = 'Ismeretlen besorolás!';
}

//if helyes származás inarray

//$valamelyik_rossz = false;
foreach ($urlap_adat->kategoria as $kat) {
    //$valamelyik_rossz = !in_array($kat, $helyes_kategoriak);
    if (!in_array($kat, $helyes_kategoriak)) {
        $hibak[] = 'Érvénytelen kategória: ' . $kat . '!';
    }
}

/*if ($valamelyik_rossz) {
    $hibak[] = 'Érvénytelen kategória!';
}*/

if (count($hibak) == 0) {
    $filmek = json_beolvas('filmek');
    $urlap_adat->ev = intval($urlap_adat->ev);
    $filmek[] = $urlap_adat;
    json_kiir('filmek', $filmek);
} else {
    $_SESSION['hibak'] = $hibak;
    $_SESSION['adatok'] = $urlap_adat;
}

atiranyit('index.php');