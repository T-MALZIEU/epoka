<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Epoka™</title>
<link rel="stylesheet" href="style.css">
</head>
<body>


<?php
    // DEMARE LA SESSION ET VIRE TOUT LES ACCES NON AUTHORISÉS
    session_start();
    if (!isset($_SESSION['loggedin'])) {
        header('location:index.php');
        exit;
    }
?>

<h2>MENU PRINCIPAL</h2>

<div>
<p>Bienvenue <?=$_SESSION['prenom']?> <?=$_SESSION['nom']?> .</p>
</div>


<?php 
    //DIT QUI QUE C'EST LE BOSS 


    $idsup =$_SESSION['superieur'];
    $id=$_SESSION['id'];

    

    $pdo = new PDO('mysql:host=localhost;dbname=epoka;charset=utf8','root','root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    if($id!=$idsup){
    $req = "SELECT salnom,salprenom FROM salarie WHERE salid = :matr";


    $stmt = $pdo->prepare($req);
    $stmt->bindParam(":matr",$idsup,PDO::PARAM_STR);
    $stmt->execute();

    $stmt->bindColumn('salnom',$supnom);
    $stmt->bindColumn('salprenom',$supprenom);
    $stmt->fetch();
    
    echo "Votre superieur est ".$supprenom." ".$supnom.".</br>";
    }
    //DIT OU C'EST QUE C'EST QUE LE SALARIÉ QU'IL Y BOSSE

    $idag =$_SESSION['agence'];
    $req2 = "SELECT agnom,comnom,comcp FROM agence,commune WHERE agence.agidcommune=commune.comid AND agid = :ag";

    $stmt2 = $pdo->prepare($req2);
    $stmt2->bindParam(":ag",$idag,PDO::PARAM_STR);
    $stmt2->execute();

    $stmt2->bindColumn('agnom',$agnom);
    $stmt2->bindColumn('comnom',$agville);
    $stmt2->bindColumn('comcp',$agvillecp);
    $stmt2->fetch();
    echo "Vous travaillez pour ".$agnom." à ".$agville." (".$agvillecp.").</br></br>";


    //AFFICHE CES OPTIONS DANS LE MENU SI LE SALARIÉ EST RESPONSABLE ET/OU COMPTABLE 
    if ($_SESSION['estres']==1){ echo "<a href='validation.php'>Validation des missions</a></br>";}
    if ($_SESSION['estcom']==1){ echo "<a href='remboursement.php'>Remboursement des missions</a>";}
?>


</br>
<a href="mesmissions.php">Voir mes missions</a></br>
<a href="parametre.php">Parametres</a>
</br></br>
<form action="logout.php">
<button>Deconnexion</button>
</form>


</body>
</html>