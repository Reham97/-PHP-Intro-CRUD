<?php session_start(); ?>
<html>
<head>
<title> Reham Hussein Ramadan</title>
</head>
 
<?php 
$databaseHost = '127.0.0.1';
$databaseName = 'test';
$databaseUsername = 'reham';
$databasePassword = '';

try{
    $conn = new PDO("mysql:host=$databaseHost;dbname=$databaseName", $databaseUsername, $databasePassword); 
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = "select * from Profile where profile_id = ".$_GET['profile_id'];
    $statment = $conn->query($query);
    $data = $statment->fetchAll(PDO::FETCH_ASSOC);
    
    $first_name = $data[0]['first_name'];
    $last_name = $data[0]['last_name'];
    $email = $data[0]['email'];
    $headline = $data[0]['headline'];
    $summary = $data[0]['summary'];
  

    
}
catch(PDOException $error)
{
    $warnning= $error->getMessage();
    $_SESSION['warnning'] = $warnning ;

}
?>


<body>
    <h1> Profile Information </h1>

    <?php

    if(!empty($_SESSION['success']))
    {  
        $success = $_SESSION['success'];
        echo "<div style='color:green'> $success <div>";
        unset($_SESSION['success']);

    }

    if(!empty($_SESSION['warnning']))
    {  
        $warnning = $_SESSION['warnning'];
        echo "<div style='color:red'> $warnning <div>";
        unset($_SESSION['warnning']);
    }


    if($data) 
    {
        
        echo '<table width="25%" border="0"> <tr>';
        echo "<tr> <td> First Name </td> <td> $first_name </td> </tr>";
        echo "<tr> <td> Last Name </td> <td> $last_name </td> </tr>";
        echo "<tr> <td> Email </td> <td> $email </td> </tr>";
        echo "<tr> <td> Headline </td> <td> $headline </td> </tr>";
        echo "<tr> <td> Summary </td> <td> $summary </td> </tr>";
        echo '</table>'; 
        echo "<a href='index.php'> Done</a>";  
        
    }
    else
    {
       echo "<div style='color:red'> Invalid Profile <div>";
       echo "<a href='index.php'> Done</a>";  
    }
    ?>

</body>
</html>