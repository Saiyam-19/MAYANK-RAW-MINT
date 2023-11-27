<?php

//files

if(isset($_FILES['fileattach'])){
    $errors= array();
    $file_name = basename($_FILES['fileattach']['name']);
    $file_size = $_FILES['fileattach']['size'];
    $file_tmp = $_FILES['fileattach']['tmp_name'];
    $file_type = $_FILES['fileattach']['type'];
    $file_ext=strtolower(end(explode('.',$_FILES['fileattach']['name'])));
    
    if($file_name!==''){
        $extensions= array("jpeg","jpg","png","pdf");
    
        if(in_array($file_ext,$extensions)=== false){
           $errors[]="Allowed file types are PDF, JPEG and PNG. ";
        }
        
        if($file_size > 166777216) {
           $errors[]='File size must not exceed 16 MB';
        }
        
        if(empty($errors)==true) {
            $salt = rand(100000,999999);
          move_uploaded_file($file_tmp, $_SERVER['DOCUMENT_ROOT']."/"."uploads/".$salt.'-'.$file_name);
           echo "File Upload was successful. ";
        }else{
          echo $errors[0];
        }
    }
 }

//

if(isset($_FILES['name'])){
    $name = $_POST['name'];
}
if(isset($_FILES['number'])){
    $number = $_POST['number'];
}
if(isset($_FILES['company'])){
    $company = $_POST['company'];
}
if(isset($_FILES['details'])){
    $details = $_POST['details'];
}

$data = '<b>Form Data: </b>';
foreach ($_POST as $key => $value) {
    if(!is_int($key)){
        $data .= '<br><b>'.htmlspecialchars($key).' : </b>'.htmlspecialchars($value).'<br>';    
    }
}

require 'PHPMailerAutoload.php';

$mail = new PHPMailer;

$mail->SMTPDebug = 0;                               // Enable verbose debug output

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'mail.mayankrawmint.com';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'butler@mayankrawmint.com';                 // SMTP username
$mail->Password = '0!Qaimn9#[Oa';                           // SMTP password
// $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 587;                                    // TCP port to connect to

$mail->setFrom('butler@mayankrawmint.com', 'Butler');
$mail->addAddress('info@mayankrawmint.com', 'Info Mayank Raw Mint');     // Add a recipient
// $mail->addAttachment($_SERVER['DOCUMENT_ROOT']."/"."uploads/"."test.jpg");            //Add attachment
$mail->addAttachment($_SERVER['DOCUMENT_ROOT']."/"."uploads/".$salt.'-'.$file_name);            //Add attachment

// $mail->AddAttachment($file_tmp, $file_name);

// $mail->addAddress('ellen@example.com');               // Name is optional
// $mail->addReplyTo('info@example.com', 'Information');
// $mail->addCC('cc@example.com');
// $mail->addBCC('bcc@example.com');
// $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
// $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = 'New Form Submission';
$mail->Body = $data;

// if(empty($errors)==true) {
    if(!$mail->send()) {
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        echo 'Message has been sent.';
    }
// }

echo('<a href="http://mayankrawmint.com/">Go to Home</a>')
?>