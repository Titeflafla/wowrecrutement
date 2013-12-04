<?php

//------------------------------------------------------------------------------//
//  Nuked-KlaN - PHP Portal							//
//  http://www.nuked-klan.org							//
//------------------------------------------------------------------------------//
//  This program is free software. you can redistribute it and/or modify	//
//  it under the terms of the GNU General Public License as published by	//
//  the Free Software Foundation; either version 2 of the License.        	//
//------------------------------------------------------------------------------//

define("INDEX_CHECK", 1);

if (is_file('globals.php')) include ("globals.php");
else die('<br /><br /><div style=\"text-align: center;\"><b>install.php must be near globals.php</b></div>');
if (is_file('conf.inc.php')) include ("conf.inc.php");
else die('<br /><br /><div style=\"text-align: center;\"><b>install.php must be near conf.inc.php</b></div>');
if (is_file('nuked.php')) include('nuked.php');
else die('<br /><br /><div style=\"text-align: center;\"><b>install.php must be near nuked.php</b></div>');

function top() {
	global $nuked;

	echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
    	<html xmlns="http://www.w3.org/1999/xhtml">
        <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>' . $nuked['name'] . ' - Installation</title>
        <link rel="stylesheet" href="modules/Admin/css/reset.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="modules/Admin/css/style.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="modules/Admin/css/invalid.css" type="text/css" media="screen" />
        <style type="text/css">
        .css3button {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #050505;
	padding: 5px 20px;
	background: -moz-linear-gradient(top,#ffffff 0%,#c7d95f 50%,#add136 50%,#6d8000);
	background: -webkit-gradient(linear, left top, left bottom,from(#ffffff),color-stop(0.50, #c7d95f),color-stop(0.50, #add136),to(#6d8000));
	border-radius: 12px;
	-moz-border-radius: 12px;
	-webkit-border-radius: 12px;
	border: 1px solid #6d8000;
	-moz-box-shadow:0px 1px 3px rgba(000,000,000,0.5),inset 0px 0px 2px rgba(255,255,255,1);
	-webkit-box-shadow:0px 1px 3px rgba(000,000,000,0.5),inset 0px 0px 2px rgba(255,255,255,1);
	text-shadow:0px -1px 0px rgba(000,000,000,0.2),0px 1px 0px rgba(255,255,255,0.4);
	}
	</style>';
}

function index() {

	global $nuked;

	top();

        echo '<body id="login">
        <div id="login-wrapper" class="png_bg">
        <div id="login-top">
        <h1>' . $nuked['name'] . ' - Installation</h1>
        <img id="logo" src="modules/Admin/images/logo.png" alt="NK Logo" />
        </div>';
	//Correction par Sekuline
	$version = $nuked['version'];
	$last = $version[0] . '.' . $version[2] . '.' . $version[4];

    	if ($last == '1.7.9') {

		echo '<div class="content-box" style="width:700px!important;margin:auto;">',"\n" //<!-- Start Content Box -->
        	. '<div class="content-box-header"><h3>Installation Module Wow Recrutement V2</h3></div>',"\n"
        	. '<div class="tab-content" id="tab2"><table style="margin:auto;width:80%;color:black;" cellspacing="0" cellpadding="0" border="0">';

		//Vérification si INSTALLATION ou REINSTALLATION du module afin de ne pas dupliquer le liens dans l'admin
		$test = mysql_query("SELECT id FROM " . $nuked['prefix'] . "_modules WHERE nom='wow_recrutement'");
		$req = mysql_num_rows($test);
		if($req == 1) echo '<tr><td style="text-align:center;"><span style="color:red; font-weight:bold;">Attention L\'installation remettra la configuration par défault du module.</span></td></tr>';

		echo '<tr>
		<td><img src="modules/Wow_recrutement/img/m_r.png" alt="" style="float:left;padding-right:10px;" />
		Vous allez installer le module <strong>Wow Recrutement V2</strong> <br /><br />
		Créé par <a href="http://www.titeflafla.net" target="_blank">Kipcool</a> Pour <a href="http://www.nuked-klan.eu" target="_blank">Nuked-Klan</a><br /><br />
		</td>
		</tr>
		<tr>
		<td style="text-align:center;">
		<input type="button" name="yes" onclick="document.location.href=\'install.php?op=update\';" value="Installer" class="css3button"/>&nbsp;&nbsp;
		<input type="button" name="No" onclick="document.location.href=\'install.php?op=nan\';" value="Ne pas installer" class="css3button"/>
		</td>
		</tr>
		</table>
		</div></div>
		</div>
        	</body>
    		</html>';
	}
	else echo 'Bad version, Only for NK 1.7.9';
}

function update() {

	global $nuked;

	//Efface les tables si déjà existantes
	$req = mysql_query("DROP TABLE IF EXISTS ". $nuked['prefix'] ."_Wow_recrutement");
	$req = mysql_query("DELETE FROM ". $nuked['prefix'] ."_block WHERE module = 'Wow_recrutement'");
	$req = mysql_query("DELETE FROM ". $nuked['prefix'] ."_modules WHERE nom = 'Wow_recrutement'");

	$sql = "CREATE TABLE IF NOT EXISTS `".$nuked['prefix']."_Wow_recrutement` (
  	`classes` varchar(50) NOT NULL,
  	`statut` varchar(20) NOT NULL,
  	`role` mediumtext NOT NULL,
  	`color` varchar(7) NOT NULL,
  	KEY `statut` (`statut`)
  	) ENGINE=MyISAM DEFAULT CHARSET=latin1;";
	$req = mysql_query($sql);

	$sql_insert = mysql_query("INSERT INTO `".$nuked['prefix']."_Wow_recrutement` (`classes`, `statut`, `role`, `color`) VALUES
	('_SHAMAN', 'on', '1|1|1', '1353DE'),
	('_ROGUE', 'on', '1|1|1', 'DEF569'),
	('_PRIEST', 'on', '1|1|1', 'FFFFFF'),
	('_PALADIN', 'on', '1|1|1', 'F58CBA'),
	('_DK', 'on', '1|1|1', 'A91F3B'),
	('_MAGE', 'on', '1|1|1', '69CCD1'),
	('_HUNT', 'on', '1|1|1', 'ABD464'),
	('_DRUID', 'on', '1|1|1', 'E38512'),
	('_WARLOCK', 'on', '1|1|1', '764B80'),
	('_WARRIOR', 'on', '1|1|1', '804000'),
	('_PANDAREN', 'on', '1|1|1', '008467');");

	$sql = mysql_query("INSERT INTO ". $nuked['prefix'] ."_block (`bid`, `active`, `position`, `module`, `titre`, `content`, `type`, `nivo`, `page`) VALUES ('', '1', '0', 'Wow_recrutement', 'Recrutement', '', 'module', '0', 'Tous');");
	$sql = mysql_query("INSERT INTO ". $nuked['prefix'] ."_modules (`id`, `nom`, `niveau`, `admin`) VALUES ('', 'Wow_recrutement', '0', '9');");

        top();
        echo '<div class="tab-content" id="tab2" style="width:700px!important;margin:auto;">'
        . "<br /><br /><div class=\"notification success png_bg\"><div>Le module Wow Recrutement V2 a été installé correctement.<br />Redirection en cours vers l'administration ...</div></div>";

	//Supression automatique du fichier install.php
	if(@!unlink("install.php")) echo "<br /><br /><div class=\"notification error png_bg\"><div>Penser à supprimer le fichier install.php de votre FTP .</div></div>";

        echo '</div></body></html>';
	redirect("index.php?file=Admin", 2);
}

function nan() {

	top();
        echo '<div class="tab-content" id="tab2" style="width:700px!important;margin:auto;">'
	. "<br /><br /><div class=\"notification error png_bg\"><div>Installation annulé .</div></div>";

	if(@!unlink("install.php")) echo "<br /><br /><div class=\"notification error png_bg\"><div>Penser à supprimer le fichier install.php de votre FTP .</div></div>";

        echo '</div></body></html>';

    	redirect("index.php", 2);
}

switch($_GET['op']) {
	case"index":
	index();
	break;

	case"update":
	update();
	break;

	case"nan":
	nan();
	break;

	default:
	index();
	break;
}

?>