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
	header("Location:excel.php");
} else {
	$phase = $_POST["phase"];
	$q = $_POST["q"];
	if(!is_array($q)) {
		header("Location:excel.php");
	} else {
header('Content-type: application/excel');
$filename = "rapport_jeu_Delice_phase_".$phase;
foreach ($q as $vote) {
	$filename .= "_".$vote;
}
$filename .= "_du_".date('Y-m-j_H-i-s').".xls";
header('Content-Disposition: attachment; filename="'.$filename.'"');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Administration du Jeu Delice</title>
<style type="text/css">
body.admin {
	margin-top: 0px;
	font-family:Tahoma,Arial,sans-serif;
	font-size: 12px;
	color:black;
	background-color:white;
}

.Error {

	font-family: Tahoma,Arial,sans-serif;
	font-size: 13px;
	color: #E327B1;
	font-weight: bold;
}
input.admin {
	color:black;
	background-color:white;
	font-family:Tahoma,Arial,sans-serif;
	font-size: 12px;
	width: 150px;
}

select.admin {
	color:black;
	background-color:white;
	font-family:Tahoma,Arial,sans-serif;
	font-size: 12px;
	width: 150px;
}

h1.admin {
	font-family:Tahoma,Arial,sans-serif;
	color:white;
	background-color:#525D76;
	font-size:22px;
}

h2.admin {
	font-family:Tahoma,Arial,sans-serif;
	color:white;
	background-color:#525D76;
	font-size:16px;
}

h3.admin {
	font-family:Tahoma,Arial,sans-serif;
	color:white;
	background-color:#525D76;
	font-size:14px;
}

h4.admin {
	font-family:Tahoma,Arial,sans-serif;
	color:white;
	background-color:#525D76;
	font-size:12px;
}

b.admin {
	font-family:Tahoma,Arial,sans-serif;
	color:white;
	background-color:#525D76;
}

a.admin {
	color : black;
	font-size: 12px;
}

hr.admin {
	color : #525D76;
}

tr.admin {
	background-color: #eeeeee;
}

th.admin {
	background-color: #eeeeee;
}

td.a1 {
	background-color: #cccccc;
}

td.a2 {
	background-color: #aaaaaa;
}
td.txtbg {
	background-color: white;
}
</style>
</head>

<body class="admin">
<table align="center" width="750" >

<tr class="admin"  valign="top">
	<td colspan="10" height="69px" style="">
		<img src="www.coupedumonde-delice.com/backoffice/images/bkoffice_01.jpg" alt="D-Clicks" border="0" />
	</td>
</tr>
<tr class="admin"  valign="top">
	<td colspan="10">&nbsp;</td>
</tr>
<tr class="admin"  valign="top">
	<td colspan="10">&nbsp;</td>
</tr>
<tr class="admin"  valign="top">
	<td colspan="10">&nbsp;</td>
</tr>
<tr class="admin"  valign="top">
	<td colspan="10">&nbsp;</td>
</tr>
<tr class="admin"  valign="top">
	<td align="right" class="a1" colspan="2">Nombre de parties joués  : &nbsp;</td>
	<td class="a2"> &nbsp;
<?php
if($phase == 1) {
	$sql = "SELECT COUNT(*) AS j FROM players WHERE createdat < '2010-06-28 00:00:00' AND vote IN (";
	$i = 0;
	foreach ($q as $vote) {
		$i++;
		$sql .= "'$vote'";
		if($i < count($q)) {
			$sql .= ", ";
		}
	}
	$sql .= ")";
} else if($phase == 2) {
	$sql = "SELECT COUNT(*) AS j FROM players WHERE createdat >= '2010-06-28 00:00:00' AND createdat < '2010-07-12 00:00:00' AND vote IN (";
	$i = 0;
	foreach ($q as $vote) {
		$i++;
		$sql .= "'$vote'";
		if($i < count($q)) {
			$sql .= ", ";
		}
	}
	$sql .= ")";
} else if($phase == 3) {
	$sql = "SELECT COUNT(*) AS j FROM players WHERE createdat >= '2010-07-12 00:00:00' AND vote IN (";
	$i = 0;
	foreach ($q as $vote) {
		$i++;
		$sql .= "'$vote'";
		if($i < count($q)) {
			$sql .= ", ";
		}
	}
	$sql .= ")";
}
$rs = mysqli_query($link, $sql) or die("error mysql ".$sql." ".mysqli_error());
$row = mysqli_fetch_object($rs) or die("error mysql ".$sql." ".mysqli_error());
echo $row->j;
$j = $row->j;
?>
	</td>
	<td align="left" width="50%" colspan="7"> Indique le nombre de pronostic effectués sur le site.
	</td>
</tr>
<?php
if($j > 0) {
?>
<tr>
	<td colspan="10">&nbsp;</td>
</tr>
<tr>
	<td class="a2" colspan="10" align="center">Rapport des joueurs:&nbsp;</td>
</tr>
<tr class="admin">
	<td align="center" class="a1">
	id
	</td>
	<td align="center" class="a1">
	nom
	</td>
	<td align="center" class="a1">
	prenom
	</td>
	<td align="center" class="a1">
	age
	</td>
	<td align="center" class="a1">
	email
	</td>
	<td align="center" class="a1">
	gsm
	</td>
	<td align="center" class="a1">
	Vote :
	</td>
	<td align="center" class="a1">
	&nbsp;
	</td>
	<td align="center" class="a1">
	date
	</td>
	<td align="center" class="a1">
	ami
	</td>
</tr>
<?php
if($phase == 1) {
	$sql = "SELECT * FROM players WHERE createdat < '2010-06-28 00:00:00' AND vote IN (";
	$i = 0;
	foreach ($q as $vote) {
		$i++;
		$sql .= "'$vote'";
		if($i < count($q)) {
			$sql .= ", ";
		}
	}
	$sql .= ") ORDER BY tel ASC, vote ASC";
} else if($phase == 2) {
	$sql = "SELECT* FROM players WHERE createdat >= '2010-06-28 00:00:00' AND createdat < '2010-07-12 00:00:00' AND vote IN (";
	$i = 0;
	foreach ($q as $vote) {
		$i++;
		$sql .= "'$vote'";
		if($i < count($q)) {
			$sql .= ", ";
		}
	}
	$sql .= ") ORDER BY tel ASC, vote ASC";
} else if($phase == 3) {
	$sql = "SELECT * FROM players WHERE createdat >= '2010-07-12 00:00:00' AND createdat < '2010-07-19 00:00:00' AND vote IN (";
	$i = 0;
	foreach ($q as $vote) {
		$i++;
		$sql .= "'$vote'";
		if($i < count($q)) {
			$sql .= ", ";
		}
	}
	$sql .= ") ORDER BY tel ASC, vote ASC";
}
$rs = mysqli_query($link, $sql) or die ($sql);
while($row = mysqli_fetch_object($rs)) {
?>
<tr class="admin">
	<td align="center">
	<?php echo $row->id; ?>
	</td>
	<td align="center">
	<?php echo $row->nom; ?>
	</td>
	<td align="center">
	<?php echo $row->prenom; ?>
	</td>
	<td align="center">
	<?php echo $row->age; ?>
	</td>
	<td align="center">
	<?php echo $row->email; ?>
	</td>
	<td align="center">
	<?php echo $row->tel; ?>
	</td>
	<td align="center">
	<?php switch ($row->vote) {
		case 'd1': echo "Italie en 1/2 finale"; break;
				case 'd2': echo "La France championne du Monde"; break;
				case 'd3': echo "Le Brésil en 1/2 finale"; break;
				case 'd4': echo "L'algérie gagne contre la Slovénie"; break;
				case 'd5': echo "'Algérie gagne contre l'angleterre"; break;
				case 'd6': echo "L'algérie perd contre l'angleterre"; break;
				case 'd7': echo "L'allemagne ne gagnera pas la coupe"; break;
				case 'd8': echo "L'espagne en 1/2 finale"; break;
				case 'd9': echo "La Hollande n'ira pas en 1/2 finale"; break;
				case 'd10': echo "Le Cameroun gagne la demi finale"; break;

				case 'g1': echo "L'Italie ne gagnera pas en demie finale"; break;
				case 'g2': echo "La France gagne la 1/2 finale"; break;
				case 'g3': echo "Le Brésil perdra la demi finale"; break;
				case 'g4': echo "La slovénie gagne contre l'algérie"; break;
				case 'g5': echo "Algérie vs Usa égalité"; break;
				case 'g6': echo "L'usa gagne contre l'algérie"; break;
				case 'g7': echo "L'allemagne perd en 1/2 finale"; break;
				case 'g8': echo "L'espagne ne gagnera pas la coupe"; break;
				case 'g9': echo "La Hollande championne du monde"; break;
				case 'g10': echo "Le cameroun ne sera pas en 1/2 finale"; break;

				case 'j1': echo "L'italie championne"; break;
				case 'j2': echo "La france ne passera pas en 1/2 finale"; break;
				case 'j3': echo "Le brésil ne gagnera pas la coupe"; break;
				case 'j4': echo "Egalité Slovenie vs Algérie"; break;
				case 'j5': echo "L'algérie gagne contre la slovénie"; break;
				case 'j6': echo "Egalité Algérie vs Angleterre"; break;
				case 'j7': echo "L'allemagne championne du monde"; break;
				case 'j8': echo "L'espagne ne passera pas en demie finale"; break;
				case 'j9': echo "La Hollande en finale"; break;
				case 'j10': echo "Le Nigéria en demi finale"; break;
	} ?>
	</td>
	<td align="center">
	&nbsp;
	</td>
	<td align="center">
	<?php echo $row->createdat; ?>
	</td>
	<td align="center">
	<?php echo $row->ami; ?>
	</td>
</tr>
<?php
}
}
?>
</table>
</body>
</html>
<?php
	}
}
?>