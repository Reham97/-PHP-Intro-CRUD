<?php session_start(); ?>
<html>
<head>
<title> Reham Hussein Ramadan</title>
</head>
 
<body>
<?php 
$databaseHost = '127.0.0.1';
$databaseName = 'test';
$databaseUsername = 'reham';
$databasePassword = '';

try
{
    $conn = new PDO("mysql:host=$databaseHost;dbname=$databaseName", $databaseUsername, $databasePassword); 
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 
    $statment = $conn->prepare('delete from Profile where profile_id = :pid');

    $statment->execute(array(
    ':pid' => $_GET['profile_id']
    ));

    $_SESSION['success'] = "success";
    header('Location: index.php');     
    
    
}
catch(PDOException $error)
{
    $message= $error->getMessage();
    $_SESSION['warnning'] = $message;
    header("Location: index.php");            
}

?>

</body>
</html>

