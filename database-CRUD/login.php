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
$salt = 'XyZzy12*_';
try{
    $conn = new PDO("mysql:host=$databaseHost;dbname=$databaseName", $databaseUsername, $databasePassword); 
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if(isset($_POST["login"]))
    {
        if($_POST["email"] && $_POST["pass"])
        {
            $query = "select * from users where email= :email and password = :password";
            $statment = $conn->prepare($query);
            $statment->execute(
                array(
                    'email' => $_POST["email"],
                    'password' =>  md5($salt.$_POST['pass'])
                )
                );
                $count = $statment->rowCount();
                if($count > 0)
                {
                    $user=$statment->fetch();
                    
                    $_SESSION['email'] = $_POST["email"];
                    $_SESSION['user_id'] = $user[0]['user_id'];                ;
                    $_SESSION['valid'] = True;
                    $_SESSION['success'] = "success";
                    header('Location: index.php');            
                }
                else
                {
                    
                    $warnning =  md5($_POST['pass'].$salt) ;
                    $_SESSION['warnning'] = $warnning;
                    header("Location: login.php");            
                }
            }
            else
            {
                $warnning = "Both fields must be filled out";
                $_SESSION['warnning'] = $warnning;
                header("Location: login.php");  
            }
    }
    else
    {
        $index="index.php";
        echo '<h1>Login</h1>';

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
                            <td width="10%">Email</td>
                            <td><input type="text" name="email"></td>
                        </tr>
                        <tr> 
                            <td>Password</td>
                            <td><input type="password" name="pass"></td>
                        </tr>
                        <tr> 
                            <td><input type="submit" name="login" value="Submit"></td>';
             echo'<td><input type=\'button\' value="Cancel" onClick="window.location.href=\''.$index.'\'";> </td>';
        echo '         </tr>
                </table>
            </form>
        ';  
    }  
    
}
catch(PDOException $error)
{
    $warnning= $error->getMessage();
    $_SESSION['warnning'] = $warnning;
    header("warnning: index.php");            
}

?>

</body>
</html>