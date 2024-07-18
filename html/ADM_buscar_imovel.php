<?php

    session_start();

    if (!isset($_SESSION['id_ADM'])) 
    {
        header("Location: ADM_login.php");
    }

    $conexao = new mysqli("127.0.0.1", 
                    "root", 
                    "", 
                    "easyhouse");

    if(isset($_GET["localizar"])) 
    {
        $localizar = $_GET["localizar"];
        
        $sql = "SELECT * FROM imovel WHERE cidade LIKE '%$localizar%'
        OR estado LIKE '%$localizar%'
        OR endereco LIKE '%$localizar%'
        OR situacao LIKE '%$localizar%'";
    } 
    else 
    {
        $sql = "SELECT * FROM imovel WHERE";
    }

    $resultado = $conexao->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anúncios</title>
    <link rel="stylesheet" href="../styles/style.css">
    <link rel="stylesheet" href="../styles/meusImoveis.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body>
    <section class="anunciar__container">
        <h1>Anúncios Feitos</h1> </BR>
    </section>

        <section>
            <form class="example" action="buscar_meu_imovel.php" method ="GET">
                <div class="botao__de__busca"> 
                    <input type="text" name = "localizar" placeholder="Procurar...">
                    <button type="submit"><i class="fa fa-search"></i></button>
                </div>
            </form>
        </section> <br/>

        <div class=>
            <table class="anuncio__container">
                <tbody>
                    <?php
                        while($linha = $resultado->fetch_assoc()) 
                        {
                        ?>
                            <tr class="anuncio__tabela">
                                <td>
                                    <img class="anuncio__imagem" src="<?php echo $linha['pathImagem']; ?>">
                                </td>
                                <td>
                                    <?php echo $linha["cidade"] . ", " . $linha["estado"]; ?> <br>
                                    <?php echo $linha["endereco"] . ", " . $linha["numero"]; ?> <br>
                                    <?php echo wordwrap($linha["descricao"], 50, "<br>\n"); ?> <br>
                                    <div class="anuncio__valor">
                                        <?php 
                                        $valor_formatado = number_format($linha["valor"], 2, ',', '.');
                                        echo "R$ $valor_formatado"; 
                                        ?>
                                    </div>
                                    <?php echo $linha["situacao"]; ?>
                                    <div class="anuncio__contato">
                                        <?php echo $linha["contato"]; ?><br>
                                    </div> 
                                    <a href="ADM_alterar_imovel.php?id=<?php echo $linha['id']; ?>" class = "botao__editar">✏️</a>
                                    <a href="ADM_excluir_imovel.php?id=<?php echo $linha['id']; ?>" class = "botao__excluir">🗑️</a>
                                    
                                </td>
                            </tr>
                    <?php 
                        }
                    ?>

                </tbody>   
            </table>
    </div>
    <div class = "botao__voltar__adm" >
        <a class = "botao__voltar__adm2" href="ADM_visualizar_imoveis.php">Voltar</a>
    </div>
</body>
</html>