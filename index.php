<?php 
require_once 'functions.php';


if($_SERVER['REQUEST_METHOD'] == 'POST')
{

    $title = $_POST['title'];
    $content = $_POST['content'];
    $user_id = $_SESSION['user']['id'];
    $date = date('Y-m-d');


    if(!empty($_FILES['image']['name']))
        {
            $folder = 'uploads/';

            if(!file_exists($folder))
            {
                mkdir($folder,0777,true);
            }

            $image = $folder . $_FILES['image']['name'];

            move_uploaded_file($_FILES['image']['tmp_name'],$image);

        }

    $query = "INSERT INTO posts(title,post,image,user_id,date) VALUES('$title','$content','$image','$user_id','$date'
   
    )";
    
    $result = mysqli_query($con,$query);

    header('Location: index.php');




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



<?php if(empty($_GET) == false && $_GET['action'] == 'create' && !empty($_SESSION))
{
    ?>

<div class = "container text-center">

<form method = "POST" enctype="multipart/form-data"> 

<div class="form-group container text-center">
    <label for="title" class="display-6">Title</label>
    <input name="title" type="text" class="form-control mb-5" id="title" placeholder="">

  </div>
  
  <div class="form-group container text-center">
    <label for="content" class="display-6">Content</label>
    
    <textarea name="content" id ="content" class="form-control mb-5" rows="7"></textarea>
  </div>
  

  <div class="form-group container text-center mb-5">
  
  <label for="image" class="display-6">Image</label>
  <input class="form-control" type="file" name="image">

  </div>

<button class= "btn btn-success btn-lg mb-4">Send</button>

</form>


<a href="index.php"><button class= "btn btn-warning btn-lg mb-4">Go back</button></a>


</div>

<?php } else { ?>

    <div class="jumbotron text-center">
  <h1 class="display-4">Strona główna</h1>
  <p class="lead">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quos ipsam explicabo eligendi libero corrupti inventore accusamus distinctio eos exercitationem dolore dicta aperiam.</p>
  <hr class="my-4">
  <p class="text-warning">Pamiętaj o regulaminie dotyczącym użytkowania strony</p>
  
    
    <a href="index.php?action=create"><button class= "btn btn-success btn-lg mb-4">Create post</button></a>
    

</div>
    


<div class="container mx-auto mt-4">
  <div class="row">

<?php 

$query = "SELECT * FROM posts";

$result = mysqli_query($con,$query);

if(mysqli_num_rows($result) > 0)
{

while($row = mysqli_fetch_assoc($result))
{
    
$text_good = substr($row['post'],0,200);

?>



<div class="col-md-4 mb-5">
<div class="card" style="width: 18rem;">
  <img src="<?= $row['image'] ?>" class="card-img-top" style="height:150px;">
  <div class="card-body" style="height:300px;">
    <h5 class="card-title">Card title</h5>
        <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
        <small><?= date('Y-m-d',strtotime($row['date']))?></small>
    
    <hr>
    <p class="card-text "><?= $text_good?></p>
    
  </div>
  </div>
    </div>  





<?php

}
}
}
?>

</div>
</div>

</body>
</html>



