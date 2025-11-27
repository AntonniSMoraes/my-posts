<?php
include("conect.php");

if (isset($_POST['SignUp'])) {
    $username = mysqli_real_escape_string($conn, $_POST['nome']);
    $password = $_POST['senha'];

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO cadastro(nome, senha) VALUES ('$username', '$hashed_password')";

    if (mysqli_query($conn, $sql)) {
        header("Location: login.php");
        exit();
    } else {
        echo "Erro ao cadastrar usuário: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SignUp</title>
</head>

<body style="width: 100vw; height: 100vh; padding: 0; margin: 0;">
    <section style="
            display: flex;
            flex-direction: column;
            width: 100%;
            height: 100vh;
            margin: 0;
            align-items: center;
            justify-content: center;
            background-color: lightcyan;
        ">
        <form action="signup.php" method="post" style="
                display: flex;
                flex-direction: column;
                width: calc(20% - 40px);
                align-items: center;
                justify-content: center;
                background-color: darkcyan;
                border-radius: 1rem;
                padding: 20px;
                box-shadow: 5px 5px 10px rgba(0,0,0,0.1);
            ">
            <h2 style="text-align: center;">Sign Up</h2>
            <label for="nome">Username:</label>
            <input type="text" id="nome" name="nome" required style="
                padding: 10px;
                margin-bottom: 15px;
                border: 1px solid #ccc;
                border-radius: 5px;
            ">
            <label for="senha">Password:</label>
            <input type="password" id="senha" name="senha" required style="
                padding: 10px;
                margin-bottom: 15px;
                border: 1px solid #ccc;
                border-radius: 5px;
            ">
            <input type="submit" name="SignUp" value="Sign Up" style="
                padding: 10px;
                border: none;
                border-radius: 5px;
                background-color: darkslategray;
                color: white;
                cursor: pointer;
            ">
        </form>
    </section>
</body>

</html>