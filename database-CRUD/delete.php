<?php session_start(); ?>
<html>
<head>
<title>Name: Reham Hussein Ramadan</title>
</head>
 
<body>
<?php 
$databaseHost = '127.0.0.1';
$databaseName = 'test';
$databaseUsername = 'reham';
$databasePassword = '';

try
{
    if($_POST['delete'])
    {

        

        $conn = new PDO("mysql:host=$databaseHost;dbname=$databaseName", $databaseUsername, $databasePassword); 
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
        $statment = $conn->prepare('delete from Profile where profile_id = :pid');

        $statment->execute(array(
        ':pid' => $_POST['profile_id']
        ));

        $_SESSION['success'] = "success";
        header('Location: index.php');     
    } 
        
}
catch(PDOException $error)
{
    $message= $error->getMessage();
    $_SESSION['warnning'] = $message;
    header("Location: index.php");            
}

?>

<?php
echo '<form name="form" method="post" action="">
<table width="75%" border="0">  
    <tr> 
    <td><input type="submit" name="delete" value="Are You Sure?"></td>
    <td><input type="button" value="Cancel" onClick="window.location.href=\'index.php\'";> </td>
    <td hidden><input type="text" name="profile_id" value="'.$_GET['profile_id'].'"></td>
    </tr>
</table>
</form>';

?>
      

</body>
</html>

