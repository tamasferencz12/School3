<?php
require_once 'fuggvenyek.php';
$csatornak = json_beolvas('csatornak');

function elofeldolgoz($get_parameter_nev, $alapertek = '')
{
    return trim($_GET[$get_parameter_nev] ?? $alapertek);
}

$urlap_adat = (object)[
    'nev'       => elofeldolgoz('nev'),
    'influencer'    => elofeldolgoz('influencer'),
    'kep' => elofeldolgoz('kep'),
    'feliratkozok' => elofeldolgoz('feliratkozok')
];

$hibak = [];

if (strlen($urlap_adat->nev) == 0) {
    $hibak[] = 'A csatorna neve ne legyen üres!';
} else if (strlen($urlap_adat->nev) < 6) {
    $hibak[] = 'A csatorna neve legyen minimum 5 karakter hosszú!';
}

if (strlen($urlap_adat->influencer) == 0) {
    $urlap_adat->influencer = $urlap_adat->nev;
}

if (!helyes_url($urlap_adat->kep)) {
    $hibak[] = 'A profilképnek megadott link helyes URL formátumú legyen!';
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>PHP CsoportZH</title>
</head>

<body>
    <div id="content">
        <h1>PHP CsoportZH</h1>

        <h2>Csatornák</h2>
        <?php foreach ($csatornak as $index => $csatorna): ?>
            <div class="csatorna">
                <img src="<?= $csatorna->kep ?>">
                <div>
                    <h3><?= $csatorna->nev ?></h3>
                    <p><?= $csatorna->feliratkozok ?> , <?= $csatorna->influencer ?></p>
                </div>
            </div>
        <?php endforeach ?>

        <h2>Új csatorna</h2>
        <ul id="hibak">
            <?php foreach ($hibak as $hiba):
                if (count($hibak) > 0) {
                    foreach ($hibak as $hiba) { ?>
                        <li><?= $hiba . '<br>' ?></li>
                    <?php }
                } else { ?>
                    echo 'A város sikeresen hozzáadva!';
            <?php }
            endforeach ?>
        </ul>
        <form>
            <label for="nev">Csatorna neve</label>
            <input name="nev" placeholder="Péda Studios">

            <label for="influencer">Vezető influencer</label>
            <input name="influencer" placeholder="Példa Géza">

            <label for="kep">Kép (link)</label>
            <input name="kep" placeholder="https://valami.hu/kep/pelda">

            <input type="submit" onclick="action()">
        </form>
    </div>
</body>

</html>