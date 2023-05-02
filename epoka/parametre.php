<?php
$dsn = "mysql:host=localhost;dbname=epoka;charset=utf8";
$username = "root";
$password = "root";
$options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);

try {
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $villeD = $_POST["villeD"];
    $villeA = $_POST["villeA"];
    $distance = $_POST["distance"];

    // Check if the distance already exists in the `distance` table
    $stmt = $pdo->prepare("SELECT * FROM distance WHERE idVilleD = :villeD AND idVilleA = :villeA");
    $stmt->bindParam(":villeD", $villeD);
    $stmt->bindParam(":villeA", $villeA);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $error_message = "Cette distance existe déjà!";
    } else {
        $stmt = $pdo->prepare("INSERT INTO distance (idVilleD, idVilleA, KM) VALUES (:villeD, :villeA, :distance)");
        $stmt->bindParam(":villeD", $villeD);
        $stmt->bindParam(":villeA", $villeA);
        $stmt->bindParam(":distance", $distance);
        $stmt->execute();
        $success_message = "Distance ajoutée avec succès";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Parametres</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
  <h2>PARAMETRES</h2>

    <?php if(isset($error_message)): ?>
        <div style="error"><?php echo $error_message ?></div>
    <?php endif; ?>
    <?php if(isset($success_message)): ?>
        <div style="color: green;"><?php echo $success_message ?></div>
    <?php endif; ?>

    <form method="post">
        <label for="villeD">Ville de départ:</label>
        <select id="villeD" name="villeD">
            <?php
            $stmt = $pdo->query("SELECT comId, comNom,comCP FROM commune ORDER BY comNom");
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value='" . $row['comId'] . "'>" . $row['comNom']."(".$row['comCP'].")" . "</option>";
            }
            ?>
        </select>
        <br>
        <label for="villeA">Ville d'arrivée:</label>
        <select id="villeA" name="villeA">
            <?php
            $stmt = $pdo->query("SELECT comId, comNom,comCP FROM commune ORDER BY comNom");
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value='" . $row['comId'] . "'>" . $row['comNom'] ."(". $row['comCP'] . ")" . "</option>";
            }
            ?>
        </select>
        <br>
        <label for="distance">Distance (en kilomètres):</label>
        <input type="number" id="distance" name="distance" min="0">
        <br>
        <input type="submit" value="Ajouter">
    </form>
    <br>
    <a href="param2.php">Modifier les couts</a><br>

    <a href="menu.php">Retour au menu</a>


</body>
</html>
