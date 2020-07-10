<?php
   $server = "rohini.iixcp.rumahweb.com";  
   $username = "prex1283_mimin";  
   $password = "YbwzcQDQ1-Qe";  
   $database = "prex1283_sentimendb";  
   $connect = mysqli_connect($server, $username, $password) or die("Koneksi gagal");  
   mysqli_select_db($connect, $database) or die(mysqli_error($connect));    
?>