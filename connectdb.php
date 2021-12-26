<?php

	$server =	"localhost";
	$user =	"root";
	$pass =	"";
	$dbase ="nomanom_master";

	$conn = new mysqli($server, $user, $pass, $dbase);
    mysqli_set_charset($conn,"utf8");
?>
