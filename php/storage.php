<?php
    if (isset($_FILES['storageFile']) ) {
        $filePath  = $_FILES['storageFile']['name'];

        $POST_DATA = array(
            //'storageFile' => '@'.  realpath($filePath)
            //'storageFile' => "@C:\Users\kunal\Desktop\BhavikWork\www.zip"
            'uploadFile'=>"uploadFile",
            'storageFile'=>'@'. $_FILES['storageFile']['tmp_name'].';filename=' . $_FILES['storageFile']['name']
        );

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'http://www.igmrobotics.com/php/storage.php');
        curl_setopt($curl, CURLOPT_TIMEOUT, 120);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $POST_DATA);
        $response = curl_exec($curl);

         if($errno = curl_errno($curl)) {
            echo $errno;
            $error_message = curl_strerror($errno);
            echo "cURL error ({$errno}):\n {$error_message}";
        } else {
            echo ("<SCRIPT LANGUAGE='JavaScript'>
              window.alert('File Uploaded!!')
              window.location.href='../pages/storage.php';
              </SCRIPT>");
        }
        curl_close ($curl);
    }else if(isset($_POST["fileList"])){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'http://www.igmrobotics.com/php/storage.php');
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $POST_DATA = array('listFile'=>"listFile");
        curl_setopt($curl, CURLOPT_POSTFIELDS, $POST_DATA);
        $response = curl_exec($curl);
        echo $response;
    }else if(isset($_POST["deleteStorage"])){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'http://www.igmrobotics.com/php/storage.php');
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $POST_DATA = array('fileName'=>$_POST["fileName"],'deleteFile'=>"deleteFile");
        curl_setopt($curl, CURLOPT_POSTFIELDS, $POST_DATA);
        $response = curl_exec($curl);
        echo $response;
    }
?>