<?php
$conn = mysqli_connect("localhost", "root", "", "aplikasi-pensiun");

function query($query) {
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while( $row = mysqli_fetch_assoc($result) ){
        $rows[] = $row;
    }
    return $rows;
}

function add($data) {
    global $conn;
    $nama = htmlspecialchars($data["nama"]);
    $golongan = htmlspecialchars($data["golongan"]);
    $status_berkas = htmlspecialchars($data["status_berkas"]);
    

    return mysqli_affected_rows($conn);
}

function find($keyword) {
    $query = "SELECT nama, golongan, status_berkas FROM data_diri
                WHERE
                nama LIKE '%$keyword%' OR
                golongan LIKE '%$keyword%' OR
                status_berkas LIKE '%$keyword%'";
                
    return query($query);
}

?>