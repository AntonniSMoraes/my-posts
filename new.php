<?php
    include("./connections/connect.php");

    if(!isset($_SESSION["user_id"])){
        header("Location: login.php");
        exit();
    } else {
        if(isset($_POST["enviar"])){
            $titulo = mysqli_real_escape_string($conn, $_POST["titulo"]);
            $userId = $_SESSION["user_id"];
            // $autor = mysqli_real_escape_string($conn, $_POST["autor"]);
            $autor = $_SESSION["nome"];
            $conteudo = mysqli_real_escape_string($conn, $_POST["conteudo"]);

            $sql = "INSERT INTO posts(titulo, user_id, autor, conteudo, flag, id_flag) VALUES ('$titulo', '$userId', '$autor', '$conteudo', 'post', 0)";

            if(mysqli_query($conn, $sql)){
                header('Location: main.php');
            } else {
                echo 'Erro de query: '.mysqli_error($conn);
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Post</title>
</head>

<body style="margin: 0; padding: 0; height: 100vh;">
    <?php 
        include("./components/header.php");
    ?>

    <section style="
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 100%;
        height: calc(100% - 10rem);
    ">
        <a href="/main.php" style="
                align-self: flex-start;
                display: flex;
                align-items: center;
                gap: .5rem;
                text-decoration: none;
                color: #36454F;    
        ">
            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#36454F">
                <path d="M560-240 320-480l240-240 56 56-184 184 184 184-56 56Z" />
            </svg>
            <p>VOLTAR</p>
        </a>
        <form action="new.php" method="POST" style="
                display: flex;
                flex-direction: column;
                width: 50%;
                padding: 1rem;
                gap: 1rem;
                align-items: flex-start;
                background-color: darkslategrey;
                color: white;
        ">
            <article style="display: flex; flex-direction: column; width: 300px; justify-content: space-between;">
                <label for="titulo">Título</label>
                <input type="text" name="titulo" id="titulo" />
            </article>
            <article style="display: flex; flex-direction: column; width: 100%; justify-content: space-between;">
                <label for="conteudo">Conteúdo</label>
                <textarea name="conteudo" id="conteudo" rows="5" cols="40"></textarea>
            </article>

            <input type="submit" name="enviar" value="enviar" style="
                display: flex;
                align-self: flex-end;
                border: none;
                background-color: white;
                padding: 10px 15px;
            "/>
        </form>
    </section>
    
    <?php 
        include("./components/footer.php");
    ?>
    
</body>

</html>