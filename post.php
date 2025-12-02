<?php
include("./connections/connect.php");

ini_set('display_errors', 1);
error_reporting(E_ALL);
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
        $userId = intval($_SESSION['user_id']);
        $titulo = mysqli_real_escape_string($conn, $_POST["titulo"]);
        $autor = $_SESSION["nome"];
        $conteudo = mysqli_real_escape_string($conn, $_POST["conteudo"]);

        $sql = "INSERT INTO posts(titulo, user_id, autor, conteudo, flag, id_flag) VALUES ('$titulo', '$userId', '$autor', '$conteudo', 'coment', '$id')";

        if (mysqli_query($conn, $sql)) {
            header('Location: post.php?id=' . $id);
        } else {
            echo 'Erro de query: ' . mysqli_error($conn);
        }
    }

    if(isset($_POST["excluir"])) {
    $id = mysqli_escape_string($conn, $_POST["excluir_id"]);
    $sql = "DELETE FROM posts WHERE ID=$id";

    if(mysqli_query($conn, $sql)) {
        header('Location: main.php');
    }else {
        echo 'Erro de query: '.mysqli_error($conn);
    }
    }
}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post <?= $post['ID'] ?></title>
</head>

<body style="margin: 0; padding: 0;">

    <?php 
        include("./components/header.php");
    ?>

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
                    gap: 1rem;"
            >
                <div style="display: flex; align-items: center; justify-content: space-between; width: 100%;">
                    <h1 style="margin: 0;"><?= $post['titulo'] ?></h1>
                    <div style="display: flex; gap:1rem;">
                        <?php if ($_SESSION["nome"] == $post["autor"] || $_SESSION["user_id"] == 6) { ?>
                            <a href="/editMessage.php?id=<?= $post['ID'] ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#fff">
                                    <path d="M200-200h57l391-391-57-57-391 391v57Zm-80 80v-170l528-527q12-11 26.5-17t30.5-6q16 0 31 6t26 18l55 56q12 11 17.5 26t5.5 30q0 16-5.5 30.5T817-647L290-120H120Zm640-584-56-56 56 56Zm-141 85-28-29 57 57-29-28Z"/>
                                </svg>
                            </a>
                            <form method="POST">
                                <input type="hidden" name="excluir_id" value="<?= $post["ID"]; ?>" />
                                <button type="submit" name="excluir" style="
                                    display: flex;
                                    background-color: transparent;
                                    border: none;
                                    margin-bottom: -10px;
                                    cursor: pointer;
                                ">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#fff"><path d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z"/></svg>
                                </button>
                            </form>
                        <?php } ?>
                    </div>
                </div>
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
                                    <div style="display: flex; gap: 1rem;">
                                        <p style="margin: 0;">
                                            <strong>Data:</strong> <?= $comment['data'] ?>
                                        </p> 
                                        <div style="display: flex; gap:1rem;">
                                            <?php if ($_SESSION["nome"] == $post["autor"] || $_SESSION["user_id"] == 6) { ?>
                                                <a href="/editMessage.php?id=<?= $comment['ID'] ?>">
                                                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#fff">
                                                        <path d="M200-200h57l391-391-57-57-391 391v57Zm-80 80v-170l528-527q12-11 26.5-17t30.5-6q16 0 31 6t26 18l55 56q12 11 17.5 26t5.5 30q0 16-5.5 30.5T817-647L290-120H120Zm640-584-56-56 56 56Zm-141 85-28-29 57 57-29-28Z"/>
                                                    </svg>
                                                </a>
                                                <form method="POST">
                                                    <input type="hidden" name="excluir_id" value="<?= $post["ID"]; ?>" />
                                                    <button type="submit" name="excluir" style="
                                                        display: flex;
                                                        background-color: transparent;
                                                        border: none;
                                                        margin-bottom: -10px;
                                                        cursor: pointer;
                                                    ">
                                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#fff"><path d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z"/></svg>
                                                    </button>
                                                </form>
                                            <?php } ?>
                                        </div>
                                    </div>
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

    <?php 
        include("./components/footer.php");
    ?>
</body>

</html>