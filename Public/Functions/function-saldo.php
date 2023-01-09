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
        $nama = htmlspecialchars($data["nama"]);
        $golongan = htmlspecialchars($data["golongan"]);
        $total_dana = htmlspecialchars($data["total_dana"]);
        
        $query = "SELECT data_diri.nama AS 'nama', data_diri.golongan AS 'golongan', dana.total_dana AS 'total_dana' FROM data_diri LEFT JOIN dana ON data_diri.golongan = dana.golongan WHERE data_diri.id_user"; 

    mysqli_query($conn, $query);

        return mysqli_affected_rows($conn);
    }

    
