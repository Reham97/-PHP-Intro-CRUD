<?php session_start(); ?>
<html>
<head>
<title>Name: Reham Hussein Ramadan</title>
</head>
 
<?php 
$databaseHost = '127.0.0.1';
$databaseName = 'test';
$databaseUsername = 'reham';
$databasePassword = '';

try{
    $conn = new PDO("mysql:host=$databaseHost;dbname=$databaseName", $databaseUsername, $databasePassword); 
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = "select * from Profile";
    $statment = $conn->query($query);
    $data = $statment->fetchAll(PDO::FETCH_ASSOC);
}
catch(PDOException $error)
{
    $warnning= $error->getMessage();
    $_SESSION['warnning'] = $warnning ;

}
?>

<body>
    <h1> Reham Hussein Ramadan's Resume Registry </h1>
   
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


    if(!isset($_SESSION['valid'])) {   
        echo "<a href='login.php'>Please log in</a> ";
        echo '<table width="55%" border="1"> <tr>';
        echo '<th>Name</th><th>Headline</th></tr>';

        foreach ($data as $d){
            echo "<tr> 
            <td> <a href='view.php?profile_id=".$d['profile_id']."'> ";
            echo $d['first_name'].$d['last_name'];
            echo "</a> </td> <td>".$d['headline']. "</td>";
            echo "</tr>";
        }
        echo '</table>';
        echo '<br>';
        
    }
    else
    {
        echo "<a href='logout.php'>Logout</a> ";
        echo '<table width="55%" border="1"> <tr>';
        echo '<th>Name</th><th>Headline</th><th>Action</th></tr>';

        // echo count($data)."unvalid";
        foreach ($data as $d){
            echo "<tr> 
            <td> <a href='view.php?profile_id=".$d['profile_id']."'> ";
            echo $d['first_name'].$d['last_name'];
            echo "</a> </td> <td>".$d['headline']. "</td>";
            echo "<td> <a href='edit.php?profile_id=".$d['profile_id']."'> Edit</a>";
            echo "<a href='delete.php?profile_id=".$d['profile_id']."'> Delete</a> </td>";
            echo "</tr>";
        }
        echo '</table>';
        echo '<br>';
        echo "<a href='add.php'>Add New Entry</a> ";
    }
    ?>

</body>
</html>