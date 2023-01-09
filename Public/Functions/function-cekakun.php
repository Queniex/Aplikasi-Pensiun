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

function upload() {

    $fileName = $_FILES['foto']['name'];
    $fileSize = $_FILES['foto']['size'];
    $error = $_FILES['foto']['error'];
    $tmpName = $_FILES['foto']['tmp_name'];

    // check if there is no picture upload
    if( $error === 4 ){
        echo "
            <script>
                alert('Please upload a picture!')
            </script>
       ";
       return false; 
    }

    // checking the file extension type
    $validPicture = ['jpg', 'jpeg', 'png'];
    $pictureExtension = explode('.', $fileName); // will return an array of the picture name;
    $pictureExtension = strtolower( end( $pictureExtension ));
    if( !in_array($pictureExtension, $validPicture) ) { // this function could find if a string is part of the array; 
        echo "
            <script>
                alert('Your file type is not a picture!')
            </script>
       ";
       return false;
    }

    // checking the file size
    if( $fileSize > 1000000 ) {
        echo "
            <script>
                alert('Your picture size is too big!')
                document.location.href = 'cekakun.php'
            </script>
       ";
       return false;
    }

    // picture ready to be upload
    // generate new picture name
    $newPictureName = uniqid();
    $newPictureName .= '.';
    $newPictureName .= $pictureExtension;

    move_uploaded_file($tmpName, '../../dist/images/' . $newPictureName);

    return $newPictureName;

}

function edit($data) {
    global $conn;

    $id = $data["id"];
    $nama = htmlspecialchars($data["nama"]);
    $email = htmlspecialchars($data["email"]);
    $alamat = htmlspecialchars($data["alamat"]);
    $no_telp = htmlspecialchars($data["no_telp"]);

    $oldPicture = htmlspecialchars($data["foto"]);

    // check if user choosing a new picture
    if( $_FILES['foto']['error'] === 4 ) {
        $gambar = $oldPicture;
    } else {
        $gambar = upload();
    }

    $query = "UPDATE user SET
               nama = '$nama',
               email = '$email',
               no_telp = '$no_telp',
               tanggal_lahir = '$tanggal_lahir',
               alamat = '$alamat',
               foto = '$gambar'
               WHERE id_user = $id"; 

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function debug_to_console($data) {
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}

?>