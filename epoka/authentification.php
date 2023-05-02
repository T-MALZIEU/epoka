<?php
try{
    $pdo = new PDO('mysql:host=localhost;dbname=epoka;charset=utf8','root','root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    
    if(!isset ($_GET["matricule"])) die("Matricule Absent");
    if(!isset ($_GET["mdp"])) die("Mot de passe absent");
    
    $matricule = $_GET["matricule"];
    $mdp = $_GET["mdp"];
    
    $req = "SELECT salid,salnom,salprenom,salidsuperieur,salidagence,salresponsable,salcompable FROM salarie WHERE salid = :matr AND salmdp = :mdp";
    $stmt = $pdo->prepare($req);
    $stmt->bindParam(":matr",$matricule,PDO::PARAM_STR);
    $stmt->bindParam(":mdp",$mdp,PDO::PARAM_STR);
    $stmt->execute();
    
    
    if($stmt->rowCount() > 0){
        
        $stmt->bindColumn('salnom',$nom);
        $stmt->bindColumn('salprenom',$prenom);
        $stmt->bindColumn('salid',$id);
        $stmt->bindColumn('salidagence',$idag);
        $stmt->bindColumn('salidsuperieur',$idsup);
        $stmt->bindColumn('salresponsable',$estres);
        $stmt->bindColumn('salcompable',$estcom);
        $stmt->fetch();

        session_start();
        $_SESSION['nom']=$nom;
        $_SESSION['prenom']=$prenom;
        $_SESSION['id']=$id;
        $_SESSION['superieur']=$idsup;
        $_SESSION['agence']=$idag;
        $_SESSION['estres']=$estres;
        $_SESSION['estcom']=$estcom;
        $_SESSION['loggedin']=TRUE;


        //echo("Bienvenue ".$prenom.' '.$nom);
        header("location:menu.php");
    }else {
        session_start();
        $_SESSION['ERREUR']="<div class=\"error\"> ERREUR: MOT DE PASSE OU UTILISATEUR INCORECT</div>";
        header('location:index.php');
    }
}catch(Exception $e){
    die("[{\"nom\":"."chié dans la soupe : ".$e->getMessage()."}]");
}
?>