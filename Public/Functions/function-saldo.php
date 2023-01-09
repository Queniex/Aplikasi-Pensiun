<?php 
    $conn = mysqli_connect("localhost", "root", "", "aplikasi-pensiun");

    function query($query){
        global $conn;
        $result = mysqli_query($conn, $query);

        $rows = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        return $rows;
    }

    function dana($data) {
        global $conn;
        $nama = htmlspecialchars($data["data_diri.nama"]);
        $golongan = htmlspecialchars($data["data_diri.golongan"]);
        $total_dana = htmlspecialchars($data["dana.total_dana"]);
        
        $query = "SELECT data_diri.nama AS 'nama', data_diri.golongan AS 'golongan', dana.total_dana AS 'total dana' FROM data_diri LEFT JOIN dana ON data_diri.golongan = dana.golongan"; 

    mysqli_query($conn, $query);

        return mysqli_affected_rows($conn);
    }

    
