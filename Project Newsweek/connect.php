<?php 
 $dbc = mysqli_connect("localhost", "root", "", "baza_projekta") or 
 die('Error connecting to MySQL server.'.mysqli_error()); 
 mysqli_set_charset($dbc, "utf8"); 
 ?>

 