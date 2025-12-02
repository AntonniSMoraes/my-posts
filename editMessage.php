<?php
include("./connections/connect.php");

if(!isset($_SESSION["user_id"])){
    header("Location: login.php");
    exit();
} else {
    if (isset($_GET['id'])) {
        $id = mysqli_real_escape_string($conn, $_GET['id']);

        $sql = "SELECT * FROM posts WHERE ID = '$id'";
        $result = mysqli_query($conn, $sql);
        $post = mysqli_fetch_assoc($result);
    }

    if (isset($_POST["editar"])) {
        $id = intval(mysqli_real_escape_string($conn, $_POST["editar_id"]));
        $titulo = mysqli_real_escape_string($conn, $_POST["titulo"]);
        $conteudo = mysqli_real_escape_string( $conn, $_POST["conteudo"]);

        $sql = "UPDATE posts SET titulo='$titulo', conteudo='$conteudo' WHERE id = $id";

        if(mysqli_query($conn, $sql)){
            header("Location: editMessage.php?id=$id");
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
    <title>Editar</title>
</head>
<body style="margin: 0; padding: 0; width: 100vw; height: 100vh;">
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
            <h1>Editar</h1>

            <form action="/editMessage.php" method="POST" 
                style="
                    display: flex;
                    width: calc(80% - 2rem);
                    flex-direction: column;
                    align-items: flex-start;
                    background-color: gray;
                    padding: 1rem;
                    border-radius: 1rem;
                    color: white;
                    gap: 1rem;
            ">
                <input type="hidden" name="editar_id" value="<?= $id; ?>" />
                
                <input 
                    type="text" 
                    name="titulo" 
                    value="<?= $post['titulo'] ?>" 
                    style="
                        padding: .5rem;
                        border-radius: .5rem;
                        border: none;
                    "
                >
                <textarea 
                    name="conteudo"
                    style="
                        padding: 1rem;
                        border-radius: .5rem;
                        width: calc(100% - 2rem);
                        border: none;
                        min-height: 200px;
                    "
                >
                    <?=$post['conteudo'] ?>
                </textarea>
                <input type="submit" name="editar" value="editar" style="
                    display: flex;
                    align-self: flex-end;
                    border: none;
                    background-color: white;
                    padding: 10px 15px;
                "/>
            </form>
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