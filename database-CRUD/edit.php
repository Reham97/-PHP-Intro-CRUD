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

    

    if(isset($_POST["edit"]))
    {
        if($_POST['first_name'] && $_POST['last_name']&& $_POST['email'] && $_POST['headline'] && $_POST['summary'])
        {
            
            if(strpos($_POST['email'],"@"))
            {
                
                $statment = $conn->prepare('update Profile set first_name = :fn, 
                last_name = :ln, email = :em , headline = :he, summary = :su
                where profile_id = :pid');

                $statment->execute(array(
                ':pid' => $_GET['profile_id'],
                ':fn' => $_POST['first_name'],
                ':ln' => $_POST['last_name'],
                ':em' => $_POST['email'],
                ':he' => $_POST['headline'],
                ':su' => $_POST['summary'])
                );

                $_SESSION['success'] = "success";
                header('Location: index.php');     
            }
            else
            {
                $warnning = "Mail should contain @";
                $_SESSION['warnning'] = $warnning;
    
                header("Location: edit.php?profile_id=".$_GET['profile_id']);   
            }
        }
        else
        {
            $warnning = "Missing Input, All Fields are required ";
            $_SESSION['warnning'] = $warnning;

            header("Location: edit.php?profile_id=".$_GET['profile_id']);   
        }          
    }
    else 
    {
        $query = "select * from Profile where profile_id = ".$_GET['profile_id'];
        $statment = $conn->query($query);
        $data = $statment->fetchAll(PDO::FETCH_ASSOC);
        if($data)
        {        
            $index="index.php";
            echo '<h1>Edit Profile</h1>';

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

            echo'
                <form name="form" method="post" action="">
                    <table width="75%" border="0">
                            <tr> 
                                <td width="20%">First Name</td>
                                <td><input type="text" name="first_name" value="'.$data[0]['first_name'].'"></td>
                            </tr>
                
                            <tr> 
                                <td width="20%">Last Name</td>
                                <td><input type="text" name="last_name" value="'.$data[0]['last_name'].'"></td>
                            </tr>

                            <tr> 
                                <td width="20%">Email</td>
                                <td><input type="text" name="email" value="'.$data[0]['email'].'" ></td>
                            </tr>

                            <tr> 
                                <td width="20%">Headline</td>
                                <td><input type="text" name="headline" value="'.$data[0]['headline'].'"></td>
                            </tr>


                            <tr> 
                                <td width="20%">Summary</td>
                                <td><input type="text" name="summary" value="'.$data[0]['summary'].'"></td>
                            </tr>

                            <tr> 
                                <td><input type="submit" name="edit" value="Submit"></td>';
                echo'<td><input type=\'button\' value="Cancel" onClick="window.location.href=\''.$index.'\'";> </td>';
                echo '         </tr>
                    </table>
                </form>
            ';  
        }  
        else
        {
            echo "<div style='color:red'> Invalid Profile <div>";
            echo "<a href='index.php'> Done</a>";  
        }
    }
    
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

