<?php
// Define database credentials
$host = "localhost";
$dbname = "epoka";
$username = "root";
$password = "root";

// Create a PDO instance and set error mode to exceptions
$pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Check if form was submitted
if (isset($_POST['submit'])) {
    // Get form input values
    $mtKilometre = $_POST['mtKilometre'];
    $mtJournee = $_POST['mtJournee'];

    // Prepare SQL statement to update values in parametre table
    $stmt = $pdo->prepare("UPDATE parametre SET mtKilometre = :mtKilometre, mtJournee = :mtJournee");

    // Bind values to parameters and execute statement
    $stmt->bindParam(":mtKilometre", $mtKilometre);
    $stmt->bindParam(":mtJournee", $mtJournee);
    $stmt->execute();

    // Redirect to same page to prevent form resubmission on page refresh
    header("Location: " . $_SERVER['REQUEST_URI']);
    exit;
}

// Retrieve current values from parametre table
$stmt = $pdo->query("SELECT mtKilometre, mtJournee FROM parametre");
$parametre = $stmt->fetch(PDO::FETCH_ASSOC);

// Close PDO connection
$pdo = null;
?>

<!-- HTML form -->

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Parametres</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
  <h2>PARAMETRES</h2>
<form method="post">
    <label for="mtKilometre">Cout par kilometre: </label>
    <input type="number" name="mtKilometre" id="mtKilometre" value="<?php echo $parametre['mtKilometre']; ?>"><br>
    <label for="mtJournee">Cout par jour: </label>
    <input type="number" name="mtJournee" id="mtJournee" value="<?php echo $parametre['mtJournee']; ?>"><br>
    <input type="submit" name="submit" value="Enregistrer">
</form>
<br>
<a href="parametre.php">Ajouter une distance</a><br>
<a href="menu.php">Retour au menu</a>



</body>
</html>