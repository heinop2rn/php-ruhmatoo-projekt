<?php

	require("/home/heinparn/config.php");

	/* ALUSTAN SESSIOONI */
	session_start();
		
	/* ÜHENDUS */
	$database = "if16_heinop2rn_1";
	$mysqli = new mysqli($serverHost, $serverUsername, $serverPassword, $database);
	
	/* KLASSID */
	


?> 