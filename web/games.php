<?php
require_once("cnf/cfg.php");
session_start();
//print_r($_REQUEST);
$content = $_REQUEST['contenu'];
if($content == "auth") {
	$curtimestamp = mktime(date('H'), date('i'), date('s'), date('m'), date('d'), date('Y'));
	$lp3 = mktime(0, 0, 0, 7, 19, 2010);
	if($curtimestamp <= $lp3) {
		if(isset($_SESSION["delice"])) {
			$val = $_SESSION["delice"];
			$list = explode(":", $val);
			if(!is_array($list)) {
				unset($_SESSION['delice']);
				echo "c=-1";
			} else {
				if(count($list) != 6 && count($list) != 7) {
					unset($_SESSION['delice']);
					echo "c=-1";
				} else {
					$count = $list[0];
					$nom = $list[1];
					$prenom = $list[2];
					$age = $list[3];
					$tel = $list[4];
					$email = $list[5];
					$ami = $list[6];
					if($count >= 3) {
						echo "c=3";
					} else {
						echo "c=".$count;
					}
				}
			}
		} else {
			echo "c=-1";
		}
	} else {
		echo "c=4";
	}
}
if($content == "form") {
	$nom = trim($_REQUEST["nom"]);
	$prenom = trim($_REQUEST["prenom"]);
	$age = trim($_REQUEST["age"]);
	$tel = trim($_REQUEST["tel"]);
	$email = trim($_REQUEST["email"]);
	$ami = trim($_REQUEST["ami"]);
	if(strlen($nom) <= 3) {
		echo "f=2";
	} else if(strlen($prenom) <= 3) {
		echo "f=3";
	} else if($age <0 || $age > 120) {
		echo "f=4";
	} else if(strlen($tel) != 8) {
		echo "f=5";
	} else if(!preg_match("/^[2|5|9]+([0-9]*)$/", $tel)) {
		echo "f=5";
	} else if(!preg_match('`^[[:alnum:]]([-_.]?[[:alnum:]])+_?@[[:alnum:]]([-.]?[[:alnum:]])+\.[a-z]{2,6}$`',$email)) {
		echo "f=6";
	} else {
		if(!(strlen($tel) == 8 && preg_match("/^[2|5|9]+([0-9]*)$/", $ami)) ) {
			$ami = "";
		}
		$link = mysqli_connect($dbhost, $dbuser, $dbpass);
		if (!$link) {
			die('Impossible de se connecter : ' . mysqli_error());
		}

		// Rendre la base de données $dbname, la base courante
		$dbln = mysqli_select_db($link, $dbname);
		if (!$dbln) {
			die ('Impossible de sélectionner la base de donn&eacute;es : ' . mysqli_error());
		}

		$curtimestamp = mktime(date('H'), date('i'), date('s'), date('m'), date('d'), date('Y'));
		$lp1 = mktime(12, 0, 0, 6, 28, 2010);
		$lp2 = mktime(0, 0, 0, 7, 12, 2010);
		$lp3 = mktime(0, 0, 0, 7, 19, 2010);
		if($curtimestamp > $lp3) {
			$_SESSION["delice"] = "3:".$nom.":".$prenom.":".$age.":".$tel.":".$email.":".$ami;
			echo "f=1";
		} else {
			if($curtimestamp < $lp1) {
				$sql = "SELECT COUNT(id) AS w FROM players WHERE tel = '$tel' AND createdat < '2010-06-28 00:00:00'";
			} else if($curtimestamp < $lp2) {
				$sql = "SELECT COUNT(id) AS w FROM players WHERE tel = '$tel' AND createdat >= '2010-06-28 00:00:00' AND createdat < '2010-07-12 00:00:00'";
			} else {
				$sql = "SELECT COUNT(id) AS w FROM players WHERE tel = '$tel' AND createdat >= '2010-07-12 00:00:00'";
			}
			$res = mysqli_query($link, $sql) or die ("Impossible d'executer la requete 1");
			$resultat = mysqli_fetch_object($res);
			if($resultat->w >= 3) {
				$_SESSION["delice"] = "3:".$nom.":".$prenom.":".$age.":".$tel.":".$email.":".$ami;
				echo "f=1";
			} else {
				$_SESSION["delice"] = $resultat->w.":".$nom.":".$prenom.":".$age.":".$tel.":".$email.":".$ami;
				echo "f=1";
			}
		}
	}
}

