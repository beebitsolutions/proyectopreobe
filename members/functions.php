<?php
/*
Funciones caballerossanjuandedios.com
Burflip made-in.
Possible Errors:
Error-type:
			001:Archive cannot be opened
			002:Archive cannot be writed
*/

//Global functions

function converse($string) {
htmlentities($string,HTML_ENTITIES,'UTF-8');
}

function goSession() {
require("config.php");
session_start();
if ($_SESSION[$sesion] != $sfrase) {
echo '<a href="userarea.php">Acceso Restringido</a>'.$sfrase;
exit;
}
}

function connect() {
require("config.php");
global $conexion;
$conexion = mysql_connect($dbhost, $dbuser, $dbpass);
mysql_select_db($dbname, $conexion);
}

function disconect() {
global $conexion;
mysql_close($conexion);
}

function generatePassword($length=8, $strength=0) {
    $vowels = 'aeiou';
    $consonants = 'bcdfghjklmnpqrstvwxyz';
    if ($strength & 1) {
        $consonants .= 'BCDFGHJKLMNPQRSTVWXYZ';
    }
    if ($strength & 2) {
        $vowels .= "AEIOU";
    }
    if ($strength & 4) {
        $consonants .= '1234567890';
    }
    if ($strength & 8) {
        $consonants .= '@#$%';
    }

    $password = '';
    $alt = time() % 2;
    for ($i = 0; $i < $length; $i++) {
        if ($alt == 1) {
            $password .= $consonants[(rand() % strlen($consonants))];
            $alt = 0;
        } else {
            $password .= $vowels[(rand() % strlen($vowels))];
            $alt = 1;
        }
    }
    return $password;
}

//Funciones específicas de cada página.

//proyectopreobe.com

/* sustituye $char por $toreplacewith en $string, añade espacios y elimina posibles fallos.
Ejp: extractTheWholeNumber(" Hola/Hasta luego/Bye Bye/  ","/",",");  salida:: Hola, Hasta luego, Bye Bye
*/
function extractTheWholeNumber($string,$char,$toreplacewith) {
	$toreplacewith.=" ";
	$firststr = strtr($string,$char,$toreplacewith);
	$mediumstr = trim($firststr);
	if (substr($mediumstr,-1,1) == ","){
		$sizeof = strlen($mediumstr) - 1;
		$finalstring=substr($mediumstr,0,$sizeof);
	} else {
		$finalstring = $mediumstr;
	}
	return $finalstring;
}

function checkMeetings($mid,$mlim,$mdesc,$mpass) {
$context = "Error de sistema";
if($minv) {

} else {
$context = "No está invitado a un meeting por ahora";
}
}


//caballerossanjuandedios.com

//En el caso de que haya sexos diferenciados entre los usuarios
function echoItInSex($a,$b) {
global $usex;
if ($usex == "V") {
 echo $a; 
 } else if ($usex == "F") { 
 echo $b; 
 }
}