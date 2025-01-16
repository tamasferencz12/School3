<?php
// delete.php
$id = $_GET['id'];
$deliveryOptions = json_decode(file_get_contents('data.json'), true);

foreach ($deliveryOptions as $index => $option) {
    if ($option['id'] == $id) {
        unset($deliveryOptions[$index]);
        break;
    }
}

file_put_contents('data.json', json_encode($deliveryOptions, JSON_PRETTY_PRINT));
header("Location: index.php"); // Redirect back to the main page
exit;
