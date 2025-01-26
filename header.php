<?php 
require_once 'functions.php';




?>


<header class="d-flex justify-content-center py-3">
      <ul class="nav nav-pills">
        <li class="nav-item"><a href="index.php" class="nav-link " aria-current="page">Home</a></li>
        <li class="nav-item"><a href= "user.php" class="nav-link ">Profile</a></li>
        <?php if(empty($_SESSION) == true)
        {
          ?>
        <li class="nav-item"><a href="login.php" class="nav-link ">Login</a></li>
        <li class="nav-item"><a href="register.php" class="nav-link ">Register</a></li>
        <?php
        }
        else{
        ?>
          <li class="nav-item"><a href="logout.php" class="nav-link text-danger ">Logout</a></li>
          
          <?php 
          
          
        }
          
          ?>

      </ul>
    </header>