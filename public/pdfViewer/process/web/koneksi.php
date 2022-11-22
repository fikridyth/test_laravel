<?php
error_reporting(0);
	$Open = mysql_connect("localhost","root","gspbdki2017");
	
		if (!$Open){
		die ("Koneksi ke Engine MySQL Gagal !<br>");
		}
	$Koneksi = mysql_select_db("elibra");
		if (!$Koneksi){
		die ("Koneksi ke Database Gagal !");
		}
?>