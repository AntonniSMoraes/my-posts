<?php
include("./connections/connect.php");

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
} else {
    $user = intval($_SESSION["user_id"]);
    $sql = "SELECT * FROM posts WHERE user_id = $user";
    $result = mysqli_query($conn, $sql);
    $posts = mysqli_fetch_all($result, MYSQLI_ASSOC);

}

if(isset($_POST["excluir"])) {
    $id = mysqli_escape_string($conn, $_POST["excluir_id"]);
    $sql = "DELETE FROM posts WHERE ID=$id";

    if(mysqli_query($conn, $sql)) {
        header('Location: profile.php');
    }else {
        echo 'Erro de query: '.mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
</head>

<body style="margin: 0; padding: 0;">

    <?php
    include("./components/header.php");
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
        <h1>Posts</h1>
        <article style="
                display: flex;
                width: 80%;
                flex-direction: column;
                background-color: #36454F;
                padding: 1rem;
                border-radius: 1rem;
                color: white;   
            ">
            <?php foreach ($posts as $post) : ?>
                <?php if($post['flag']!= 'coment'): ?>
                    <article>
                        <div style="
                                display: flex;
                                justify-content: space-between;
                            ">
                            <p><?= $post['titulo'] ?></p>
                            <div style="display: flex; align-items: center; gap: 1rem;">
                                <p><?= $post['data'] ?></p>
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
                        <p><?= $post['conteudo'] ?></p>
                    </article>
                    <?php
                    if (count($posts) > 1) {
                        echo '<hr style="color: white; width: 100%;"/>';
                    }
                    ?>
                <?php endif; ?>
            <?php endforeach; ?>
        </article>

        <h1>Comentários</h1>
        <article style="
                display: flex;
                width: 80%;
                flex-direction: column;
                background-color: #36454F;
                padding: 1rem;
                border-radius: 1rem;
                color: white;   
            ">
            <?php foreach ($posts as $post) : ?>
                <?php if($post['flag'] == 'coment'): ?>
                    <article>
                        <div style="
                                display: flex;
                                justify-content: space-between;
                            ">
                            <p><?= $post['titulo'] ?></p>
                            <div style="display: flex; align-items: center; gap: 1rem;">
                                <p><?= $post['data'] ?></p>
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
                        <p><?= $post['conteudo'] ?></p>
                    </article>
                    <?php
                    if (count($posts) > 1) {
                        echo '<hr style="color: white; width: 100%;"/>';
                    }
                    ?>
                <?php endif; ?>
            <?php endforeach; ?>
        </article>
    </section>
    <?php
    ?>

    <?php
    include("./components/footer.php");
    ?>
</body>

</html>