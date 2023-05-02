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


<h2>MISSIONS A VALIDER</h2>


<?php

$pdo = new PDO('mysql:host=localhost;dbname=epoka;charset=utf8','root','root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

$req = "SELECT missid,missdebut,missfin,missnom,missvalide,comnom,comCP,salnom,salprenom FROM mission,commune,salarie WHERE mission.missidcommune=commune.comid AND missidsalarie = salid AND salidsuperieur = :matr";

$id =$_SESSION['id'];

$idag =$_SESSION['agence'];
    $req2 = "SELECT comid FROM agence,commune WHERE agence.agidcommune=commune.comid AND agid = :ag";

    $stmt2 = $pdo->prepare($req2);
    $stmt2->bindParam(":ag",$idag,PDO::PARAM_STR);
    $stmt2->execute();

    $stmt2->bindColumn('comid',$comid);
    
    $stmt2->fetch();

function calculateMissionCost($missID)
{
    // Retrieve mission information
    global $pdo,$comid;
  
    $stmt = $pdo->prepare('SELECT * FROM mission WHERE missID = :missionId');
    $stmt->bindValue(':missionId', $missID);
    $stmt->execute();
    $mission = $stmt->fetch();
    
    if(!$mission) {
        return "Invalid mission ID";
    }
    
    // Retrieve the distance between the two communes, if available
    $stmt = $pdo->prepare('SELECT KM FROM distance WHERE idVilleD = :depart AND idVilleA = :arrivee');
    $stmt->bindValue(':depart', $comid);
    $stmt->bindValue(':arrivee', $mission['missIdCommune']);
    $stmt->execute();
    $distance = $stmt->fetchColumn();
    
    $nbDays = (strtotime($mission['missFin']) - strtotime($mission['missDebut'])) / (60 * 60 * 24);

    // If distance is not available, return "no distance"
    if(!$distance) {
        return "no distance";
    }
    
    $stmt = $pdo->prepare('SELECT * FROM parametre');
    $stmt->execute();
    $params = $stmt->fetch();
    
    $cost = ($distance * $params['mtKilometre']) + $nbDays * $params['mtJournee'];
    
    return $cost;
}



$stmt = $pdo->prepare($req);
$stmt->bindParam(":matr",$id,PDO::PARAM_STR);
    $stmt->execute();

echo "<table class='missions' border='1'><tr><th>CHARGÉ DE MISSION</th><th>NOM</th><th>DEBUT</th><th>FIN</th><th>DESTINATION</th><th>COUT</th><th>VALIDÉE</th></tr>";

while($row = $stmt->fetch(PDO::FETCH_ASSOC))
{
    echo "<tr>";
    echo "<td>" . $row['salprenom']." ". $row['salnom'] . "</td>";
    echo "<td>" . $row['missnom'] . "</td>";
    echo "<td>" . $row['missdebut'] . "</td>";
    echo "<td>" . $row['missfin'] . "</td>";
    echo "<td>" . $row['comnom']." (". $row['comCP'] . ")</td>";
    echo "<td>" . calculateMissionCost($row['missid'])  . "</td>";
    
    if ($row['missvalide']==1){echo "<td class='green'>✓</td>";}
    else{echo "<td > <a  href='serv_validation.php?idmission=".$row['missid'] ."'>VALIDER</a> </td>";}

    // if ($row['misspayee']==1){echo "<td class='green'>✓</td>";}
    //else{echo "<td class='red'>✗</td>";}

    echo "</tr>";
}
echo "</table>";

?>
<a href="menu.php">Retour au menu</a>
</body>
</html>