<?php
	include_once('config.php');
	include_once('pdo.php');
	$zr = new Zero(true);
	$zr->host = HOST;
	$zr->user = USER;
	$zr->senhash = PASSWORD;
	$zr->db = DATABASE;
	$pdo_conn = $zr->startConn(); // return $zr->conn
?>