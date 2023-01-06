<?php
if(!empty($_GET['file'])){
    $fileName = basename($_GET['file']);
    $filepath = "../../dist/files/".$fileName;
    
    if(!empty($fileName) && file_exists($filepath)) {
        $fileSize = filesize($filePath);

        // Define header
        header("Cache-Control: no-cache");
        header("Content-Description: File Transfer");
        header("Content-Length: ".$fileSize);
        header("Content-Disposition: attachment; filename=".$fileName);
        header("Content-Type: application/octet-stream");

        // header("Content-Description: File Transfer");
        // header("Content-Type: application/octet-stream");
        // header("Content-Disposition: attachment; filename=".$filename);
        // header("Content-length: ".$fileSize);
        // header("X-Pad: avoid browser bug");
        // header("Cache-Control: no-cache");
        //header('Content-Transfer-Encoding: chunked');

        // Read File
        readfile($filepath);
        exit();
    } else {
        echo "File is not exist";
    }
}


?>