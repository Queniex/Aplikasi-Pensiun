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
    $nip = htmlspecialchars($data["nip"]);
    $tempat_lahir = htmlspecialchars($data["tempat_lahir"]);
    $tanggal_lahir = date('Y-m-d', strtotime($data["tanggal_lahir"]));
    $agama = htmlspecialchars($data["agama"]);
    $jenis_kelamin = htmlspecialchars($data["jenis_kelamin"]);
    $alamat = htmlspecialchars($data["alamat"]);
    $no_telp = htmlspecialchars($data["no_telp"]);
    $email = htmlspecialchars($data["email"]);
    $status_keluarga = htmlspecialchars($data["status_keluarga"]);
    $instansi = htmlspecialchars($data["instansi"]);
    $tgl_pegawai = date('Y-m-d', strtotime($data["tgl_pegawai"]));
    $golongan = htmlspecialchars($data["golongan"]);
    $jabatan = htmlspecialchars($data["jabatan"]);
    $usia_pensiun = htmlspecialchars($data["usia_pensiun"]);
    $iuran_perbulan = htmlspecialchars($data["iuran_perbulan"]);
    $status_berkas = "Checked";
    
    $query = "INSERT INTO data_diri
                VALUES
               ('', '$nama', '$nip', '$tempat_lahir', '$tanggal_lahir', '$agama', '$jenis_kelamin', '$alamat', '$no_telp', '$email', '$status_keluarga', '$instansi', '$tgl_pegawai', '$golongan', '$jabatan', '$usia_pensiun', '$iuran_perbulan', '$status_berkas')"; 
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function add2($data) {
    global $conn;

    // upload file
    $skpl = upload("skpl");
    $skcp = upload("skcp");
    $skcltn = upload("skcltn");
    $skpi = upload("skpi");
    if( !$skpl && !$skcp && !$skcltn && !$skpi ) {
        return false;
    }

    $query = "INSERT INTO pelampiran_file 
                VALUES
               ('4', '$skpl', '$skcp', '$skcltn', '$skpi')"; 
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function upload($a) {

    $fileName = $_FILES[$a]['name'];
    $fileSize = $_FILES[$a]['size'];
    $error = $_FILES[$a]['error'];
    $tmpName = $_FILES[$a]['tmp_name'];

    // check if there is no file upload
    if( $error === 4 ){
        echo "
            <script>
                alert('Please upload a file!')
            </script>
       ";
       return false; 
    }

    // checking the file extension type
    $allowed = ['pdf'];
    $fileExtension = explode('.', $fileName); // will return an array of the file name;
    $fileExtension = strtolower( end( $fileExtension ));
    if( !in_array($fileExtension, $allowed) ) { // this function could find if a string is part of the array; 
        echo "
            <script>
                alert('Your file type is not compatible!')
            </script>
       ";
       return false;
    }

    // checking the file size
    if( $fileSize > 1000000 ) {
        echo "
            <script>
                alert('Your file size is too big!')
            </script>
       ";
       return false;
    }

    // file ready to be upload
    // generate new file name
    $newFileName = uniqid();
    $newFileName .= '.';
    $newFileName .= $fileExtension;

    move_uploaded_file($tmpName, '../../dist/files/' . $newFileName);

    return $newFileName;

}

function deletes($id) {
    global $conn;
    mysqli_query($conn, "DELETE FROM rusialdi WHERE id_nama = $id");

    return mysqli_affected_rows($conn);
}

function edit($data) {
    global $conn;

    $id = $data["id"];
    $nama = htmlspecialchars($data["nama_pembeli"]);
    $hp = htmlspecialchars($data["hp"]);
    $id_barang = htmlspecialchars($data["id_barang"]);
    $kuantitas = htmlspecialchars($data["jumlah"]);
    $harga = htmlspecialchars($data["harga"]);
    $jenisbarang = htmlspecialchars($data["jenis_barang"]);
    $alamat = htmlspecialchars($data["alamat"]);
    $tgl_transaksi = date('Y-m-d');
    
    $query = "UPDATE rusialdi SET
               nama = '$nama',
               alamat = '$alamat',
               hp = '$hp',
               jenis_barang = '$jenisbarang',
               id_barang = '$id_barang',
               harga = '$harga',
               jumlah = '$kuantitas',
               tgl_transaksi = '$tgl_transaksi'
               WHERE id_nama = $id"; 

    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function find($keyword) {
    $query = "SELECT np, nama, nip, instansi, status_berkas FROM data_diri
                WHERE
                nama LIKE '%$keyword%' OR
                nip LIKE '%$keyword%' OR
                instansi LIKE '%$keyword%'";
                
    return query($query);
}

function approve($data) {
    global $conn;

    $np = $data["np"];
    $status = "approve";
    
    $query = "UPDATE data_diri SET
               status_berkas = '$status'
               WHERE np = $np"; 

    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function refuse($data) {
    global $conn;

    $np = $data["np"];
    $status = "refuse";
    
    $query = "UPDATE data_diri SET
               status_berkas = '$status'
               WHERE np = $np"; 

    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

?>