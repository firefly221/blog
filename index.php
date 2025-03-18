<?php 
require_once 'functions.php';

$category_searched = '';
$keywords_searched = '';


$date_last_post = isset($_SESSION['user']['last_post']) ? $_SESSION['user']['last_post'] : strtotime("April 15 1960");

$date_now = strtotime("now");

$diff_in_time = $date_now - $date_last_post;


if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['title']))
{

    if($diff_in_time < 20)
    {
      ?>
      <script>
        alert("Odczekaj 20 sekund przed następnym postem");

      </script>
      <?php 
    }
    else{
    $title = $_POST['title'];
    $content = $_POST['content'];
    $user_id = $_SESSION['user']['id'];
    $date = date('Y-m-d');
    $category = $_POST['category'];
   




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




    
    $query = "INSERT INTO posts(title,post,image,user_id,date,category) VALUES('$title','$content','$image','$user_id','$date'
    ,'$category'
    )";
    
    $result = mysqli_query($con,$query);
    $NOW = strtotime("now");
    $query = "UPDATE users SET last_post = '$NOW' WHERE id = '$user_id'";
    $result_last_post = mysqli_query($con,$query);
      
    

    $_SESSION['user']['last_post'] = $NOW;


    header('Location: index.php');

      }


}else if($_SERVER['REQUEST_METHOD'] == 'GET')
{
  if (isset($_GET['keywordsSearch']))
  {
  $keywords_searched = $_GET['keywordsSearch'];
  }
  if(isset($_GET['categorySearch']))
  {
  $category_searched = $_GET['categorySearch'];
  }

}







?>




<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="canonical" href="https://getbootstrap.com/docs/4.3/components/forms/">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<style>
.card:hover{
    box-shadow: 8px 8px grey;
    transform:scale(1.03);
}


</style>

</head>
<body>
    
<?php 
    include 'header.php';

?>



