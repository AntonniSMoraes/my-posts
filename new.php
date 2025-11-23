<?php
    include("conect.php");

    if(isset($_POST["enviar"])){
        $titulo = mysqli_real_escape_string($conn, $_POST["titulo"]);
        $autor = mysqli_real_escape_string($conn, $_POST["autor"]);
        $conteudo = mysqli_real_escape_string($conn, $_POST["conteudo"]);

        $sql = "INSERT INTO posts(titulo, autor, conteudo) VALUES ('$titulo', '$autor', '$conteudo')";

        if(mysqli_query($conn, $sql)){
            header('Location: main.php');
        } else {
            echo 'Erro de query: '.mysqli_error($conn);
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

<body>
    <section style="
        display: flex;
        justify-content: center;
        padding: 4rem 0;
        width: 100%;
    ">
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
            <article style="display: flex; flex-direction: column; width: 300px; justify-content: space-between;">
                <label for="autor">Autor</label>
                <input type="text" name="autor" id="autor" />
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
</body>

</html>