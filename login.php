<?php 
    
    require_once "functions.php";

    

    if(empty($_SESSION) == false)
    {
        header('Location: index.php');
        die;
    }


    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $email = $_POST['email'];
        $password = $_POST['password'];
        


        if(is_empty($email) ||  is_empty($password))
        {
            
        }
        else
        {
            $query = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
            $result = mysqli_query($con,$query);

            $num_of_rows = mysqli_num_rows($result);

            if($num_of_rows)
            {
                $row = mysqli_fetch_assoc($result);
                $hashed_password = $row['password'];

                if(password_verify($password,$hashed_password))
                {
                $_SESSION['user'] = $row;
                print_r($_SESSION['user']);
                header("Location:index.php");
                die;
                }
                else
                {
                  exit("Zle hasło");
                }
            }
            else
            {
                echo "Wrong email or password";
            }


        }
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


<form method="POST" class=" row gx-3 gy-2 ">
  <div class="col-sm-3">
    <label for="email">Email address</label>
    <input name = "email" type="email" class="form-control" id="email" placeholder="Enter email">
  </div>
  <div class="col-sm-3">
    <label for="password">Password</label>
    <input name="password" type="password" class="form-control" id="password" placeholder="Password">
  </div>
  <div class="row gy-4">
  <button type="submit" class="btn btn-primary col-sm-3">Submit</button>
</div>
</form>





</body>
</html>