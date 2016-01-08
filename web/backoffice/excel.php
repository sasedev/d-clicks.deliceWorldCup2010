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
			echo "<a href=\"index.php?op=games\" class=\"admin\">".$row->j."</a>";
		} else {
			echo $row->j;
		}
		?></td>
			<td align="left" width="50%" colspan="7"> Indique le nombre de pronostic effectués sur le site.
			</td>
		</tr>

		</table>
		<hr size="1" noshade="noshade"/>
		<form action="doexcel.php" method="post">
		<table align="center" width="100%" >
		<tr>
			<th class="a2" colspan="6" align="center">Generer un rapport excel :&nbsp;</th>
		</tr>
		<tr class="admin">
			<th align="center" class="a2">Phase : </th>
			<th align="center" class="a2"><select name="phase"><option value="1">1</option><option value="2">2</option><option value="3">3</option> </select> </th>
			<th class="a2" colspan="4"> &nbsp; </th>
		</tr>
		<tr class="admin">
			<td align="center" class="a1" colspan="2">
				Darragi :
			</td>
			<td align="center" class="a1" colspan="2">
				Gmamdia :
			</td>
			<td align="center" class="a1" colspan="2">
				Jmel :
			</td>
		</tr>
		<tr class="admin">
			<td align="center">
				Pronostic 1 :
			</td>
			<td>
				<input type="checkbox" name="q[]" value="d1"/>
			</td>
			<td align="center">
				Pronostic 1 :
			</td>
			<td>
				<input type="checkbox" name="q[]" value="g1"/>
			</td>
			<td align="center">
				Pronostic 1 :
			</td>
			<td>
				<input type="checkbox" name="q[]" value="j1"/>
			</td>
		</tr>
		<tr class="admin">
			<td align="center">
				Pronostic 2 :
			</td>
			<td>
				<input type="checkbox" name="q[]" value="d2"/>
			</td>
			<td align="center">
				Pronostic 2 :
			</td>
			<td>
				<input type="checkbox" name="q[]" value="g2"/>
			</td>
			<td align="center">
				Pronostic 2 :
			</td>
			<td>
				<input type="checkbox" name="q[]" value="j2"/>
			</td>
		</tr>
		<tr class="admin">
			<td align="center">
				Pronostic 3 :
			</td>
			<td>
				<input type="checkbox" name="q[]" value="d3"/>
			</td>
			<td align="center">
				Pronostic 3 :
			</td>
			<td>
				<input type="checkbox" name="q[]" value="g3"/>
			</td>
			<td align="center">
				Pronostic 3 :
			</td>
			<td>
				<input type="checkbox" name="q[]" value="j3"/>
			</td>
		</tr>
		<tr class="admin">
			<td align="center">
				Pronostic 4 :
			</td>
			<td>
				<input type="checkbox" name="q[]" value="d4"/>
			</td>
			<td align="center">
				Pronostic 4 :
			</td>
			<td>
				<input type="checkbox" name="q[]" value="g4"/>
			</td>
			<td align="center">
				Pronostic 4 :
			</td>
			<td>
				<input type="checkbox" name="q[]" value="j4"/>
			</td>
		</tr>
		<tr class="admin">
			<td align="center">
				Pronostic 5 :
			</td>
			<td>
				<input type="checkbox" name="q[]" value="d5"/>
			</td>
			<td align="center">
				Pronostic 5 :
			</td>
			<td>
				<input type="checkbox" name="q[]" value="g5"/>
			</td>
			<td align="center">
				Pronostic 5 :
			</td>
			<td>
				<input type="checkbox" name="q[]" value="j5"/>
			</td>
		</tr>
		<tr class="admin">
			<td align="center">
				Pronostic 6 :
			</td>
			<td>
				<input type="checkbox" name="q[]" value="d6"/>
			</td>
			<td align="center">
				Pronostic 6 :
			</td>
			<td>
				<input type="checkbox" name="q[]" value="g6"/>
			</td>
			<td align="center">
				Pronostic 6 :
			</td>
			<td>
				<input type="checkbox" name="q[]" value="j6"/>
			</td>
		</tr>
		<tr class="admin">
			<td align="center">
				Pronostic 7 :
			</td>
			<td>
				<input type="checkbox" name="q[]" value="d7"/>
			</td>
			<td align="center">
				Pronostic 7 :
			</td>
			<td>
				<input type="checkbox" name="q[]" value="g7"/>
			</td>
			<td align="center">
				Pronostic 7 :
			</td>
			<td>
				<input type="checkbox" name="q[]" value="j7"/>
			</td>
		</tr>
		<tr class="admin">
			<td align="center">
				Pronostic 8 :
			</td>
			<td>
				<input type="checkbox" name="q[]" value="d8"/>
			</td>
			<td align="center">
				Pronostic 8 :
			</td>
			<td>
				<input type="checkbox" name="q[]" value="g8"/>
			</td>
			<td align="center">
				Pronostic 8 :
			</td>
			<td>
				<input type="checkbox" name="q[]" value="j8"/>
			</td>
		</tr>
		<tr class="admin">
			<td align="center">
				Pronostic 9 :
			</td>
			<td>
				<input type="checkbox" name="q[]" value="d9"/>
			</td>
			<td align="center">
				Pronostic 9 :
			</td>
			<td>
				<input type="checkbox" name="q[]" value="g9"/>
			</td>
			<td align="center">
				Pronostic 9 :
			</td>
			<td>
				<input type="checkbox" name="q[]" value="j9"/>
			</td>
		</tr>
		<tr class="admin">
			<td align="center">
				Pronostic 10 :
			</td>
			<td>
				<input type="checkbox" name="q[]" value="d10"/>
			</td>
			<td align="center">
				Pronostic 10 :
			</td>
			<td>
				<input type="checkbox" name="q[]" value="g10"/>
			</td>
			<td align="center">
				Pronostic 10 :
			</td>
			<td>
				<input type="checkbox" name="q[]" value="j10"/>
			</td>
		</tr>
		<tr class="admin">
			<th class="a2" colspan="6">
				<input type="submit" value="Valider" />
			</th>
		</tr>
		</table>
		</form>
		<hr size="1" noshade="noshade"/>
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