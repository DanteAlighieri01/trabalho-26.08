<?php 
    session_start();
    $dados = $_SESSION['pessoas.json'];
    $conteudo = json_encode($dados, JSON_PRETTY_PRINT);
    file_put_contents("pessoas.json",$conteudo);
    header("Localition: index.php");
    
?>