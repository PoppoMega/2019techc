<?php
session_start();
//echo "ログアウト";
unset($_SESSION['login_user']);
header('Location:read.php');

