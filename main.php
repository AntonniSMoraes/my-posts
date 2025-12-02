<?php
include("./connections/connect.php");
    if(!isset($_SESSION["user_id"])){
        header("Location: login.php");
        exit();
    } else {
        $sql = 'SELECT * from posts';
        $result = mysqli_query($conn, $sql);
        $posts = mysqli_fetch_all($result, MYSQLI_ASSOC);
        // print_r($posts);
        
        $count = 0;
        
        mysqli_free_result($result);
        mysqli_close($conn);
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>

<body style="margin: 0; padding: 0; width: 100vw; height: 100vh;">
    
    <?php 
        include("./components/header.php");
    ?>

    <section style="
            display: flex;
            flex-direction: column;
            width: 100%;
            align-items: center;
        ">
        <h1>Posts</h1>
        <article style="
                display: flex;
                width: 50%;
                flex-direction: column;
                gap: 1rem;
                background-color: lightgray;
                padding: 1rem;
                border-radius: 1rem;
                color: white;
            ">
            <article>
                <?php foreach ($posts as $post): ?>
                    <?php if ($post['flag'] === '' || $post['flag'] === 'post'): ?>

                        <article style="
                                margin-bottom: 1rem;
                                padding:1rem;
                                <?php 
                                    if($_SESSION['nome'] === $post['autor']){
                                        echo 'background: darkcyan;';
                                    }else {
                                        echo 'background:#334;';
                                    }
                                ?>
                                border-radius: .5rem;
                        ">
                            <article style="
                                display: flex;
                                justify-content: space-between;
                                align-items: center;
                            ">
                                <h2><?= $post['titulo'] ?></h2>
                                <div>
                                    <?php if ($_SESSION["nome"] == $post["autor"] || $_SESSION["user_id"] == 6) { ?>
                                            <a href="/editMessage.php?id=<?= $post['ID'] ?>">
                                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#fff">
                                                    <path d="M200-200h57l391-391-57-57-391 391v57Zm-80 80v-170l528-527q12-11 26.5-17t30.5-6q16 0 31 6t26 18l55 56q12 11 17.5 26t5.5 30q0 16-5.5 30.5T817-647L290-120H120Zm640-584-56-56 56 56Zm-141 85-28-29 57 57-29-28Z"/>
                                                </svg>
                                            </a>
                                    <?php } ?>

                                    <a href="/post.php?id=<?= $post['ID'] ?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#fff"><path d="M504-480 320-664l56-56 240 240-240 240-56-56 184-184Z"/></svg>
                                    </a>
                                </div>
                            </article>

                            <article style="
                                display: flex;
                                justify-content: space-between;
                            ">
                                <p style="margin: 0;"><strong>User:</strong> <?= $post['autor'] ?></p>
                                <p style="margin: 0;"><?= $post['data'] ?></p>
                            </article>
                        </article>
                        <?php
                        if (count($posts) > 1) {
                            echo '<hr style="color: white;"/>';
                        }
                        ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            </article>
            <a style="
                display: flex;
                width: 40px;
                height: 40px;
                align-items: center;
                justify-content: center;
                border: none;
                background-color: white;
                align-self: flex-end;
                border-radius: .8rem;
                cursor: pointer;
            " href="/new.php">
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                    fill="#1f1f1f">
                    <path d="M440-440H200v-80h240v-240h80v240h240v80H520v240h-80v-240Z" />
                </svg>
            </a>
        </article>
    </section>

    <?php 
        include("./components/footer.php");
    ?>

</body>

</html>