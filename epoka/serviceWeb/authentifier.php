<?php
try{
    
    if(!isset ($_GET["matricule"])) die("Matricule Absent");
    if(!isset ($_GET["motdepasse"])) die("Mot de passe absent");
    $matricule = $_GET["matricule"];
    $mdp = $_GET["motdepasse"];
    
    $pdo = new PDO('mysql:host=localhost;dbname=epoka;charset=utf8','root','root');

    $req = "SELECT salid,salnom,salprenom FROM salarie WHERE salid = :matr AND salmdp = :mdp";
    $stmt = $pdo->prepare($req);
    $stmt->bindParam(":matr",$matricule,PDO::PARAM_STR);
    $stmt->bindParam(":mdp",$mdp,PDO::PARAM_STR);
    $stmt->execute();
    //$stmt->store_result();

    if($stmt->rowCount() > 0){
 
    $stmt->bindColumn('salnom',$nom);
    $stmt->bindColumn('salprenom',$prenom);
    $stmt->bindColumn('salid',$id);
    $stmt->fetch();
    echo($prenom.':'.$nom.':'.$id);
}else echo('tt va mal');


    
}catch(Exception $e){
    die("ERREUR D’AUTHENTIFICATION : ".$e->getMessage());
}


//SELECT comNom,ComCP,missDebut,missFin FROM mission,commune WHERE missIdCommune = comId AND missIdSalarie = 2