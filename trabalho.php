<?php
        session_start();
        if (!isset($_SESSION['pessoas'])){
            $_SESSION['pessoas'] = [];
        }
        if (empty($_SESSION['pessoas'])){
            $dados = json_decode(file_get_contents("pessoas.json"), true);
            $_SESSION['pessoas'] = $dados;
        }
        $id_edicao = null;
        $nome_edicao = '';
        $livro_edicao = '';
        $gen_edicao = ['Romance','Suspense','Drama','Comedia','Aventura','Fantasia','Ficcão','poesia','cordel','quadreinhos','manga'];
        $nota_edicao = '';
        $modo_edicao = false;
        //coração do CRUD
        //DELETE via GET
        if (isset($_GET['acao']) && $_GET['acao'] == 'deletar' && isset($_GET['id'])) {
            $id_para_deletar = $_GET['id'];
            foreach ($_SESSION['pessoas'] as $indice => $pessoa) {
                if ($pessoa['id'] == $id_para_deletar) {
                    unset($_SESSION['pessoas'][$indice]);
                    break;
                }
            }
            header('Location: index.php');
            exit;
        }
    ?>