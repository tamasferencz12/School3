<?php
// toggle.php
$id = $_GET['id'];
$deliveryOptions = json_decode(file_get_contents('data.json'), true);

foreach ($deliveryOptions as &$option) {
    if ($option['id'] == $id) {
        $option['isOpen'] = !$option['isOpen']; // Toggle the isOpen status
        break;
    }
}

file_put_contents('data.json', json_encode($deliveryOptions, JSON_PRETTY_PRINT));
header("Location: index.php"); // Redirect back to the main page
exit;
