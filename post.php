<?php
include("conect.php");
$sql = 'SELECT * from posts';
$result = mysqli_query($conn, $sql);
$posts = mysqli_fetch_all($result, MYSQLI_ASSOC);

mysqli_free_result($result);
mysqli_close($conn);


$post = array_filter($posts, function($mypost){
    return $mypost['ID'] == '1';
})


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posts</title>
</head>

<body>
    <section>
        <h1>
            <?php 
                var_dump($post['nome']);
            
            ?>
            <?= $post['name']?>
        </h1>

    </section>
</body>

</html>