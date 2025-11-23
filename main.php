<?php
include("conect.php");
$sql = 'SELECT * from posts';
$result = mysqli_query($conn, $sql);
$posts = mysqli_fetch_all($result, MYSQLI_ASSOC);
// print_r($posts);

$count = 0;

mysqli_free_result($result);
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>

<body>
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
                    <?php if($post['flag'] === '' || $post['flag'] === 'post'): ?>
                    <article style="margin-bottom: 1rem; padding:1rem; background:#334; border-radius: .5rem;">
                        <h2><?= $post['titulo'] ?></h2>
                        <article style="
                            display: flex;
                            justify-content: space-between;
                        ">
                            <p style="margin: 0;"><strong>User:</strong> <?= $post['autor'] ?></p>
                            <p style="margin: 0;"><?= $post['data'] ?></p>
                        </article>
                        <p style="
                            white-space: normal;
                            word-break: break-word;
                            overflow-wrap: break-word;
                        "><?= $post['conteudo'] ?></p>
                    </article>
                    <!-- <article>
                        <?php foreach ($posts as $coment): ?>
                            <?php if($post['id'] === $coment['id_flag']): ?>
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