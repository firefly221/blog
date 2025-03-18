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

<?php 

  $id = $_SESSION['user']['id'];

  $query = "SELECT * FROM comments WHERE user_id = '$id'";

  $result_comments = mysqli_query($con,$query);

  $no_of_comments = mysqli_num_rows($result_comments);

?>



<?php 

$id = $_SESSION['user']['id'];
$query = "SELECT * FROM posts WHERE user_id = '$id'";

$result_posts = mysqli_query($con,$query);

$no_of_posts = mysqli_num_rows($result_posts);



?>









<?php if (empty($_GET['action'])) {?>



  <section class="w-100 px-4 py-5" style="border-radius: .5rem .5rem 0 0;">
  <div class="row d-flex justify-content-center">
    <div class="col col-md-9 col-lg-7 col-xl-6">
      <div class="card" style="border-radius: 15px;">
        <div class="card-body p-4">
          <div class="d-flex">
            <div class="flex-shrink-0">
              <img src="<?php 
                if($_SESSION['user']['image'])
                {
                  echo $_SESSION['user']['image'];
                }
                else
                {
                  echo 'pic.jpeg';
                }
              
              ?>"
                alt="Generic placeholder image" class="img-fluid" style="width: 180px; border-radius: 10px;">
            </div>
            <div class="flex-grow-1 ms-3">
              <h5 class="mb-1"><?= $_SESSION['user']['username'] ?></h5>
              <div class="d-flex justify-content-start rounded-3 p-2 mb-2 bg-body-tertiary">
                <div>
                  <p class="small text-muted mb-1">Posty</p>
                  <p class="mb-0"><?= $no_of_posts ?></p>
                </div>
                
                <div class="px-3">
                  <p class="small text-muted mb-1">Komentarze</p>
                  <p class="mb-0"><?= $no_of_comments ?></p>
                </div>
                
              </div>
              <div class="row">
              <div class="col">
                <a href="user.php?action=edit"><button class="btn btn-warning">Edytuj zdjęcie</button></a>
                </div>
            </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>



<h4 class="text-center mb-3">Twoje komentarze</h4>

<ol class="list-group list-group-numbered container col-5">

 <?php while ($row = mysqli_fetch_assoc($result_comments) ) { ?>

  <li class="list-group-item d-flex justify-content-between align-items-start">
    <div class="ms-2 me-auto">
      <div class="fw"><?= $row['content'] ?></div>
      <div class="text-muted"><a href="details.php?id=<?= $row['post_id'] ?>">Link do posta</a></div>
    </div>
  </li>
  

  <?php } ?>
</ol>


  
  
  

<?php }else{?>

    

 

<div class = "container text-center">


<form method = "POST" enctype="multipart/form-data"> 


  
  <div class="form-group container text-center mb-5">
  
  <input class="form-control" type="file" name="image">
</div>


<button class= "btn btn-success btn-lg mb-4">Zapisz</button>

</form>

<a href="user.php"><button class= "btn btn-danger btn-lg ">Wróć</button></a>

</div>






<?php }?>








</body>
</html>




