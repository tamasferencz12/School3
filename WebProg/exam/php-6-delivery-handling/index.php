<?php
// include_once("storage.php");
// $deliveryOptions = new Storage(new JsonIO("data.json"));
$deliveryOptions = json_decode(file_get_contents(filename: 'data.json'), true);

$groupedOptions = [
    'pickup_point' => [],
    'in_store' => [],
    'courier' => []
];

foreach ($deliveryOptions as $option) {
    $groupedOptions[$option['type']][] = $option;
}

// Display the grouped options
foreach ($groupedOptions as $type => $options) {
    echo "<h2>" . ucfirst(str_replace('_', ' ', $type)) . "s</h2>";
    echo "<ul>";
    foreach ($options as $option) {
        $cost = ($option['cost'] == 0) ? "Ingyenes" : "{$option['cost']} Ft";
        $time = ($option['time_estimate'] == 0) ? "Azonnal átvehető" : $option['time_estimate'];
        echo "<li class='" . ($option['isOpen'] ? 'open' : 'closed') . "'>
            {$option['name']} - {$cost} ({$time})
            <span class='actions'>
                <a href='delete.php?id={$option['id']}'>Törlés</a> |
                <a href='toggle.php?id={$option['id']}'>" . ($option['isOpen'] ? 'Deaktiválás' : 'Aktiválás') . "</a>
            </span>
        </li>";
    }
    echo "</ul>";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task 6.</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <h1>Új Átvételi Lehetőség Hozzáadása</h1>
    <form id="add-form" method="post" action="add.php">
        <label for="name">Átvételi lehetőség neve:</label>
        <input type="text" id="name" name="name" placeholder="Pl.: Újhely" required>

        <label for="type">Típus:</label>
        <select id="type" name="type" required>
            <option value="pickup_point">Átvételi Pont</option>
            <option value="in_store">Bolti Átvétel</option>
            <option value="courier">Kiszállítás Futárral</option>
        </select>

        <label for="cost">Költség (Ft):</label>
        <input type="number" id="cost" name="cost" placeholder="Pl.: 500" required>

        <label for="time_estimate">Idő becslés:</label>
        <input type="text" id="time_estimate" name="time_estimate" placeholder="Pl.: 1-2 munkanap" required>

        <button type="submit" id="add-button">Hozzáadás</button>
    </form>

    <h2>Átvételi lehetőségek listája:</h2>
    <h2>Átvételi Pontok</h2>
    <ul>
        <li class="open">Teszt Helyszín - Ingyenesn (Azonnal átvehető)
            <span class="actions">
                <a href="">Delete</a>
                <a href="">Close</a>
            </span>
        </li>
    </ul>
</body>

</html>