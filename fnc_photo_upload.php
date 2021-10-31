<?php
/* 	$database = "if21_siim_kr";
	require_once('fnc_general.php'); */
	
	function save_image($image, $file_type, $target){
		$notice = null;
		if($file_type == "jpg"){
			if(imagejpeg($image, $target, 90))
				$notice = 'Vähendatud pilid salvestamine õnnestus';
		}else{
			$notice = 'Ups error :(!';
		}
		if($file_type == "png"){
			if(imagepng($image, $target, 6))
				$notice = 'Vähendatud pilid salvestamine õnnestus';
		}else{
			$notice = 'Ups error :(!';
		}
		if($file_type == "gif"){
			if(imagegif($image, $target))
				$notice = 'Vähendatud pilid salvestamine õnnestus';
		}else{
			$notice = 'Ups error :(!';
		}
		return $notice;
	}