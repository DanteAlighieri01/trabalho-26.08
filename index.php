<?php
        session_start();
        if (!isset($_SESSION['pessoas'])){
            $_SESSION['pessoas'] = [];
        }
        if (empty($_SESSION['pessoas'])){
            $dados =json_decode(file_get_contents("pessoas.json"),true);
            $_SESSION['pessoas'] = $dados;
        }
        $id_edicao = null;
        $nome_edicao = '';
        $livro_edicao = '';
        $gen_edicao = ['Romance','Suspense','Drama','Comedia','Aventura','Fantasia','Ficção','poesia','cordel','quadrinhos','manga'];
        $nota_edicao = [1,2,3,4,5,6,7,8,9,10];
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
        //Preparar a edição
    if (isset($_GET['acao']) && $_GET['acao'] == 'editar' && isset($_GET['id'])) {
        $id_para_editar = $_GET['id'];
        foreach ($_SESSION['pessoas'] as $pessoa) {
            if ($pessoa['id'] == $id_para_editar) {
                $id_edicao = $pessoa['id'];
                $nome_edicao = $pessoa['nome'];
                $livro_edicao = $pessoa['livro'];
                $gen_edicao = $pessoa['genero'];
                $nota_edicao = $pessoa['nota'];
                $modo_edicao = true; //ativa a edicao no form
                break;
            }
        }
    }
      //criar e atualizar via POST
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nome = $_POST['nome'];
        $livro = $_POST['livro'];
        $gen = $_POST['genero'];
        $nota = $_POST['nota'];
        //atualizar
        if (isset($_POST['id']) && !empty($_POST['id'])) {
            $id_para_atualizar = $_POST['id'];
            foreach ($_SESSION['pessoas'] as $indice => $pessoa) {
                if ($pessoa['id'] == $id_para_atualizar) {
                    $_SESSION['pessoas'][$indice]['nome'] = $nome;
                    $_SESSION['pessoas'][$indice]['livro'] = $livro;
                    $_SESSION['pessoas'][$indice]['genero'] = $gen;
                    $_SESSION['pessoas'][$indice]['nota'] = $nota;
                 
                    break;
                
                }
            }
        }
        //criar
        else {
            $nova_pessoa = [
                'id' => uniqid(),
                'nome' => $nome,
                'livro' => $livro,
                'genero' => $gen,
                'nota' => $nota
            ];
            $_SESSION['pessoas'][] = $nova_pessoa;
        }
        header('Location: index.php');
        exit;
    }
?>
            <title>CRUD - PHP/Array</title>
            <style>
                body { font-family: Arial, sans-serif; margin: 20px; color: #ffffffff;}    
                body {background-color: #181515ff;}
                h1, h2 {color: #d3d3d3ff; }
                .container { max-width: 900px; margin: 20px; }
                form { margin-bottom: 60px; padding: 20px; border: 1px solid #ffffffff; border-radius: 10px; } 
                label { display: block; margin-bottom: 20px; }
                input[type="text"], input[type="text"] { width: calc(100% - 20px); padding: 8px; border: 4px solid #ccc; border-radius: 3px; }
                button { padding: 20px 25px; background-color: #1000f7ff; color: white; border: none; border-radius: 3px; cursor: pointer; }
                button.update { background-color: #3008e2ff; }
                table {width: 100%; border-collapse: separate;border-spacing: 10px;border-radius: 10px; border: 1px solid #ffffff; }
                th, td { border: 1px solid #fdfafaff; padding: 20px; text-align: left;margin: 50px;}
                th { background-color: #181515ff; }
                a { color: #00fa00ff; text-decoration: none; }
                a.delete { color: #da1010ff; margin-left: 10px; }
            </style>
              <img src="https://lirp.cdn-website.com/388815c9/dms3rep/multi/opt/logo-clube-de-leitura-SOMBRA-640w.png" alt="" style = "position relative;bottom: 30px; marin-bottom: 60px;float: right;" />
        </head>
        <body>
            <div class="container">
                <h1>CADASTRO DO CLUBE</h1>
                <form action="index.php" method="POST">
                    <input type="hidden" name="id" value="<?php echo $id_edicao; ?>">
                    <div>
                        <label for="nome">Nome:</label>
                        <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($nome_edicao); ?>" required>
                    </div>
                    <div>
                        <label for="livro">livro:</label>
                        <input type="text" id="livro" name="livro" value="<?php echo htmlspecialchars($livro_edicao); ?>" required>
                    </div>
                         <label>Gênero?</a>
                <select name="genero">
                     <option value="Romance">Romance</option>
                     <option value="Drama">Drama</option>
                     <option value="Suspense">Suspense</option>
                     <option value="Comedia">Comedia</option>
                     <option value="Aventura">Aventura</option>
                     <option value="Ficção">Ficção</option>
                     <option value="Poesia">Poesia</option>
                     <option value="Cordel">Cordel</option>
                     <option value="Quadrinho">Quadrinho</option>
                     <option value="Manga">Manga</option>
                     
                    </select>
                    <div>
                        <label>Nota</a>
                     <select name="nota">
                     <option value="0">0</option>
                     <option value="1">1</option>
                     <option value="2">2</option>
                     <option value="3">3</option>
                     <option value="4">4</option>
                     <option value="5">5</option>
                     <option value="6">6</option>
                     <option value="7">7</option>
                     <option value="8">8</option>
                     <option value="9">9</option>
                     <option value="10">10</option>
                        </div>
                    </select>
                      <div>
                        <?php if ($modo_edicao): ?>
                            <button type="submit" class="update">Atualizar pessoa</button>
                            </div>
                    </div>
                        <?php else: ?>
                        </div>
                    </div>
                            <button type="submit">Adicionar pessoa e livro</button>
                        <?php endif; ?>
                    </div>
                </form>
                <a href="gravar.php">Gravar dados...</a>
                <h2>Pessoas E Livros Cadastrados</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Livro</th>
                            <th>Genero</th>
                            <th>Nota</th>
                            <th>Editar/Excluir</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($_SESSION['pessoas'])): ?>
                            <tr>
                                <td colspan="4">Nenhuma pessoa cadastrada!</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($_SESSION['pessoas'] as $pessoa): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($pessoa['nome']); ?></td>
                                    <td><?php echo htmlspecialchars($pessoa['livro']); ?></td>
                                    <td><?php echo htmlspecialchars($pessoa['genero']); ?></td>
                                    <td><?php echo htmlspecialchars($pessoa['nota']); ?></td>
                                    <td>
                                        <a href="index.php?acao=editar&id=<?php echo $pessoa['id']; ?>">Editar</a>
                                        <a href="index.php?acao=deletar&id=<?php echo $pessoa['id']; ?>" class="delete" onclick="return confirm('Tem certeza que deseja excluir esta pessoa?');">Excluir</a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </body>
    </html>