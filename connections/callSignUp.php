<?php
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