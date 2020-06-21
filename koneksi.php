<?php
   $server = "localhost";  
   $username = "root";  
   $password = "";  
   $database = "sentimendb";  
   $connect = mysqli_connect($server, $username, $password) or die("Koneksi gagal");  
   mysqli_select_db($connect, $database) or die(mysqli_error($connect));    
?>