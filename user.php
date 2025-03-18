<?php 

require_once "functions.php";




if(empty($_SESSION) == true)
{
    header('Location: index.php');
    die;
}



if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        
        
        $image_changed = false;

        if(!empty($_FILES['image']['name']))
        {
            $folder = 'uploads/';

            if(!file_exists($folder))
            {
                mkdir($folder,0777,true);
            }

            $image = $folder . $_FILES['image']['name'];

            move_uploaded_file($_FILES['image']['tmp_name'],$image);

            $image_changed = true;
            if(file_exists($_SESSION['user']['image']))
            {
            unlink($_SESSION['user']['image']);
            }
            
        }

        
        
        

        $id = $_SESSION['user']['id'];
        if($image_changed == false)
        {
            $image = 'pic.jpeg';
        }
        $query = "UPDATE users set image='$image' WHERE id = '$id' LIMIT 1";
            
        $result = mysqli_query($con,$query);

        $query = "SELECT * FROM users WHERE id = '$id' LIMIT 1";
        $result = mysqli_query($con,$query);

        $row = mysqli_fetch_assoc($result);

        $_SESSION['user'] = $row;



        header("Location: user.php");
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


<div class="jumbotron text-center mb-5">
  <h1 class="display-4">Witaj <?= $_SESSION['user']['username'] ?></h1>
  <p class="lead">To jest strona, na której możesz edytować swój profil oraz oglądać komentarze, które napisałeś</p>
  <hr class="my-4">
  <p class="text-warning">Pamiętaj o regulaminie dotyczącym kont użytkownika</p>
  
</div>


<?php if (empty($_GET['action'])) {?>
<div class="container text-center">
  
<div class="row">
    <div class="col">
  <img src="<?php 
    if($_SESSION['user']['image'])
    {
        echo $_SESSION['user']['image'];
    }
    else
    {
        echo "pic.jpeg";
    }
  
  
  ?>" class="rounded" width="300px">
</div>
</div>


<div class="row align-items-start d-flex justify-content-center">
    <div class="col-sm-5 gy-5">
      Lorem ipsum dolor sit amet consectetur adipisicing elit. Soluta aliquam tenetur et nostrum nihil doloremque molestias. Praesentium, ratione quibusdam impedit tempore ipsa quas sed nostrum cum quod, minima, similique earum!
    </div>
    </div>
    
  
  
  <div class="row">
    <div class="col gy-5">
    <a href="user.php?action=edit"><button class="btn btn-warning">Edytuj zdjęcie</button></a>
    </div>
  </div>
</div>
<?php }else{?>

    

 

<div class = "container text-center">


<form method = "POST" enctype="multipart/form-data"> 


  
  <div class="form-group container text-center mb-5">
  
  <input class="form-control" type="file" name="image">
</div>


<button class= "btn btn-success btn-lg mb-4">Save</button>

</form>

<a href="user.php"><button class= "btn btn-danger btn-lg ">Close</button></a>

</div>






<?php }?>








</body>
</html>




