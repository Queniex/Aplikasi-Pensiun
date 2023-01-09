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

    function update($data)
    {
        global $conn;

        //memindahkan data post kedalam variabel local
        $np = $data["np"];
        $nama = htmlspecialchars($data["nama_lengkap"]);
        $jenis_kelamin = ($data["jenis_kelamin"]);
        $alamat = htmlspecialchars($data["alamat"]);
        $masa_pensiun = htmlspecialchars($data["masa_pensiun"]);
        $golongan = htmlspecialchars($data["golongan_pensiun"]);

        // membuat query insert untuk memasukan data dengan data variabel local
        $query = "UPDATE data_diri SET 
                    nama = '$nama',
                    jenis_kelamin = '$jenis_kelamin',
                    alamat = '$alamat',
                    usia_pensiun = '$masa_pensiun',
                    golongan = '$golongan'
                    WHERE np = '$np'";

        //jalankan query menggunakan mysqli_query
        mysqli_query($conn, $query);

        return mysqli_affected_rows($conn);
    }

    function delete($id)
    {
        global $conn;

        $query = "DELETE FROM data_diri WHERE np = '$id'";
        mysqli_query($conn, $query);
        return mysqli_affected_rows($conn);
    }

    function search($keyword)
    {
        $query = "SELECT * FROM data_diri WHERE status_berkas = 'approve' AND nama LIKE '%$keyword%' OR np LIKE '%$keyword%'  ";
        return query($query);
    }
?>