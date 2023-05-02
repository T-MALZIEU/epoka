<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="style.css">

<title>Document</title>
</head>
<body>
<?php

session_start();

if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
    exit;
}
?>


<h2>MES MISSIONS</h2>


<?php

$pdo = new PDO('mysql:host=localhost;dbname=epoka;charset=utf8','root','root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

$req = "SELECT missidsalarie,missid,missdebut,missfin,missnom,missvalide,misspayee,comnom,comCP FROM mission,commune WHERE mission.missidcommune=commune.comid AND missidsalarie = :matr";

$id =$_SESSION['id'];

$stmt = $pdo->prepare($req);
$stmt->bindParam(":matr",$id,PDO::PARAM_STR);
    $stmt->execute();

echo "<table class='missions' border='1'><tr><th>NOM</th><th>DEBUT</th><th>FIN</th><th>DESTINATION</th><th>VALIDÉE</th><th>PAYÉE</th></tr>";

while($row = $stmt->fetch(PDO::FETCH_ASSOC))
{
    echo "<tr>";
    echo "<td>" . $row['missnom'] . "</td>";
    echo "<td>" . $row['missdebut'] . "</td>";
    echo "<td>" . $row['missfin'] . "</td>";
    echo "<td>" . $row['comnom']." (". $row['comCP'] . ")</td>";
    
    if ($row['missvalide']==1){echo "<td class='green'>✓</td>";}
    else{echo "<td class='red'>✗</td>";}

    if ($row['misspayee']==1){echo "<td class='green'>✓</td>";}
    else{echo "<td class='red'>✗</td>";}

    echo "</tr>";
}
echo "</table>";

?>
<a href="menu.php">Retour au menu</a>
</body>
</html>