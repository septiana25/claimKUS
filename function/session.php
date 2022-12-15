<?php
session_start();
if (!$_SESSION['id_user']) {
	header('location:index.php');
}
?>