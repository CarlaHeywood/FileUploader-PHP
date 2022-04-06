<?php
    // echo $_SERVER['PHP_SELF']; // Made it!

    //*************************      File Upload      ***************************//
    $errors = array();
    $currentDirectory = getcwd();
    $uploadDirectory = "/uploads/";
    $fileExtensionsAllowed = ['txt','doc','exl']; // These will be the only file extensions allowed
    $fileLimitMb = 10; // File limit in MB
    $uploadOk = true;

    $uploadFileName = $_FILES['uploadFile']['name'];

    if(empty($uploadFileName)){ // Check upload file was selected
        echo "<br>" .'No file input found.. ';
        $uploadOk = false;
    }
    else{
        echo 'File to Upload: ' . "<b>" . $uploadFileName . "</b>" . "<br>************<br><br>";
        //print_r($_FILES);
    }
    
    $fileSize = $_FILES['uploadFile']['size'];
        // echo "Size: " . $fileSize . "<br>";
    $fileTmpName  = $_FILES['uploadFile']['tmp_name'];
        // echo "TmpName: " . $fileTmpName . "<br>";
    $fileType = $_FILES['uploadFile']['type'];
       //  echo "Type: " . $fileType . "<br><br>";
    $fileExtension = strtolower(end(explode('.',$uploadFileName)));
    //$fileType = strtolower(pathinfo($uploadFileName,PATHINFO_EXTENSION));

    $uploadPath = $currentDirectory . $uploadDirectory . basename($uploadFileName);
    
    // Check if file already exists
    if (file_exists($uploadPath) && !empty($uploadFileName)){
        echo $exists . "File already exists. ";
        $uploadOk = false;
    }

    // Check file size
    if ($fileSize > ($fileLimitMb * 100000)) {
        echo "File must be less than " . $fileLimitMb . "MB. ";
        $uploadOk = false;
    }

    // Allow certain file formats 
    if(! in_array($fileExtension,$fileExtensionsAllowed) && !empty($uploadFileName)) {
        echo "Sorry, only TXT, DOC, EXL files are allowed. ";
        $uploadOk = false;
    }

    // Check if $uploadOk then process
    if ($uploadOk == false) {
        echo "File was not uploaded. <br><br>";
     } else {
        if (move_uploaded_file($fileTmpName, "uploads/" .$uploadFileName)) {
            echo "The file ". basename($uploadFileName). " has been uploaded successfully.";
        } else {
            echo "Sorry, there was an error uploading your file. Try again.";
        }
     }
     //***********************************************************************//
    
     echo "<b>File Content:</b><br>"; 

    // Open the file with a list  // fopen("uploadFileName","mode: r - read only")
    $openedFile = fopen($uploadPath,"r");

    // Check if file opened successfully
    if($openedFile){ 
        while(! feof($openedFile))  {
            $content = fgets($openedFile, 1000); 
            echo $content . "<br>";
        }
        // flock($openedFile, LOCK_UN); // unlock first if needed
        fclose($openedFile);
    }
?>