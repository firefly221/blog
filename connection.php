<?php 
session_start();
$con = mysqli_connect('localhost','root','','blog_db');
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;






?>