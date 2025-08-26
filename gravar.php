<?php 
    session_start();
    $dados = $_SESSION['pessoas'];
    $conteudo = json_encode($dados, );
    file_put_contents("pessoas.json",$conteudo);
    header("Location: index.php");
?>