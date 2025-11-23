<?php
$conn = mysqli_connect('localhost', 'root', '', 'chat');
if (!$conn) {
    echo 'Erro na conexão: ' . mysqli_connect_error();
}
?>
