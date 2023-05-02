<?php
try{
$pdo = new PDO('mysql:host=localhost;dbname=epoka;charset=utf8','root','root');


$req = "SELECT comNom,comCP,comID FROM commune  ORDER BY comnom";
$stmt = $pdo->prepare($req);
$stmt->execute();
echo(json_encode($stmt->fetchAll(PDO::FETCH_ASSOC)));



}catch(Exception $e){
die("[{\"nom\":"."chié dans la soupe : ".$e->getMessage()."}]");
}
?>