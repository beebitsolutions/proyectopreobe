<?php
require_once("functions.php");
connect();
goSession();
$result = mysql_query('SELECT uid,upass,tuser,fname,edad,mail,tlf,pweb FROM usuarios WHERE uname="'.$_SESSION["name"].'" LIMIT 1', $conexion);
while ($row = mysql_fetch_array($result)) {
$thefuckingmail = $row["mail"];
$user = $_SESSION["name"];
$uid = $row["uid"];
$upass = $row["upass"];
$tuser = $row["tuser"];
$uname = $row["fname"];
$uedad = $row["edad"];
$umail = $row["mail"];
$utlf = $row["tlf"];
$upweb = $row["pweb"];
}
$result = mysql_query('SELECT mid,mact,mtitle,mloc,mdate,time,mdphp,mdesc,mmanag FROM meetings WHERE lastm="1" LIMIT 30', $conexion);
while ($row = mysql_fetch_array($result)) {
if (!$row["mid"]) {
$mid = 0;
} else {
$mactive = $row["mact"];
if($mactive) {
$mid = $row["mid"];
$mtitle = $row["mtitle"];
$mloc = $row["mloc"];
$mdate = $row["mdate"];
$mtime = $row["time"];
$mdphp = $row["mdphp"];
$mdesc = $row["mdesc"];
$mmanag = $row["mmanag"];
}
}
}
$usertypes[1] = "Miembro";
$usertypes[2] = "Coordinador";
$usertypes[3] = "Webmaster";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Panel de Usuario</title>
<link rel="stylesheet" href="userarea.css" />
<!--
<script language="javascript">
var var1 = '<br /><br /><div style="border-color:#CCCCCC; border-style:solid; border-width:1px; padding:15px; background-color:#EAEDEE;"><span style="float:right;"><a href="#" onclick="document.getElementById(\'fotoedit\').innerHTML=\'\'"><img src="images/closeicon.png" alt="Cerrar" style="border:none;" /></a></span><form action="userpanel.php?p=2" method="post" enctype="multipart/form-data"><b>Cambiar Foto de Usuario</b><br /><br /><span id="progress"></span><br /><br />Suba un archivo al servidor. La imagen que quiera que se vea como su foto no puede exceder las dimensiones de 90x90 p&iacute;xeles y pasar del tamaño de 15kb. En el caso de que la foto sea demasiado grande el servidor intentar&aacute; reducirla, pero quiz&aacute; no se suba correctamente al mismo.<br /><br />Usar Imagen predeterminada: <input type="checkbox" name="predeterminada" /><br /><br />Archivo a subir: <input type="file" name="archivo" /><br /><br /><input type="submit" onclick="document.getElementById(\'progress\').innerHTML=\'<img src=\\\'images/progress.gif\\\' />Cargando...<br /><br />\'" value="Cambiar Foto" /></form></div>';
</script>
<link rel="stylesheet" href="docs/style.css" type="text/css">
</script>
-->
		<script type="text/javascript" src="scripts/wysiwyg.js"></script>
		<script type="text/javascript" src="scripts/wysiwyg-settings.js"></script>
		<script type="text/javascript">
		<?php if($_GET["p"] == 3) { ?>
			WYSIWYG.attach('mensajiviri',small);
		<?php } ?>