<?php if(empty($_GET) == false && !empty($_GET['action']) && $_GET['action'] == 'create' && !empty($_SESSION))
{
    ?>

<div class = "container text-center">

<form method = "POST" enctype="multipart/form-data"> 

<div class="form-group container text-center">
    <label for="title" class="display-6">Title</label>
    <input name="title" type="text" class="form-control mb-5" id="title" placeholder="" required>

  </div>
  
  <div class="form-group container text-center">
    <label for="content" class="display-6">Content</label>
    
    <textarea name="content" id ="content" class="form-control mb-5" rows="7"></textarea>
  </div>
  

  <div class="form-group container text-center mb-5">
  
  <label for="image" class="display-6">Image</label>
  <input class="form-control" type="file" name="image">

  </div>

  <div class="form-group container text-center mb-5">
  
  <label for="image" class="display-6">Category</label>
  <select class="form-control form-control-sm" name="category">
  <option>Algebra</option>
  <option>Analiza</option>
  <option>Geometria</option>
  </select>

  </div>

<button class= "btn btn-success btn-lg mb-4">Send</button>

</form>


<a href="index.php"><button class= "btn btn-warning btn-lg mb-4">Go back</button></a>


</div>

<?php } else if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['thumbsup']) && isset($_SESSION['user'])) 
{
  

  $user_id = $_SESSION['user']['id'];

  $post_id = $_POST['thumbsup'];

  #Na początku sprawdzamy czy użytkownik już zalajkował posta
  $query = "SELECT * FROM likes WHERE post_id = '$post_id' AND user_id = '$user_id'";

  $result_is_liked = mysqli_query($con,$query);

  if(mysqli_num_rows($result_is_liked) == 0)
  {


  $query = "INSERT INTO likes(likes_cnt,post_id,user_id) VALUES('0','$post_id','$user_id')";

  $result_liked = mysqli_query($con,$query);

  }
  else
  {
    $query = "DELETE FROM likes WHERE post_id = '$post_id' AND user_id = '$user_id'";

    $result_like_delete = mysqli_query($con,$query);

  }

  header("Refresh:0");
?>
<?php } else { ?>

    <div class="jumbotron text-center row justify-content-center">
  <h1 class="display-4">Strona główna</h1>
  <p class="lead col-6 text-center">Na tej stronie znajdziesz posty dotyczące różnych zagadnień matematycznych. Zawierają one omówienia teorii, 
    przykłady zastosowań oraz rozwiązania problemów matematycznych.
     Treści obejmują zarówno podstawowe koncepcje, jak i bardziej zaawansowane tematy. 
     Celem strony jest dostarczanie precyzyjnych i rzeczowych informacji, które mogą być 
     przydatne w nauce, pracy lub analizie matematycznej.</p>
  <hr class="my-4">
  <p class="text-warning">Pamiętaj o regulaminie dotyczącym użytkowania strony</p>
  
    
    <a href="index.php?action=create"><button class= "btn btn-success btn-lg mb-4">Create post</button></a>
    

</div>




<form class="container" method="GET">
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputKeywords">Keywords</label>
      <input type="text" class="form-control" id="inputKeywords" name="keywordsSearch">
    </div>
    <div class="form-group col-md-4">
      <label for="inputCategory">Category</label>
      <select id="inputCategory" class="form-control" name="categorySearch">
        <option selected value="">No category</option>
        <option>Analiza</option>
        <option>Algebra</option>
        <option>Geometria</option>
      </select>
    </div>
  <button type="submit" class="btn btn-primary mt-3">Search!</button>
</form>






<div class="container mx-auto mt-4">
  

  <div class="row">
  

<?php 

$query = "SELECT * FROM posts";


if($category_searched != '')
{
  $tmp_category = $_GET['categorySearch'];
  $query = "SELECT * FROM posts WHERE category = '$tmp_category'";
}

$result = mysqli_query($con,$query);

if(mysqli_num_rows($result) > 0)
{

while($row = mysqli_fetch_assoc($result))
{

$text_len = strlen($row['post']);
$text_good = substr($row['post'],0,50);
if($text_len > 50)
{
  $text_good .= '...<br>' . 'Click image to view more';
}



$author_name = get_author_name($row['user_id'],$con);

$WHOLE_TEXT = $row['post'] . " " . $row['title'] . " " . $author_name;

if($keywords_searched != '')
{
  if(str_contains($WHOLE_TEXT,$keywords_searched) == 0)
  {
    continue;
  }

}


$likes_count = 0;

$post_id = $row['id'];

$query = "SELECT * FROM likes WHERE post_id = '$post_id'";

$result_likes = mysqli_query($con,$query);

$likes_count = mysqli_num_rows($result_likes);





?>



<div class="col-md-4 mb-5">
<div class="card" style="width: 18rem;">
  <a href="details.php?id=<?= $row['id'] ?>">
    <img src="<?= $row['image'] ?>" class="card-img-top" style="height:150px;"></a>
  <div class="card-body" style="height:300px;">
    <h5 class="card-title"><?= $row['title'] ?></h5>
        <h6 class="card-subtitle mb-2 text-muted"><a href="index.php?category=<?= $row['category']?>" style="text-decoration:none;"><?= $row['category']?></a></h6>
        <small><?= date('Y-m-d',strtotime($row['date']))?> by <?= $author_name ?></small>
        
        
        <form method="POST">
          <input type="hidden" name="thumbsup" value="<?= $row['id'] ?>">
          <button type="submit" class="btn">
        <h6 class="card-subtitle mb-2 text-primary mt-3"> <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-hand-thumbs-up" viewBox="0 0 16 16">
  <path d="M8.864.046C7.908-.193 7.02.53 6.956 1.466c-.072 1.051-.23 2.016-.428 2.59-.125.36-.479 1.013-1.04 1.639-.557.623-1.282 1.178-2.131 1.41C2.685 7.288 2 7.87 2 8.72v4.001c0 .845.682 1.464 1.448 1.545 1.07.114 1.564.415 2.068.723l.048.03c.272.165.578.348.97.484.397.136.861.217 1.466.217h3.5c.937 0 1.599-.477 1.934-1.064a1.86 1.86 0 0 0 .254-.912c0-.152-.023-.312-.077-.464.201-.263.38-.578.488-.901.11-.33.172-.762.004-1.149.069-.13.12-.269.159-.403.077-.27.113-.568.113-.857 0-.288-.036-.585-.113-.856a2 2 0 0 0-.138-.362 1.9 1.9 0 0 0 .234-1.734c-.206-.592-.682-1.1-1.2-1.272-.847-.282-1.803-.276-2.516-.211a10 10 0 0 0-.443.05 9.4 9.4 0 0 0-.062-4.509A1.38 1.38 0 0 0 9.125.111zM11.5 14.721H8c-.51 0-.863-.069-1.14-.164-.281-.097-.506-.228-.776-.393l-.04-.024c-.555-.339-1.198-.731-2.49-.868-.333-.036-.554-.29-.554-.55V8.72c0-.254.226-.543.62-.65 1.095-.3 1.977-.996 2.614-1.708.635-.71 1.064-1.475 1.238-1.978.243-.7.407-1.768.482-2.85.025-.362.36-.594.667-.518l.262.066c.16.04.258.143.288.255a8.34 8.34 0 0 1-.145 4.725.5.5 0 0 0 .595.644l.003-.001.014-.003.058-.014a9 9 0 0 1 1.036-.157c.663-.06 1.457-.054 2.11.164.175.058.45.3.57.65.107.308.087.67-.266 1.022l-.353.353.353.354c.043.043.105.141.154.315.048.167.075.37.075.581 0 .212-.027.414-.075.582-.05.174-.111.272-.154.315l-.353.353.353.354c.047.047.109.177.005.488a2.2 2.2 0 0 1-.505.805l-.353.353.353.354c.006.005.041.05.041.17a.9.9 0 0 1-.121.416c-.165.288-.503.56-1.066.56z"/>
</svg> <?= $likes_count ?></h6>
</button>

</form>
    
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



