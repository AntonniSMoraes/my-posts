<?php
include("conect.php");

// Verifica se o ID foi passado pela URL
if(!isset($_GET['id'])){
    header('Location: main.php');
    exit();
}

$id = mysqli_real_escape_string($conn, $_GET['id']);

$sql = "SELECT * FROM posts WHERE id = '$id'";
$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) == 0){
    header('Location: main.php');
    exit();
}

$post = mysqli_fetch_assoc($result);

mysqli_free_result($result);
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posts</title>
</head>

<body>
    <section style="
        display: flex;
        flex-direction: column;
        width: 100%;
        align-items: center;
        padding: 2rem 0;
    ">
        <article style="
            display: flex;
            width: 50%;
            flex-direction: column;
            gap: 1rem;
            background-color: lightgray;
            padding: 2rem;
            border-radius: 1rem;
            color: white;
        ">
            <article style="padding:1rem; background:#334; border-radius: .5rem;">
                <h1 style="margin-top: 0;"><?= $post['titulo'] ?></h1>
                <article style="
                    display: flex;
                    justify-content: space-between;
                    border-bottom: 1px solid #556;
                    padding-bottom: 1rem;
                    margin-bottom: 1rem;
                ">
                    <p style="margin: 0;"><strong>Autor:</strong> <?= $post['autor'] ?></p>
                    <p style="margin: 0;"><?= $post['data'] ?></p>
                </article>
                <p style="
                    white-space: normal;
                    word-break: break-word;
                    overflow-wrap: break-word;
                    line-height: 1.6;
                "><?= $post['conteudo'] ?></p>
            </article>
            
            <a href="main.php" style="
                display: inline-block;
                align-self: flex-start;
                padding: 10px 20px;
                background-color: white;
                color: #1f1f1f;
                text-decoration: none;
                border-radius: .5rem;
                font-weight: bold;
            ">← Voltar para Posts</a>
        </article>
    </section>
</body>

</html>