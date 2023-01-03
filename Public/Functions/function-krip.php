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

    function insert($data)
    {
        global $conn;
        //memindahkan data post kedalam variabel local
        $nomor_pensiun = htmlspecialchars($data["np"]);
        $nama = htmlspecialchars($data["nama_lengkap"]);
        $jenis_kelamin = htmlspecialchars($data["jenis_kelamin"]);
        $alamat = htmlspecialchars($data["alamat"]);
        $masa_pensiun = htmlspecialchars($data["masa_pensiun"]);
        $golongan_pensiun = htmlspecialchars($data["alamat"]);
        $alamat = htmlspecialchars($data["alamat"]);


        //upload gambar menggunakan file
        $gambar = upload();

        //jika gambar kosong maka akan mengembalikan nilai false yang artinya query takkan di jalankan
        if (!$gambar) {
            return false;
        }



        // membuat query insert untuk memasukan data dengan data variabel local
        // $query = "INSERT INTO barang VALUES ('', '$kode', '$nama', '$gambar', '$kategori', '$harga', '$tgl' )";
        // //jalankan query menggunakan mysqli_query
        // mysqli_query($conn, $query);

        return mysqli_affected_rows($conn);
    }
?>