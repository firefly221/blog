<?php 

require "connection.php";






function is_empty($text)
{
    if ($text == '')
    {
        return true;
    }
    else
    {
    return false;
    }
}


function get_author_name($author_id,$conn)
{
    $query = "SELECT * FROM users WHERE id = '$author_id' LIMIT 1";

    $result = mysqli_query($conn,$query);

    $name = mysqli_fetch_assoc($result);


    return $name['username'];
}

function generateVerificationCode($length = 6)
{
    $characters = '0123456789';
    $code = '';
    for($i = 0;$i<$length;$i++)
    {
        $code .= $characters[rand(0,strlen($characters)-1)];
    }
    return $code;
}










?>







