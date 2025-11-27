<?php
include("conect.php");

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

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

<body style="margin: 0; padding: 0; width: 100vw;">
    <header style="
        display: flex;
        width: calc(100% - 2rem);
        background-color: lightgray;
        padding: 1rem;
    ">
        <a href="/main.php" style="
            display: flex;
            width: 40px;
            height: 40px;
            border-radius: 100%;
            justify-content: center;
            align-items: center;
            background-color: darkcyan;
        ">
            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#fff"><path d="M480-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47ZM160-160v-112q0-34 17.5-62.5T224-378q62-31 126-46.5T480-440q66 0 130 15.5T736-378q29 15 46.5 43.5T800-272v112H160Zm80-80h480v-32q0-11-5.5-20T700-306q-54-27-109-40.5T480-360q-56 0-111 13.5T260-306q-9 5-14.5 14t-5.5 20v32Zm240-320q33 0 56.5-23.5T560-640q0-33-23.5-56.5T480-720q-33 0-56.5 23.5T400-640q0 33 23.5 56.5T480-560Zm0-80Zm0 400Z"/></svg>
        </a>
    </header>
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
                                <a href="/post.php?id=<?= $post['ID'] ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#fff"><path d="M504-480 320-664l56-56 240 240-240 240-56-56 184-184Z"/></svg>
                                </a>
                            </article>

                            <article style="
                                display: flex;
                                justify-content: space-between;
                            ">
                                <p style="margin: 0;"><strong>User:</strong> <?= $post['autor'] ?></p>
                                <p style="margin: 0;"><?= $post['data'] ?></p>
                            </article>
<!--                             
                            <p style="
                                white-space: normal;
                                word-break: break-word;
                                overflow-wrap: break-word;
                            ">
                                <?= $post['conteudo'] ?>
                            </p> -->
                        </article>
                        <!-- <article>
                        <?php foreach ($posts as $coment): ?>
                            <?php if ($post['id'] === $coment['id_flag']): ?>
                                $count+=1;
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </article> -->
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
</body>

</html>