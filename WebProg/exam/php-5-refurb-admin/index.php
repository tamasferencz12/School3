<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task 5</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <h1>5. Termék adminisztráció</h1>
    <div id="success">
        <h2>Új termék elmentve! - <sorszám> .sorszám alatt</h2>
    </div>
    <form action="validate.php" method="GET" novalidate>
        <label for="name">Név:</label><input type="text" name="name" id="name" value="">
        <span class="error-message"></span>
        <label for="stock">Darabszám:</label><input type="number" name="stock" id="stock" value="">
        <span class="error-message"></span>
        <label for="type">Termék típusa:</label>
        <select name="type" id="type">
            <option value="">Válassz termék típust!</option>
            <option value="laptop">Laptop</option>
            <option value="phone">Mobiltelefon</option>
            <option value="pc">Komplett Számítógép</option>
        </select>
        <span class="error-message"></span>
        <label for="specifications">Specifikáció</label>
        <textarea name="specifications" id="specifications" cols="30" rows="10"></textarea>
        <ul class="error-messages">
        </ul>
        <input type="submit" value="Hozzáadás">
    </form>
    <div class="help">

        <h2>Segítség a teszteléshez</h2>

        <h3>validate.php</h3>
        <ul>
            <li><a href="validate.php?">Minden hiányzik</a></li>
            <li><a href="validate.php?name=Test&stock=34&type=laptop&specifications=test@test.hu,32GB,456567">Túl rövid név</a></li>
            <li><a href="validate.php?name=Test Elek&stock=134&type=laptop&specifications=test@test.hu,32GB,456567">Túl magas darabszám</a></li>
            <li><a href="validate.php?name=Test Elek&stock=nem szam&type=laptop&specifications=test@test.hu,32GB,456567">Darabszám nem szám</a></li>
            <li><a href="validate.php?name=Test Elek&stock=34&type=laptop&specifications=test@test.hu,32GB">Kevés paraméter</a></li>
            <li><a href="validate.php?name=Test Elek&stock=34&type=laptop&specifications=test@test,32GB,456567">Hibás e-mail cím</a></li>
            <li><a href="validate.php?name=Test Elek&stock=34&type=laptop&specifications=test@test.hu,132GB,456567">Magas RAM mennyiség</a></li>
            <li><a href="validate.php?name=Test Elek&stock=34&type=laptop&specifications=test@test.hu,32GB,11456567">Magas ár</a></li>
            <li><a href="validate.php?name=Test Elek&stock=34&type=laptop&specifications=test@test.hu,32GB,456567">Helyes bevitel</a></li>

        </ul>

        <h3>Helyben</h3>
        <ul>
            <li><a href="index.php?">Minden hiányzik</a></li>
            <li><a href="index.php?name=Test&stock=34&type=laptop&specifications=test@test.hu,32GB,456567">Túl rövid név</a></li>
            <li><a href="index.php?name=Test Elek&stock=134&type=laptop&specifications=test@test.hu,32GB,456567">Túl magas darabszám</a></li>
            <li><a href="index.php?name=Test Elek&stock=nem szam&type=laptop&specifications=test@test.hu,32GB,456567">Darabszám nem szám</a></li>
            <li><a href="index.php?name=Test Elek&stock=34&type=laptop&specifications=test@test.hu,32GB">Kevés paraméter</a></li>
            <li><a href="index.php?name=Test Elek&stock=34&type=laptop&specifications=test@test,32GB,456567">Hibás e-mail cím</a></li>
            <li><a href="index.php?name=Test Elek&stock=34&type=laptop&specifications=test@test.hu,132GB,456567">Magas RAM mennyiség</a></li>
            <li><a href="index.php?name=Test Elek&stock=34&type=laptop&specifications=test@test.hu,32GB,11456567">Magas ár</a></li>
            <li><a href="index.php?name=Test Elek&stock=34&type=laptop&specifications=test@test.hu,32GB,456567">Helyes bevitel</a></li>
        </ul>
    </div>
</body>

</html>