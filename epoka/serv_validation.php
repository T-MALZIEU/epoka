<?php
$pdo = new PDO('mysql:host=localhost;dbname=epoka;charset=utf8','root','root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    
    if(!isset ($_GET["idmission"])) die("IDMISSION Absent");

    $idmission = $_GET["idmission"];

    $req="UPDATE mission SET missvalide=1 WHERE missid = :id";

    $stmt = $pdo->prepare($req);
    $stmt->bindParam(":id",$idmission,PDO::PARAM_STR);
    $stmt->execute();

    header("location:validation.php");
