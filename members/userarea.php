<?php
require_once("functions.php");
require_once("config.php");
connect();
session_start();
if ($_GET["logout"] == 1) {
session_unset();
session_destroy();
$mensajelogout = "Usuario logeado con &eacute;xito";
}
if ($_SESSION[$sesion] == $sfrase) {
echo "<script>document.location.href('members/userpanel.php');</script>";
exit;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Preobe Members' Zone</title>
<link rel="stylesheet" href="userarea.css" />
</head>
<body>
<center>
<div class="container">
<h1>Panel de Usuarios</h1>
<?php
if($_GET['p'] == 1) {
$usertypes[1] = "Miembro";
$usertypes[2] = "Coordinador";
$usertypes[3] = "Webmaster";
$username = $_POST['user'];
$userpass = $_POST['pass'];
$result = mysql_query('SELECT upass,tuser FROM usuarios WHERE uname="'.$username.'" LIMIT 1',$conexion);
while ($row = mysql_fetch_array($result)) {
if ($row["upass"] == $userpass) {
echo "Miembro ".$username." conectado. Acceso de tipo: ".$usertypes[$row["tuser"]]."<br /><br /><a href='userpanel.php' title='Continuar'>Continuar</a>";
$_SESSION[$sesion] = $sfrase;
$_SESSION["name"] = $username;
$_SESSION["privs"] = $row["tuser"];
} else {
echo "Usuario o contrase&ntilde;a no v&aacute;lidos.";
}
}
}
if (!isset($_GET['p'])) {
?>
Zona privada de los miembros del proyecto preobe. En él se ver&aacute;n datos relevantes de los usuarios y del proyecto.<br/> Es necesario un usuario y una clave de seguridad.
<?php if (isset($mensajelogout)) {
echo "<br /><br /><h3>".$mensajelogout."</h3>";
} else {
echo "<br/><br/>";
}
?>
<br/>
<center>
<div class="minibox">
<form action="userarea.php?p=1" method="post" enctype="application/x-www-form-urlencoded" class="formulario">
Usuario: <input type="text" name="user" style="margin-left:22px;" /> <br />
Contraseña: <input type="password" name="pass" /><br /><br /><br />
<input type="submit" value="Entrar" />
</form>
</div>
</center>
<?php 
}
?>
</div>
</center>
</body>
</html>
<?php disconect(); ?>