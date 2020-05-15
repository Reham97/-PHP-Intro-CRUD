<?php // line 1 added to enable color highlight

session_start();
unset($_SESSION['email']);
unset($_SESSION['user_id']);
unset($_SESSION['valid']);
header('Location: index.php');