if($content == "questions") {
	$joueur = $_REQUEST['joueur'];
	$lp1 = mktime(12, 0, 0, 6, 28, 2010);
	$lp2 = mktime(0, 0, 0, 7, 12, 2010);
	$lp3 = mktime(0, 0, 0, 7, 19, 2010);
	$curtimestamp = mktime(date('H'), date('i'), date('s'), date('m'), date('d'), date('Y'));
	if($curtimestamp > $lp3) {
		$v = 2;
	} else {
		if(isset($_SESSION["delice"])) {
			$val = $_SESSION["delice"];
			$list = explode(":", $val);
			if(!is_array($list)) {
				unset($_SESSION['delice']);
				$v = -1;
			} else {
				if(count($list) != 6 && count($list) != 7) {
					unset($_SESSION['delice']);
					$v = -1;
				} else {
					$count = $list[0];
					$nom = $list[1];
					$prenom = $list[2];
					$age = $list[3];
					$tel = $list[4];
					$email = $list[5];
					$ami = $list[6];
					if($count >= 3) {
						$v = 1;
					} else {
						$v = 0;
					}
				}
			}
		} else {
			$v = -1;
		}
	}
	//$v = 1;
	if($curtimestamp < $lp1) {
		$sql = "SELECT * FROM questions WHERE numetape = 1 AND vote LIKE '$joueur%'";
	} else if($curtimestamp < $lp2) {
		$sql = "SELECT * FROM questions WHERE numetape = 2 AND vote LIKE '$joueur%'";
	} else {
		$sql = "SELECT * FROM questions WHERE numetape = 3 AND vote LIKE '$joueur%'";
	}
	$link = mysqli_connect($dbhost, $dbuser, $dbpass);
	if (!$link) {
		die('Impossible de se connecter : ' . mysqli_error());
	}

	// Rendre la base de données $dbname, la base courante
	$dbln = mysqli_select_db($link, $dbname);
	if (!$dbln) {
		die ('Impossible de sélectionner la base de donn&eacute;es : ' . mysqli_error());
	}
	$res = mysqli_query($link, $sql) or die ("Impossible d'executer la requete 2 ".$sql." ".mysqli_error());
	$nbrq = mysqli_num_rows($res);
	//$nbrq = 4;
	$r = "v=".$v."&n=".$nbrq;
	if($nbrq != 0) {
		$i = 0;
		while ($row = mysqli_fetch_object($res)) {
			$i++;
			$r .= "&q".$i."=".$row->vote;
		}
	}
	echo $r;
}

if($content == "answers") {
	if(isset($_SESSION["delice"])) {
		$val = $_SESSION["delice"];
		$list = explode(":", $val);
		if(!is_array($list)) {
			unset($_SESSION['delice']);
			echo "c=-1";
		} else {
			if(count($list) != 6 && count($list) != 7) {
				unset($_SESSION['delice']);
				echo "c=-1";
			} else {
				$count = $list[0];
				$nom = $list[1];
				$prenom = $list[2];
				$age = $list[3];
				$tel = $list[4];
				$email = $list[5];
				$ami = $list[6];
				if($count >= 3) {
					echo "c=4";
				} else {
					$joueur = $_REQUEST['joueur'];
					$q = $_REQUEST['q'];
					$link = mysqli_connect($dbhost, $dbuser, $dbpass);
					if (!$link) {
						die('Impossible de se connecter : ' . mysqli_error());
					}

					// Rendre la base de données $dbname, la base courante
					$dbln = mysqli_select_db($link, $dbname);
					if (!$dbln) {
						die ('Impossible de sélectionner la base de donn&eacute;es : ' . mysqli_error());
					}

					$lp1 = mktime(12, 0, 0, 6, 28, 2010);
					$lp2 = mktime(0, 0, 0, 7, 12, 2010);
					$lp3 = mktime(0, 0, 0, 7, 19, 2010);
					$curtimestamp = mktime(date('H'), date('i'), date('s'), date('m'), date('d'), date('Y'));
					if($curtimestamp < $lp1) {
						$sql = "SELECT COUNT(id) AS w FROM players WHERE tel = '$tel' AND createdat < '2010-06-28 00:00:00'";
					} else if($curtimestamp < $lp2) {
						$sql = "SELECT COUNT(id) AS w FROM players WHERE tel = '$tel' AND createdat >= '2010-06-28 00:00:00' AND createdat < '2010-07-12 00:00:00'";
					} else {
						$sql = "SELECT COUNT(id) AS w FROM players WHERE tel = '$tel' AND createdat >= '2010-07-12 00:00:00'";
					}

					//$query = "SELECT COUNT(id) AS w FROM players WHERE tel = '$tel'";
					$res = mysqli_query($link, $sql) or die ("Impossible d'executer la requete 1");
					$resultat = mysqli_fetch_object($res);
					if($resultat->w >= 3) {
						unset($_SESSION['delice']);
						echo "c=0&session=err4";
					} else {
						$q = $joueur.$q;
						$sql = "INSERT INTO players (nom, prenom, age, tel, email, ami, vote, createdat) VALUES ('$nom', '$prenom', '$age', '$tel', '$email', '$ami', '$q', NOW())";
						$res = mysqli_query($link, $sql) or die ("Impossible d'executer la requete 2");
						$cnt = $resultat->w + 1;
						$_SESSION["delice"] = $cnt.":".$nom.":".$prenom.":".$age.":".$tel.":".$email.":".$ami;
						if($cnt >=3) {
							echo "c=3";
						} else if($cnt ==2) {
							echo "c=2";
						} else if($cnt ==1) {
							echo "c=1";
						}
						if(preg_match("/^[2|5|9]+([0-9]*)$/", $ami)) {
							@fopen("http://196.203.44.42/L2TJeuDelice/url.aspx?type=parrainage&to=$ami&from=$tel", "r");
						}
					}
				}
			}
		}
	} else {
		echo "c=-1";
	}
}


?>