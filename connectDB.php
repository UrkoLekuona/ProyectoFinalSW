<?php

	$local = 0;
		
		if ($local == 0){
			$folder="./fotos/";
		}
		else{
			$folder="./fotos/";
		}

	function connectDB(){
		
		if ($GLOBALS["local"] == 0){
			return mysqli_connect("localhost", "root", "admin", "quiz");
		}
		else{
			return mysqli_connect("localhost", "id2979066_root", "", "id2979066_quiz");
		}
	}
?>