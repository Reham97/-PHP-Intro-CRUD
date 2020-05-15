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

try{
    $conn = new PDO("mysql:host=$databaseHost;dbname=$databaseName", $databaseUsername, $databasePassword); 
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if(isset($_POST["add"]))
    {
        // $query = "select * from users where email= :email and password = :password";
        // $statment = $conn->prepare($query);
        if($_POST['first_name'] && $_POST['last_name']&& $_POST['email'] && $_POST['headline'] && $_POST['summary'])
        {
            if(strpos($_POST['email'],"@"))
            {
                $statment = $conn->prepare('INSERT INTO Profile
                (user_id, first_name, last_name, email, headline, summary)
                VALUES ( :uid, :fn, :ln, :em, :he, :su)');

                $statment->execute(array(
                ':uid' => $_SESSION['user_id'],
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
    
                header("Location: add.php");   
            }
        }
        else
        {
            $warnning = "Missing Input, All Fields are required ";
            $_SESSION['warnning'] = $warnning;

            header("Location: add.php");            
        }          
    }
    else
    {
        $index="index.php";
        echo '<h1>Adding Profile</h1>';

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
                            <td><input type="text" name="first_name"></td>
                        </tr>
              
                        <tr> 
                            <td width="20%">Last Name</td>
                            <td><input type="text" name="last_name"></td>
                        </tr>

                        <tr> 
                            <td width="20%">Email</td>
                            <td><input type="text" name="email"></td>
                        </tr>

                        <tr> 
                            <td width="20%">Headline</td>
                            <td><input type="text" name="headline"></td>
                        </tr>


                        <tr> 
                            <td width="20%">Summary</td>
                            <td><input type="text" name="summary"></td>
                        </tr>

                        <tr> 
                            <td><input type="submit" name="add" value="Submit"></td>';
             echo'<td><input type=\'button\' value="Cancel" onClick="window.location.href=\''.$index.'\'";> </td>';
             echo '         </tr>
                </table>
            </form>
        ';  
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

