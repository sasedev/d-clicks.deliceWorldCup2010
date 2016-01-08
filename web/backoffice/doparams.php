<?php
session_start();
if(!isset($_SESSION["alogged"])) {
	header("Location: login.php");
	exit(0);
}
require_once("../cnf/cfg.php");
$link = mysqli_connect($dbhost, $dbuser, $dbpass);
if (!$link) {
	die('Impossible de se connecter : ' . mysqli_error());
}

// Rendre la base de données $dbname, la base courante
$dbln = mysqli_select_db($link, $dbname);
if (!$dbln) {
	die ('Impossible de sélectionner la base de donn&eacute;es : ' . mysqli_error());
}
if($_POST["phase"] != "1" && $_POST["phase"] != "2" && $_POST["phase"] != "3") {
	header("Location:params.php");
} else {
	$phase = $_POST["phase"];
	$q = $_POST["q"];
	$sql = "DELETE FROM questions WHERE numetape = $phase";
	mysqli_query($link, $sql) or die("error mysql ".$sql." ".mysqli_error());
	if(is_array($q)) {
		foreach ($q as $vote) {
			$sql = "INSERT INTO questions (numetape, vote, createdat) VALUES ($phase, '$vote', NOW())";
			mysqli_query($link, $sql) or die("error mysql ".$sql." ".mysqli_error());
		}
	}
	header("Location:params.php");
}
?>