<?php 

require_once 'functions.php';

$id = $_GET['id'];

$query = "SELECT * FROM posts WHERE id = '$id' LIMIT 1";

$result = mysqli_query($con,$query);

$post = mysqli_fetch_assoc($result);

$user_id = $post['user_id'];

$query = "SELECT * FROM users WHERE id = '$user_id' LIMIT 1";

$result = mysqli_query($con,$query);

$author = mysqli_fetch_assoc($result);


if($_SERVER['REQUEST_METHOD'] == 'GET' && empty($_GET['id']))
{
    header("Location: index.php");
}
else if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    
    $comment_user_id = $_SESSION['user']['id'];
    $comment_content = $_POST['comment_content'];
    $post_id = $_GET['id'];
    
    
    $query = "INSERT INTO comments(content,user_id,post_id) VALUES('$comment_content','$comment_user_id','$post_id')";

    $result = mysqli_query($con,$query);

    echo "<meta http-equiv='refresh' content='0'>";

    //header("Refresh:0");
}

$post_id = $_GET['id'];

$query = "SELECT * FROM comments WHERE post_id ='$post_id'";

$comments_result = mysqli_query($con,$query);








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


<div class="row d-flex justify-content-center">
  <div class="col-md-8 col-lg-6">
    <div class="card shadow-0 border">
      <div class="card-body p-4">

        
      <div class="card mb-3 bg-info-subtle">
          <div class="card-body">
            <h4><?= $post['title'] ?></h4>
            <hr>
            <p><?= $post['post'] ?> </p>
            <div class="d-flex justify-content-between">
              <div class="d-flex flex-row align-items-center text-muted">
                by <?= $author['username'] ?> on <?= date('Y-m-d',strtotime($post['date'])) ?>
              </div>
            </div>
          </div>
        </div>        


        <div data-mdb-input-init class="form-outline mb-4">
            <form method="POST">
            
            
    <textarea class="form-control" name="comment_content" rows="3" required></textarea>
            <button type="submit" class="btn btn-primary mt-2">+ Add a comment</button>
            </form>
         
        </div>

    <?php 
    while($row = mysqli_fetch_assoc($comments_result))
    {
?>

        

        <div class="card mb-3">
          <div class="card-body">
            <p><?= $row['content'] ?></p>

            <div class="d-flex justify-content-between">
              <div class="d-flex flex-row align-items-center text-muted">
                by 

                <p class="small mb-0 ms-2"><?= get_author_name($row['user_id'],$con) ?></p>
              </div>
            </div>
          </div>
        </div>        

        

      






<?php }?>
</div>
    </div>
  </div>
</div>


</body>
</html>





















