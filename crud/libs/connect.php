<?php
	include_once('config.php');
	include_once('pdo.php');
	$zr = new Zero(true);
	$pdo_conn = $zr->startConn(); // return $zr->conn
?>