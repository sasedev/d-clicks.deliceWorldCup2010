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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Administration du Jeu Delice</title>
<style type="text/css">
body.admin {
	margin:0px; padding:0px;
	font-family:Tahoma,Arial,sans-serif;
	font-size: 12px;
	color:black;
	background-color:#e1e1e1;
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
th.a1 {
	background-color: #cccccc;
}

th.a2 {
	background-color: #aaaaaa;
}
td.txtbg {
	background-color: white;
}
</style>
</head>

<body class="admin">
<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td colspan="3" height="69px" style="">
		<img src="images/bkoffice_01.jpg" alt="D-Clicks" border="0" />
	</td>
</tr>
<tr>
	<td width="29px" height="21px" style="background-image:url(images/bkoffice_03.jpg); background-position:bottom right; background-repeat:no-repeat;"></td>
    <td height="21px" style="background-image:url(images/bkoffice_04.jpg); background-position:bottom center; background-repeat:repeat-x;"></td>
    <td width="27px" height="21px" style="background-image:url(images/bkoffice_05.jpg); background-position:bottom left; background-repeat:no-repeat;"></td>
</tr>
<tr>
	<td style="background-image:url(images/bkoffice_07.jpg); background-position:right; background-repeat:repeat-y;"></td>
    <td style="background-color:#FFFFFF;">
    	<table align="center" width="100%" >
		<tr class="admin"  valign="top">
			<td width="20%"><a href="index.php" class="admin"> Index </a></td>
			<td width="20%"><a class="admin" href="params.php">Paramètrage</a></td>
			<td width="20%"><a class="admin" href="excel.php">Exporter vers Excel</a></td>
			<td width="40%" align="right"><a class="admin" href="logout.php">D&eacute;connexion</a></td>
		</tr>
		</table>
		<hr size="1" noshade="noshade"/>
		<table align="center" width="100%" >
		<tr class="admin"  valign="top">
			<td align="left"> &nbsp;
			</td><td align="right" class="a1">Nombre de parties joués : &nbsp;</td>
			<td class="a2"> &nbsp;
		<?php
		$sql = "SELECT COUNT(*) AS j FROM players";
		$rs = mysqli_query($link, $sql) or die("error mysql ".$sql." ".mysqli_error());
		$row = mysqli_fetch_object($rs) or die("error mysql ".$sql." ".mysqli_error());
		$j = $row->j;
		if($j > 0) {
			echo "<a href=\"?op=games\" class=\"admin\">".$row->j."</a>";
		} else {
			echo $row->j;
		}
		?></td>
			<td align="left" width="50%" colspan="7"> Indique le nombre de pronostic effectués sur le site.
			</td>
		</tr>

		</table>
		<hr size="1" noshade="noshade"/>
		<?php
		$op = "";
		if (isset($_REQUEST["op"])) {
			$op = $_REQUEST["op"];
		}

		if($op=="games") {
			if($j > 0) {
				$sql = "SELECT * FROM players";
				$order = "";
				if (isset($_REQUEST["order"])) {
					$order = $_REQUEST["order"];
				}
				$dir = "";
				if (isset($_REQUEST["dir"])) {
					$dir = $_REQUEST["dir"];
				}
				if($order == "id") {
					$sql .=" ORDER BY id";
					if($dir == "asc") {
						$sql .=" ASC";
					}
					if($dir == "desc") {
						$sql .=" DESC";
					}
				}
				if($order == "gsm") {
					$sql .=" ORDER BY tel";
					if($dir == "asc") {
						$sql .=" ASC";
					}
					if($dir == "desc") {
						$sql .=" DESC";
					}
				}
				if($order == "nom") {
					$sql .=" ORDER BY nom";
					if($dir == "asc") {
						$sql .=" ASC";
					}
					if($dir == "desc") {
						$sql .=" DESC";
					}
				}
				if($order == "prenom") {
					$sql .=" ORDER BY prenom";
					if($dir == "asc") {
						$sql .=" ASC";
					}
					if($dir == "desc") {
						$sql .=" DESC";
					}
				}
				if($order == "age") {
					$sql .=" ORDER BY age";
					if($dir == "asc") {
						$sql .=" ASC";
					}
					if($dir == "desc") {
						$sql .=" DESC";
					}
				}
				if($order == "email") {
					$sql .=" ORDER BY email";
					if($dir == "asc") {
						$sql .=" ASC";
					}
					if($dir == "desc") {
						$sql .=" DESC";
					}
				}
				if($order == "vote") {
					$sql .=" ORDER BY vote";
					if($dir == "asc") {
						$sql .=" ASC";
					}
					if($dir == "desc") {
						$sql .=" DESC";
					}
				}
				if($order == "ami") {
					$sql .=" ORDER BY ami";
					if($dir == "asc") {
						$sql .=" ASC";
					}
					if($dir == "desc") {
						$sql .=" DESC";
					}
				}
				if($order == "date") {
					$sql .=" ORDER BY createdat";
					if($dir == "asc") {
						$sql .=" ASC";
					}
					if($dir == "desc") {
						$sql .=" DESC";
					}
				}
				$rs = mysqli_query($link, $sql);
		?>
		<table align="center" width="100%" >
		<tr>
			<th class="a2" colspan="10" align="center">Liste des personnes ayant joué&nbsp;</th>
		</tr>
		<tr class="admin">
			<th align="center" class="a1">
			<a href="?op=games&order=id&dir=asc" class="admin"><img src="images/bas.png" alt="ASC" border="0" width="12px" height="12px" /></a>
			 &nbsp; ID &nbsp;
			<a href="?op=games&order=id&dir=desc" class="admin"><img src="images/haut.png" alt="DESC" border="0" width="12px" height="12px" /></a>
			</th>
			<th align="center" class="a1">
			<a href="?op=games&order=gsm&dir=asc" class="admin"><img src="images/bas.png" alt="ASC" border="0" width="12px" height="12px" /></a>
			 &nbsp; GSM &nbsp;
			<a href="?op=games&order=gsm&dir=desc" class="admin"><img src="images/haut.png" alt="DESC" border="0" width="12px" height="12px" /></a>
			</th>
			<th align="center" class="a1">
			<a href="?op=games&order=nom&dir=asc" class="admin"><img src="images/bas.png" alt="ASC" border="0" width="12px" height="12px" /></a>
			 &nbsp; Nom &nbsp;
			<a href="?op=games&order=nom&dir=desc" class="admin"><img src="images/haut.png" alt="DESC" border="0" width="12px" height="12px" /></a>
			</th>
			<th align="center" class="a1">
			<a href="?op=games&order=prenom&dir=asc" class="admin"><img src="images/bas.png" alt="ASC" border="0" width="12px" height="12px" /></a>
			 &nbsp; Prenom &nbsp;
			<a href="?op=games&order=prenom&dir=desc" class="admin"><img src="images/haut.png" alt="DESC" border="0" width="12px" height="12px" /></a>
			</th>
			<th align="center" class="a1">
			<a href="?op=games&order=age&dir=asc" class="admin"><img src="images/bas.png" alt="ASC" border="0" width="12px" height="12px" /></a>
			 &nbsp; Age &nbsp;
			<a href="?op=games&order=age&dir=desc" class="admin"><img src="images/haut.png" alt="DESC" border="0" width="12px" height="12px" /></a>
			</th>
			<th align="center" class="a1">
			<a href="?op=games&order=email&dir=asc" class="admin"><img src="images/bas.png" alt="ASC" border="0" width="12px" height="12px" /></a>
			 &nbsp; Email &nbsp;
			<a href="?op=games&order=email&dir=desc" class="admin"><img src="images/haut.png" alt="DESC" border="0" width="12px" height="12px" /></a>
			</th>
			<th align="center" class="a1" colspan="2">
			<a href="?op=games&order=vote&dir=asc" class="admin"><img src="images/bas.png" alt="ASC" border="0" width="12px" height="12px" /></a>
			 &nbsp; Vote &nbsp;
			<a href="?op=games&order=vote&dir=desc" class="admin"><img src="images/haut.png" alt="DESC" border="0" width="12px" height="12px" /></a>
			</th>
			<th align="center" class="a1">
			<a href="?op=games&order=ami&dir=asc" class="admin"><img src="images/bas.png" alt="ASC" border="0" width="12px" height="12px" /></a>
			 &nbsp; Gsm Ami &nbsp;
			<a href="?op=games&order=ami&dir=desc" class="admin"><img src="images/haut.png" alt="DESC" border="0" width="12px" height="12px" /></a>
			</th>
			<th align="center" class="a1">
			<a href="?op=games&order=date&dir=asc" class="admin"><img src="images/bas.png" alt="ASC" border="0" width="12px" height="12px" /></a>
			 &nbsp; Date &nbsp;
			<a href="?op=games&order=date&dir=desc" class="admin"><img src="images/haut.png" alt="DESC" border="0" width="12px" height="12px" /></a>
			</th>
		</tr>
		<?php

				while($row = mysqli_fetch_object($rs)) {
		?>
		<tr class="admin">
			<td align="center">
			<?php echo $row->id; ?>
			</td>
			<td align="center">
			<?php echo $row->tel; ?>
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
			<?php
			/*switch ($row->vote) {
				case 0: echo "Aucun"; break;
				case 1: echo "Recharge GSM"; break;
				case 2: echo "IPod"; break;
				case 3: echo "IPhone"; break;
				case 4: echo "Wii"; break;
				case 5: echo "PC Portable"; break;
			}*/
			echo $row->vote;
			?>
			</td>
			<td align="center">
			<?php echo $row->ami; ?>
			</td>
			<td align="center">
			<?php echo $row->createdat; ?>
			</td>
		</tr>
		<?php
				}
		?>
		</table>
		<?php
			} else {
		?>
		Aucune partie trouv&eacute; en base de donn&eacute;e
		<?php
			}
		?>
		<hr size="1" noshade="noshade"/>
		<?php
		}
		?>


	</td>
    <td style="background-image:url(images/bkoffice_09.jpg); background-position:left; background-repeat:repeat-y;"></td>
</tr>
<tr>
	<td width="29px" height="35px" style="background-image:url(images/bkoffice_11.jpg); background-position:top right; background-repeat:no-repeat;"></td>
    <td height="35px" style="background-image:url(images/bkoffice_12.jpg); background-position:top center; background-repeat:repeat-x;"></td>
    <td width="27px" height="35px" style="background-image:url(images/bkoffice_13.jpg); background-position:top left; background-repeat:no-repeat;"></td>
</tr>
</table>
</body>
</html>