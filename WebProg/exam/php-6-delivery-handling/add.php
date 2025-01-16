<?php
// add.php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $type = $_POST['type'];
    $cost = $_POST['cost'];
    $time_estimate = $_POST['time_estimate'];

    $newOption = [
        'id' => uniqid(),
        'name' => $name,
        'type' => $type,
        'cost' => $cost,
        'time_estimate' => $time_estimate,
        'isOpen' => true // New options are initially active
    ];

    $deliveryOptions = json_decode(file_get_contents('data.json'), true);
    $deliveryOptions[] = $newOption;

    file_put_contents('data.json', json_encode($deliveryOptions, JSON_PRETTY_PRINT));
    header("Location: index.php"); // Redirect back to the main page
    exit;
}
