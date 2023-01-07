<?php
    $db_host = 'localhost';
    $db_user = 'root';
    $db_pass = '';
    $db_name = 'aplikasi_pensiun';
    $conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

    if (!$conn){
        die ('Gagal terhubung dengan database MySQL : ' . mysqli_connect_error());
    }
?>