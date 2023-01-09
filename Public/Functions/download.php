<?php
if(!empty($_GET['file'])){
    $fileName = basename($_GET['file']);
    $dir="../../dist/files/";
    $filepath = $dir.$fileName;
    
    if(!empty($fileName) && file_exists($filepath)) {
        clearstatcache();
        $fileSize = filesize($filepath);

        // Define header
        
        // header("Cache-Control: no-cache");
        // header("Content-Description: File Transfer");
        // header("Content-Length: ".$fileSize);
        // header("Content-Disposition: attachment; filename=".$fileName);
        // header("Content-Type: application/octet-stream");

            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename='.$fileName);
            header('Expired: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Control:public');
            header('Content-Length: '.$fileSize);
        // header("X-Pad: avoid browser bug");
        // header('Content-Transfer-Encoding: chunked');

        // Read File
            ob_clean();
            flush();
            // $a = file_exists($filepath);
            // var_dump($a); 
            readfile($filepath);
            exit();
            //var_dump($a);
            // echo "<br>";
            // var_dump($filepath);
            // echo "<br>";
            // var_dump($fileSize);
    } else {
        echo "File is not exist";
    }
}


?>