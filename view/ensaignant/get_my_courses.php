<?php 
session_start();
require "../../model/Course.php";
$courses = new VideoCourse(null,null,null,$_SESSION['user_id'],null);
$courses->getallCourse($_SESSION['id_user']);


?>