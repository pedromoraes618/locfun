<?php
$conteudo_pesquisa = null;
$status = null;
$qtd_consulta = 0;
$alert = null;
$alert_success = null;


/*iniciando variavel */
$descricao = null;
$preco = null;
$categoria = null;
$estoque = null;
$observacao = null;
$img_produto = null;

if (isset($_GET['historprd'])) {
    $codigo = $_GET['codigo'];

    /*consultar o historico */
    $select = "SELECT ajs.data_mov,ajs.id_mov,ajs.saida,ajs.entrada,ajs.preco_saida,ajs.preco_entrada,
ajs.status,ajs.serie_doc,prd.nome as produto
 from ajuste_estoque as ajs inner join produtos as prd on prd.id_prod = ajs.id_prod WHERE ajs.id_prod = '$codigo' ";
    $consulta_historico = mysqli_query($conecta, $select);
    if ($consulta_historico) { //verifica se ocorreu tudo ok
        $qtd_consulta_historico = mysqli_num_rows($consulta_historico);
    } else {
        die("erro na consulta:" . mysqli_error($conecta));
    }
}

if (isset($_POST['pesquisa_conteudo'])) { //pesquisar por filtro
    $conteudo_pesquisa = $_POST['pesquisa_conteudo'];
    $status = $_POST['status'];
    $select = "SELECT prd.img_produto,prd.id_prod,prd.nome as produto,prd.observacao,prd.qtd,prd.preco,prd.ativo,cat.nome as categoria from produtos as prd 
    inner join categorias as cat on cat.id = prd.id_cat
    where (prd.nome  like '%$conteudo_pesquisa%' or prd.id_prod like '%$conteudo_pesquisa%' )  ";
    if ($status != "sn") {
        $select .= " and prd.ativo ='$status'";
    }
    $select .= " order by prd.id_prod asc";
    $consulta = mysqli_query($conecta, $select);
    if ($consulta) { //verifica se ocorreu tudo ok
        $qtd_consulta = mysqli_num_rows($consulta);
    } else {
        die("erro na consulta:" . mysqli_error($conecta));
    }
} else { //pesquisa inicial
    $select = "SELECT prd.img_produto,prd.id_prod,prd.nome as produto,prd.observacao,prd.qtd,prd.preco,prd.ativo,cat.nome as categoria from produtos as prd 
    inner join categorias as cat on cat.id = prd.id_cat";
    $consulta = mysqli_query($conecta, $select);
    if ($consulta) { //verifica se ocorreu tudo ok
        $qtd_consulta = mysqli_num_rows($consulta);
    } else {
        die("erro na consulta:" . mysqli_error($conecta));
    }
}

/*acao de cadastro*/
if (isset($_GET['addprd'])) {
    $acao = "Cadastrar";
}
/*acao de editar*/
if (isset($_GET['editprd'])) {
    $acao = "Alterar";
    $codigo = $_GET['codigo'];

    $resultado_tb = consulta_linhas_tb_filtro($conecta, 'produtos', "id_prod", $codigo); //consultar  tabela do usuario
    if ($resultado_tb) {
        foreach ($resultado_tb as $linha) { //trazer as informações das colunas
            $cod_produto = $linha['id_prod'];
            $descricao = ($linha['nome']);
            $observacao = ($linha['observacao']);
            $estoque = ($linha['qtd']);
            $preco = ($linha['preco']);
            $status = ($linha['ativo']);
            $categoria = ($linha['id_cat']);
            $img_produto = ($linha['img_produto']);
        }
    }
}

if (isset($_POST['form_produto'])) {
    foreach ($_POST as $name => $value) { //define os valores das variaveis e os nomes com refencia do name do input no formulario
        ${$name} = ($value);
    }
    $img_produto = $_POST['diretorio_img'];

    if ($acao == 'Cadastrar') { //cadastrar o usuario
        if ($descricao == "") {
            $alert = msg_alert_required("descricao");
        } elseif ($categoria == "0") {
            $alert = msg_alert_required("categoria");
        } elseif ($status == "sn") {
            $alert = msg_alert_required("status");
        } else {
            $insert = "INSERT INTO produtos (`nome`, `observacao`, `qtd`, `preco`, `id_cat`, `ativo`, `img_produto`) 
            VALUES ( '$descricao', '$observacao', '0', '$preco', '$categoria', '$status','$img_produto' ) ";
            $operacao_insert = mysqli_query($conecta, $insert);
            if ($operacao_insert) {
                $novo_id_inserido = mysqli_insert_id($conecta); //pegar o id do produto
                $alert_success = "Produto cadastrado com sucesso";
                $acao_log = ("Usuário $usuario_logado cadastrou o novo produto, código $novo_id_inserido");
                registrar_log($conecta, $usuario_logado, $acao_log);

                foreach ($_POST as $name => $value) { //redefinir os valores
                    ${$name} = "";
                }
            } else {
                die(mysqli_error($conecta));
                $acao_log = ("Erro, ao realizar o cadastro do produto $descricao");
                registrar_log($conecta, $usuario_logado, $acao_log);
            }
        }
    } else { //editar o usuario
        if ($descricao == "") {
            $alert = msg_alert_required("descricao");
        } elseif ($categoria == "0") {
            $alert = msg_alert_required("categoria");
        } elseif ($status == "sn") {
            $alert = msg_alert_required("status");
        } else {
            $update = "UPDATE `produtos` SET `nome` = '$descricao',
             `observacao` = '$observacao', `preco` = '$preco', `id_cat` = '$categoria',
              `ativo` = '$status',`img_produto` = '$img_produto' WHERE `id_prod` = $codigo ";
            $operacao_update = mysqli_query($conecta, $update);
            if ($operacao_update) {
                $alert_success = "Produto alterado com sucesso";
                $acao_log = ("Usuário $usuario_logado alterou o produto de código $codigo");
                registrar_log($conecta, $usuario_logado, $acao_log);
            } else {
                die(mysqli_error($conecta));
                $acao_log = ("Erro, ao realizar alteração no produto de código $codigo");
                registrar_log($conecta, $usuario_logado, $acao_log);
            }
        }
    }
}

if (isset($_POST['upload_img'])) {
    foreach ($_POST as $name => $value) { //define os valores das variaveis e os nomes com refencia do name do input no formulario
        ${$name} = ($value);
    }
    //$codProduto = $_GET["codigo"];
    $formatosPermitidos = array("png", "PNG", "jpeg", "jpg", "gif");
    $extensao = pathinfo($_FILES['arquivo']['name'], PATHINFO_EXTENSION);

    if (in_array($extensao, $formatosPermitidos)) {
        $pasta = "static/img/produtos/";
        $temporario = $_FILES['arquivo']['tmp_name'];
        $novoNome = uniqid() . "." . $extensao;
        $nome = ($_FILES['arquivo']['name']);

        if (move_uploaded_file($temporario, $pasta . $novoNome)) {
            //incliur no banco de dados
            //anexarArquivoImg($novoNome, $pasta, $codProduto);
            $alert_success = "Uplop efetuado com sucesso";
            $img_produto = $pasta . $novoNome;
        } else {
            $alert = "Não foi possivel fazer o Upload";
        }
    } else {
        $alert = "Arquivo com formato invalido";
    }
}
