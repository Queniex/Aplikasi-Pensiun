<?php 
    require_once("../Functions/function-krip.php");
    $id =  $_GET["np"];
    if (delete($id) > 0) {
        echo "
            <script>
                alert('Data Berhasil Dihapus');
                document.location.href = 'krip.php';
            </script>
            ";
    } else {
        echo "
            <script>
                alert('Data Gagal Dihapus');
                document.location.href = 'krip.php';
            </script>
            ";
    }
?>