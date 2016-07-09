<?php
require_once '../vendor/autoload.php';
require_once '../src/config.php';

//Receiver input
$pic  = $_FILES['pic'];
$mail = $_POST['mail'];
$name = $_POST['name'];
//Generate filename of pic
$picFilename = uniqid();

//Init aws sdk
if (defined('AWSKey') && defined('AWSSecret')) {
    $awsSdk = new Aws\Sdk([
        'version'     => 'latest',
        'region'      => AWSRegion,
        'credentials' => [
            'key'    => AWSKey,
            'secret' => AWSSecret
        ],
        'scheme' => 'http'
    ]);
} else {
    $awsSdk = new Aws\Sdk([
        'version'     => 'latest',
        'region'      => AWSRegion,
        'scheme' => 'http'
    ]);
}

//Copy file to s3
$s3 = $awsSdk->createS3();
$s3->putObject(
    [
        'Bucket' => S3Bucket,
        'Key'    => $picFilename,
        'Body'   => fopen($_FILES['pic']['tmp_name'], 'r+')
    ]
);

//insert to database
$dbh = new PDO('mysql:host='.DBHost.';port=3306;dbname=demo;charset=UTF8;',DBUser,DBPass);
$stmt = $dbh->prepare("INSERT INTO register (name, mail, pic) VALUES (:name, :mail, :pic)");
$stmt->bindParam(':name', $name);
$stmt->bindParam(':mail', $mail);
$stmt->bindParam(':pic',  $picFilename);
$stmt->execute();
?>

<html>
    <head>
        <title>Register done</title>
    </head>
    <body bgcolor="white">
        done
    </body>
</html>
