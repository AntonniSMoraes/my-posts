<?php
include("conect.php");

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if(!isset($_SESSION["user_id"])){
    header("Location: login.php");
    exit();
} else {
    if (isset($_GET['id'])) {
        $id = mysqli_real_escape_string($conn, $_GET['id']);

        $sql = "SELECT * FROM posts WHERE ID = '$id'";
        $result = mysqli_query($conn, $sql);
        $post = mysqli_fetch_assoc($result);


        $comments_sql = "SELECT * FROM posts WHERE flag = 'coment' AND id_flag = '$id'";
        $comments_result = mysqli_query($conn, $comments_sql);
        $comments = mysqli_fetch_all($comments_result, MYSQLI_ASSOC);

    }

    if (isset($_POST["enviar"])) {
        $id = mysqli_real_escape_string($conn, $_GET['id']);

        $titulo = mysqli_real_escape_string($conn, $_POST["titulo"]);
        $autor = mysqli_real_escape_string($conn, $_POST["autor"]);
        $conteudo = mysqli_real_escape_string($conn, $_POST["conteudo"]);

        $sql = "INSERT INTO posts(titulo, autor, conteudo, flag, id_flag) VALUES ('$titulo', '$autor', '$conteudo', 'coment', '$id')";

        if (mysqli_query($conn, $sql)) {
            header('Location: post.php?id=' . $id);
        } else {
            echo 'Erro de query: ' . mysqli_error($conn);
        }
    }


    mysqli_free_result($result);
    mysqli_free_result($comments_result);
    mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $post['titulo'] ?></title>
</head>

<body>
    <?php
    if ($post) {
        ?>
        <section style="display: flex; flex-direction: column; width: 100%; align-items: center;">
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
            <article style="
                    display: flex;
                    width: calc(80% - 2rem);
                    flex-direction: column;
                    align-items: flex-start;
                    background-color: gray;
                    padding: 1rem;
                    border-radius: 1rem;
                    color: white;
                    gap: 1rem;">
                <h1 style="margin: 0;"><?= $post['titulo'] ?></h1>
                <article style="
                        display: flex;
                        justify-content: space-between;
                        width: 100%;
                    ">
                    <p style="margin: 0;">
                        <strong>Autor:</strong> <?= $post['autor'] ?>
                    </p>
                    <p style="margin: 0;">
                        <strong>Data:</strong> <?= $post['data'] ?>
                    </p>

                </article>
                <article style="
                        background-color: darkblue;
                        padding: 1rem;
                        border-radius: .5rem;
                        width: calc(100% - 2rem);
                    ">
                    <p><?= $post['conteudo'] ?></p>
                </article>
                <article style="width: 100%; flex-direction: column;">
                    <h2>Comentários</h2>
                    <?php if (count($comments) > 0): ?>
                        <?php foreach ($comments as $comment): ?>
                            <article style="
                                    <?php 
                                        if($_SESSION['nome'] === $comment['autor']){
                                            echo 'background: darkcyan;';
                                        }else {
                                            echo 'background:darkgray;';
                                        }
                                    ?>
                                    padding: .5rem;
                                    border-radius: .5rem;
                                    margin-bottom: .5rem;
                                ">
                                <article style="
                                        display: flex;
                                        justify-content: space-between;
                                    ">
                                    <p style="margin: 0;">
                                        <strong>Autor:</strong> <?= $comment['autor'] ?>
                                    </p>
                                    <p style="margin: 0;">
                                        <strong>Data:</strong> <?= $comment['data'] ?>
                                    </p>
                                </article>
                                <p><?= $comment['conteudo'] ?></p>
                            </article>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>Nenhum comentário encontrado.</p>
                    <?php endif; ?>
                    <article style="display: flex; with: 100%; flex-direction: column;">
                        <h2>Adicionar Comentário</h2>
                        <form action="post.php?id=<?= $id ?>" method="POST"
                            style="
                                display: flex;
                                flex-direction: column;
                                width: calc(100% - 2rem);
                                border-radius: .5rem;
                                padding: 1rem;
                                gap: 1rem;
                                align-items: flex-start;
                                background-color: darkslategrey;
                                color: white;
                            "
                        >
                            <article
                                style="display: flex; flex-direction: column; width: 300px; justify-content: space-between;">
                                <label for="titulo">Título</label>
                                <input type="text" name="titulo" id="titulo" />
                            </article>

                            <article
                                style="display: flex; flex-direction: column; width: 300px; justify-content: space-between;">
                                <label for="autor">Autor</label>
                                <input type="text" name="autor" id="autor" />
                            </article>
                            
                            <article
                                style="display: flex; flex-direction: column; width: 100%; justify-content: space-between;">
                                <label for="conteudo">Conteúdo</label>
                                <textarea name="conteudo" id="conteudo" rows="5" cols="40"></textarea>
                            </article>

                            <input type="submit" name="enviar" value="enviar" style="
                                display: flex;
                                align-self: flex-end;
                                border: none;
                                background-color: white;
                                padding: 10px 15px;
                            " />
                        </form>
                    </article>
                </article>
            </article>
        </section>
        <?php
    } else {
        echo "<p>Post não encontrado.</p>";
    }
    ?>
</body>

</html>