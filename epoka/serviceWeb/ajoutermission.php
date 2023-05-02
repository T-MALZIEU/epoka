<?php
try{
    $pdo = new PDO('mysql:host=localhost;dbname=epoka;charset=utf8','root','root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

    if(!isset ($_GET["depart"])) die("DATE DE DÉPART Absent");
    if(!isset ($_GET["fin"])) die("DATE DE FIN absent");
    if(!isset ($_GET["lieu"])) die("DESTINATION absent");
    if(!isset ($_GET["intitule"])) die("INTITULÉ absent");
    if(!isset ($_GET["matricule"])) die("NUMÉRO D'EMPLOYÉ absent");

    $matricule = $_GET["matricule"];
    $depart = $_GET["depart"];
    $fin = $_GET["fin"];
    $lieu = $_GET["lieu"];
    $intitule = $_GET["intitule"];
    
    $req = "INSERT INTO mission (missID, missDebut, missFin, missNom, missIdCommune, missIdSalarie, missValide, missPayee) VALUES (NULL, :depart, :fin, :intitule, :lieu, :matr, 0, 0);";
    $stmt = $pdo->prepare($req);
    $stmt->bindParam(":matr",$matricule,PDO::PARAM_STR);
    $stmt->bindParam(":lieu",$lieu,PDO::PARAM_STR);
    $stmt->bindParam(":intitule",$intitule,PDO::PARAM_STR);
    $stmt->bindParam(":fin",$fin,PDO::PARAM_STR);
    $stmt->bindParam(":depart",$depart,PDO::PARAM_STR);
    
    
    $stmt->execute();
    echo("TOUT FONCTIONNE ICI");
    
   //http://172.16.47.26/epoka/ServiceWeb/ajoutermission?depart=2023-03-08&fin=2023-03-10&lieu=12345&intitule=%22testtest%22&matricule=2 
    
}catch(Exception $e){
    die("[{\"nom\":"."chié dans la soupe : ".$e->getMessage()."}]");
}
?>
