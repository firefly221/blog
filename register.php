<?php 
    require_once "functions.php";
    
    

    if(empty($_SESSION['email']) == false)
    {
        header('Location: index.php');
        die;
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $date = date('Y-m-d');


        
        $query = "INSERT INTO users (username,email,password,date) VALUES('$username','$email','$password','$date')";   
            
        $result = mysqli_query($con,$query);

        $query2 = "SELECT * FROM users WHERE email = '$email' AND password = '$password' LIMIT 1";
        $result2 = mysqli_query($con,$query2);

        
        $row = mysqli_fetch_assoc($result2);
        $_SESSION['user'] = $row;
            
            


        header("Location: index.php");
        die;
    }




?>





<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body>
    
<?php 
    include 'header.php';
?>




<div class="jumbotron text-center">
  <h1 class="display-4">Hello, world!</h1>
  <p class="lead">This is a simple hero unit, a simple jumbotron-style component for calling extra attention to featured content or information.</p>
  <hr class="my-4">
  <p>It uses utility classes for typography and spacing to space content out within the larger container.</p>
  <p class="lead">
    
  </p>
</div>


<form method="POST" class="form-inline">
  <div class="form-group col-sm-3">
    <label for="email">Email address</label>
    <input name="email" type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter email" required>
  </div>
  <div class="form-group col-sm-3">
    <label for="username">Username</label>
    <input name="username" type="text" class="form-control" id="username" placeholder="Username" required>
  </div>
  <div class="form-group col-sm-3">
    <label for="password">Password</label>
    <input name="password" type="password" class="form-control" id="password" placeholder="Password" required>
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>





</body>
</html>