</script>
</head>
<body>
<center>
<div class="container2">
<h1>Panel Personal</h1>
<div class="sidebar">
<h3>Menú</h3>
<hr color="#999999" />
<ul>
<li><a href="userpanel.php">Cuenta de Usuario</a></li>
<li><a href="userpanel.php?p=2">Ver Otros Usuarios</a></li>
<li><a href="userpanel.php?p=9">Encontrar un Usuario</a></li>
<li><a href="userarea.php?logout=1">Desconexi&oacute;n</a></li>
<?php if ($_SESSION["privs"] >= 2) {
echo '<li><a href="https://webmail.1and1.es/" title="WebMail">WebMail</a></li><li><a href="userpanel.php?p=10">Editar y Crear Usuarios</a></li></ul>';
} else {
echo "</ul>";
}
?></div>
<div class="box">
<?php if(!isset($_GET["p"])) { ?>
<h2>Perfil</h2><hr color="#999999" />
<div class="contenido" style="margin-bottom:30px;">
<img src="images/userimg.png" alt="User Logo" style="float:left;" />
<h3><?php echo $uname; ?></h3>
<br /><br />Nombre de usuario: <span id="datos"><?php echo $user ?></span><br />
Edad: <span id="datos"><?php echo $uedad; ?></span><br />
Privilegios de Usuario actuales: <span id="datos"><?php echo $usertypes[$tuser]; ?></span><br />
Teléfonos: <span id="datos"><?php echo extractTheWholeNumber($utlf,"/",","); ?></span><br />
Correo El&eacute;ctronico: <span id="datos"><?php echo $umail; ?></span><br />
P&aacute;gina Web: <span id="datos"><?php echo $upweb; ?></span><br />
<br /><br /><h3>Meetings Activos</h3>
<br />
<?php if (!$mid) { ?>
<span id="datos">El último meeting no está activo actualmente</span>
<br /><br /><h3>Meetings Activos</h3>
<br />
<?php } else { ?>
<span style="font-size:14px; font-weight:bold; color:#999999;">Último Meeting: <a href="meetings.php?p=<?php $mid ?>" title="Enlace al meeting"><?php echo $mtitle; ?></a></span><br /><br />
Localizaci&oacute;n: <span id="datos"><?php echo $mloc; ?></span><br />
Fecha de encuentro: <span id="datos"><?php echo $mdate; ?></span><br />
Hora: <span id="datos"><?php echo $mtime; ?></span><br />
Coordinador/a del evento: <span id="datos"><?php echo $mmanag; ?></span><br /><br />
<span id="datos">Otros Meetings Activos</span>
<br /><br />
<?php 
}
$result = mysql_query('SELECT mid,mact,mtitle,mdate,time FROM meetings WHERE mact="1" LIMIT 30', $conexion);
while ($row = mysql_fetch_array($result)) {
if ($mid != $row["mid"] && $row["mid"]) {
echo "Nombre: <a href='meetings.php?p=".$row["mid"]."' title='Enlace al meeting'>".$row["mtitle"]."</a>. Fecha del encuentro: ".$row["mdate"]." a las ".$row["time"].". <br />";
$others = 1;
}
}
if(!$others) {
echo "No hay m&aacute;s meetings";
}
?>
</div>
<h2>Datos de la Cuenta de Usuario</h2><hr color="#999999" />
<div class="contenido">
<form action="userpanel.php?p=1" method="post" enctype="application/x-www-form-urlencoded">
<input type="submit" value="Actualizar" style="margin-top:250px; float:left;" />
<center>
<div style="float:left;">
Edad: <br /><input type="text" name="age" value="<?php echo $uedad; ?>" /><br /><br />
Contraseña: <br /><div style="width:170px;"><input id="the" onclick="document.getElementById('the').type='text';" type="password" name="pass" value="<?php echo $upass; ?>" /> 
<a href="#" onclick="document.getElementById('the').type='text';">Mostrar</a> <a href="#" onclick="document.getElementById('the').type='password';">Ocultar</a></div><br />
Correo El&eacute;ctronico: <br /><input type="text" name="mail" value="<?php echo $umail; ?>" /><br /><br />
P&aacute;gina Web: <br /><input type="text" name="paginaweb" value="<?php echo $upweb; ?>" /><br />
</div><div style="border:1px; border-color:#CCCCCC; background:#F3F3F3; width:180px; padding:5px; float:left;"><center>Teléfonos: <br /><input type="text" maxlength="39" readonly="readonly" id="eltlf" name="telef" value="<?php echo $utlf; ?>" /><br /><br />Escribe un teléfono a añadir:<br /><div style="width:170px;"><input type="text" id="tlf2" style="margin-right:10px;"s/><a href="#" onclick="xad=document.getElementById('tlf2').value; if(!(xad == '' || xad == ' ')){ document.getElementById('eltlf').value+=xad + '/';} document.getElementById('tlf2').value='';" >Añadir</a> <a href="#" onclick="document.getElementById('eltlf').value='';">Borrar Tel&eacute;fonos</a></div></center></div>
</center>
</form>
</div>
<?php
} else if ($_GET["p"] == 1) {
$pass = htmlspecialchars($_POST["pass"]);
$utlf = $_POST["telef"];
$lenght = strlen($utlf);
if ($lenght > 249) {
$utlf = substr($utlf,0,230);
}
$mail = $_POST["mail"];
$pageweb = $_POST["paginaweb"];
$uage = $_POST["age"];
$result = mysql_query('UPDATE usuarios SET upass = "'.$pass.'", tlf = "'.$utlf.'", mail = "'.$mail.'", pweb = "'.$pageweb.'", edad = "'.$uage.'" WHERE uname="'.$_SESSION["name"].'" LIMIT 1', $conexion);
?>
<h2>Datos de la Cuenta de Usuario</h2><hr color="#999999" />
<div class="contenido">
Datos de usuario actualizados correctamente. <a href="userpanel.php" title="Datos de la Cuenta de Usuario">Volver</a>
</div>
<?php
} else if ($_GET["p"] == 2) {
?>
<h2>Usuarios Registrados</h2><hr color="#999999" />
<div class="contenido">
<?php
$result = mysql_query("SELECT fname FROM usuarios", $conexion);
$cantidad = mysql_num_rows($result);
$userxpage = 25;
$numpages = ceil($cantidad / $userxpage);
if (!isset($_GET["page"])) {
$_GET["page"] = 1;
}
$current = ($_GET["page"] - 1) * $userxpage;
$result = mysql_query("SELECT fname,uname FROM usuarios LIMIT ".$current.",".$userxpage,$conexion);
  while ($row = mysql_fetch_array($result)) {
	echo '<img src="images/uicon.png" /><a href="userpanel.php?p=3&u='.$row["uname"].'">'.$row["fname"].'</a><br />';
}
echo "<br />";
if ($_GET["page"] > 1) {
$topage = $_GET["page"] - 1;
echo '<a href="userpanel.php?p=2&page='.$topage.'">&lt;&lt;Anterior</a> ';
}
for ($i = 1;$i <= $numpages;$i ++) {
echo ' <a href="userpanel.php?p=2&page='.$i.'">'.$i.'</a>';
}
if ($_GET["page"] < $numpages) {
$topage = $_GET["page"] + 1;
echo ' <a href="userpanel.php?p=2&page='.$topage.'">Siguiente&gt;&gt;</a> ';
}
echo "</div>";
} else if($_GET["p"] == 3) {
$result = mysql_query('SELECT uname,fname,edad,tuser,mail,pweb,tlf FROM usuarios WHERE uname="'.$_GET["u"].'" LIMIT 1',$conexion);
while($row = mysql_fetch_assoc($result)) {
$user = $_GET["u"];
$tuser = $row["tuser"];
$uname = $row["fname"];
$uedad = $row["edad"];
$umail = $row["mail"];
$upweb = $row["pweb"];
$utlf = $row["tlf"];
//$months = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
}
?>
<h2><? echo $uname ?></h2><hr color="#999999" />
<div class="contenido">
<img src="images/userimg.jpg" /><br /><br />
Nombre de usuario: <?php echo $user; ?><br />
Es un <span id="datos"><? echo $usertypes[$tuser]; ?></span><br />
Edad: <?php echo $uedad; ?>.<br />
Puedes contactar con &eacute;l/ella en <?php 
echo "el ".$utlf.". Tambi&eacute;n puedes mandarle un mensaje a"; ?> su correo electr&oacute;nico: <?php echo '<a href="mailto:'.$umail.'" title="Mandar un email">'.$umail.'</a>'; ?>. <br /><br /> <h3>Mandarle un E-mail</h3> <hr color="#999999"/><br  /><b>Aviso: quiz&aacute; el servidor de correo del destinatario tome este e-mail como spam.</b><br /><br /><form action="userpanel.php?p=mailto" method="post" enctype="application/x-www-form-urlencoded">T&iacute;tulo del mensaje: <input type="text" name="title" /><br /><br />Su email: <input type="text" name="frommail" value="<?php echo $thefuckingmail; ?>" /><br /><br />Mensaje: <br /><br /><textarea id="mensajiviri" name="mensaje" cols="30" rows="4"></textarea><br /><br /><input type="hidden" name="tomail" value="<? echo $umail; ?>" /><input type="hidden" name="touser" value="<? echo $user; ?>" /><input type="hidden" name="username" value="<? echo $uname; ?>" /><input type="submit" value="Enviar correo a <? echo $uname; ?>" /></form>
</div>
<?php 
} else if ($_GET["p"] == "mailto") {
$titulo = $_POST["title"];
$frommail = $_POST["frommail"];
$tomail = $_POST["tomail"];
$mensaje = "Mensaje enviado desde la web del proyecto Preobe. Redactado por el usuario ".$_SESSION["name"].".\n\n---------------------------------------------------------------------------\n\n".$_POST["mensaje"]."\n\n---------------------------------------------------------------------------\n\n Si este mensaje contiene algún término ofensivo o de mal gusto por favor avísenos en http://proyectopreobe.com/";
$touser = $_POST["touser"];
$userrealname = $_POST["username"];
mail($tomail, $titulo, $mensaje, "FROM:".$frommail); 
?>
<div class="contenido">
<h2>Mail Service</h2><hr color="#999999" />
Mensaje enviado a <? echo $userrealname; ?> con &eacute;xito. <a href="userpanel.php?u=<? echo $touser; ?>&amp;p=8">Volver</a>
</div>
<?php 
} else if ($_GET["p"] == "admin" && $_SESSION["privs"] >= 2) {
?>
<h2>Men&uacute; de Administraci&oacute;n</h2><hr color="#999999" />
<div class="contenido">
<center>
<h3>Editar perfil de usuario</h3><hr style="width:250px; margin-bottom:40px;" /></center>
<form action="userpanel.php?p=4" method="post" enctype="multipart/form-data">
Introduce el nombre de usuario que el miembro utiliza en la web para ver su p&aacute;gina personal y poder editarla:<br /><br /><center><div style="width:360px; border-color:#CCCCCC; border-style:solid; border-width:1px; padding:15px; background-color:#EAEDEE;"><span style="margin-right:20px;">Nombre de Usuario:</span><input type="text" name="username" /></div></center>
<br /><br /><input type="submit" value="Editar usuario" />
</form>
<br />
</div>
<?php
} else if($_GET["p"] == 4) {
if($_SESSION["privs"] >= 2) {
$result = mysql_query('SELECT uid,uname,fname,edad,tuser,mail,pweb,tlf FROM usuarios WHERE uname="'.$_GET["u"].'" LIMIT 1',$conexion);
while($row = mysql_fetch_assoc($result)) {
$user = $_GET["u"];
$uid = $row["uid"];
$tuser = $row["tuser"];
$uname = $row["fname"];
$uedad = $row["edad"];
$umail = $row["mail"];
$upweb = $row["pweb"];
$utlf = $row["tlf"];
//$months = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
}
?>
<form action="userpanel.php?p=5" method="post" enctype="application/x-www-form-urlencoded">
<h2><input type="text" name="fname" width="40" value="<? echo $uname ?>" /></h2><hr color="#999999" />
<div class="contenido">
<img src="images/userimg.jpg" /><br /><br />
Nombre de usuario: <input type="text" name="uname" value="<?php echo $user; ?>" /><br />
Id de usuario: <input type="text" name="uid" value="<?php echo $uid; ?>" /><br />
Es un <SELECT NAME="tuser">
<OPTION <?php if ($tuser == 1) {?> selected="selected" <?php } ?> value="1">Miembro</OPTION>
<OPTION <?php if ($tuser == 2) {?> selected="selected" <?php } ?>value="2">Coordinador</OPTION>
<OPTION <?php if ($tuser == 3) {?> selected="selected" <?php } ?>value="3">Webmaster</OPTION>
</SELECT>
<br />
Edad: <input type="text" name="uedad" value="<?php echo $uedad; ?>" /><br />
Puedes contactar con &eacute;l/ella en <?php 
echo "el ".$utlf.". Tambi&eacute;n puedes mandarle un mensaje a"; ?> su correo electr&oacute;nico: <?php echo '<a href="mailto:'.$umail.'" title="Mandar un email">'.$umail.'</a>'; ?>. <br /><br /> <h3>Mandarle un E-mail</h3> <hr color="#999999"/><br  /><b>Aviso: quiz&aacute; el servidor de correo del destinatario tome este e-mail como spam.</b><br /><br /><form action="userpanel.php?p=mailto" method="post" enctype="application/x-www-form-urlencoded">T&iacute;tulo del mensaje: <input type="text" name="title" /><br /><br />Su email: <input type="text" name="frommail" value="<?php echo $thefuckingmail; ?>" /><br /><br />Mensaje: <br /><br /><textarea id="mensajiviri" name="mensaje" cols="30" rows="4"></textarea><br /><br /><input type="hidden" name="tomail" value="<? echo $umail; ?>" /><input type="hidden" name="touser" value="<? echo $user; ?>" /><input type="hidden" name="username" value="<? echo $uname; ?>" /><input type="submit" value="Enviar correo a <? echo $uname; ?>" /></form>
</div>
</form>
<?php
} else if($_GET["p"] == 5) {
$result = mysql_query("UPDATE `usuarios` SET `edad`='16', WHERE `uid`=1 LIMIT 1 ;
",$conexion);
?>
<?php } else {
?>
<h2>Fallo de Autenticaci&oacute;n</h2><hr color="#999999" />
<div class="contenido">
No tiene los suficientes privilegios como para ver esta p&aacute;gina.
</div>
<?php
}
}
?>
</div>
</center>
</body>
</html>
<?php disconect(); ?>