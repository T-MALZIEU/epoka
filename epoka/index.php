<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authentification</title>
</head>

<body>

<h2>IDENTIFICATION EPOKA</h2>




<?php 
session_start();
if (isset($_SESSION['ERREUR'])) {
    
    $error = $_SESSION['ERREUR']; 
    echo $error;
    
    
}
session_destroy();?>
<form action="authentification.php" class="auth">
<label for="matricule">Entrez votre matricule :</label>
<input type="number" id="name" name="matricule" required  maxlength="8" size="10" placeholder="Matricule">

<br><label for="mdp">Entrez votre mot de passe : &nbsp</label>
<input type="password" id="name" name="mdp" required   size="10" placeholder="Mot de passe">
<br><button>Se connecter</button>
</form>

</body>
</html>