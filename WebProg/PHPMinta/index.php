<?php
require 'data.php';

function elofeldolgoz($get_parameter_nev, $alapertek = '')
{
  return trim($_GET[$get_parameter_nev] ?? $alapertek);
}

$urlap_adat = (object)[
  'name'       => elofeldolgoz('name'),
  'country'    => elofeldolgoz('country'),
  'population' => elofeldolgoz('population')
];

$hibak = [];

if (strlen($urlap_adat->name) == 0) {
  $hibak[] = 'A város neve kötelező!';
} else if (strlen($urlap_adat->name) < 3) {
  $hibak[] = 'A város neve minimum 3 karakter hosszú legyen!';
} else if (strlen($urlap_adat->name) > 100) {
  $hibak[] = 'A város neve legfeljebb 100 karakter hosszú legyen!';
}

if (!is_numeric($urlap_adat->population)) {
  $hibak[] = 'A lakosságnak számnak kell lennie!';
} else if (intval($urlap_adat->population) < 0) {
  $hibak[] = 'A lakosság nem lehet negatív!';
}

if (count($hibak) > 0) {
  foreach ($hibak as $hiba) {
    echo $hiba . '<br>';
  }
} else {
  echo 'A város sikeresen hozzáadva!';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>PHP Gyakorló ZH</title>
</head>

<body>
  <ul>
    <?php foreach ($cities as $index => $city): ?>
      <li><a href="varos.php?id=<?= $index ?>"><?= $city->name ?></a></li>
    <?php endforeach // city names 
    ?>
  </ul>
  <h1>Új Város Felvitele</h1>

  <form method="GET" action="">
    <label for="name">Város neve:</label>
    <input type="text" name="name" id="name" required>

    <br><br>

    <label for="population">Lakosság:</label>
    <input type="text" name="population" id="population" required>

    <br><br>

    <button type="submit">Város hozzáadása</button>
  </form>
</body>

</html>