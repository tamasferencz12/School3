<?php
$data = json_decode(file_get_contents("data.json"), true);
// print_r($data);

// a. Dinamikus fájlnév és árformázás
function formatPrice($price)
{
    return number_format($price, 0, ',', ' ') . ' Ft';
}

// b. CSS osztály a készlet alapján
function getStockClass($stock)
{
    if ($stock == 0) {
        return 'sold-out';
    } elseif ($stock > 120) {
        return 'high-stock';
    }
    return '';
}

// c. Akciós ár kiszámítása
function getDiscountedPrice($price, $lowest_price)
{
    return ($price == $lowest_price) ? round($price * 0.85) : round($price * 0.90);
}

// d. Legfrissebb értékesítési dátum
function getLatestSaleDate($sales)
{
    return max(array_keys($sales));
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>PHP-1</title>
    <link rel="stylesheet" href="index.css" />
</head>

<body>
    <h1>1. Termék lista oldal</h1>
    <div class="container">
        <?php foreach ($data as $product): ?>
            <?php
            $image = "assets/" . str_replace(' ', '_', $product['name']) . ".png";
            $price = formatPrice($product['price']);
            $stockClass = getStockClass($product['stock']);
            $latestSaleDate = getLatestSaleDate($product['sales']);
            $discountedPrice = getDiscountedPrice($product['price'], $product['lowest_price']);
            ?>

            <div class="<?php echo $stockClass; ?>">
                <img src="<?php echo $image; ?>">
                <div class="title"><?php echo $product['name']; ?></div>

                <?php if ($product['stock'] == 0): ?>
                    <div>Utoljára elérhető: <?php echo $latestSaleDate; ?></div>
                <?php elseif ($product['stock'] > 120): ?>
                    <div class="price-container">
                        <div class="original-price"><?php echo $price; ?></div>
                        <div class="discounted-price"><?php echo formatPrice($discountedPrice); ?></div>
                    </div>
                    <div class="stock-info">Raktárkészlet: <?php echo $product['stock']; ?></div>
                <?php else: ?>
                    <div class="price"><?php echo $price; ?></div>
                    <div class="stock-info">Raktárkészlet: <?php echo $product['stock']; ?></div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
</body>

</html>