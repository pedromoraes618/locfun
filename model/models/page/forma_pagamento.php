<?php
$conteudo_pesquisa = null;
$status = null;
$qtd_consulta = 0;
$alert = null;
$alert_success = null;


/*iniciando variavel */
$descricao = null;
$ativo = null;



if (isset($_POST['pesquisa_conteudo'])) { //pesquisar por filtro
    $conteudo_pesquisa = $_POST['pesquisa_conteudo'];
    $status = $_POST['status'];
    $select = "SELECT  * from forma_pg where  (nome_pg  like '%$conteudo_pesquisa%' or id_pg like '%$conteudo_pesquisa%')  ";
    if ($status != "sn") {
        $select .= " and ativo ='$status'";
    }
    $consulta = mysqli_query($conecta, $select);
    if ($consulta) { //verifica se ocorreu tudo ok
        $qtd_consulta = mysqli_num_rows($consulta);
    } else {
        die("erro na consulta:" . mysqli_error($conecta));
    }
} else { //pesquisa inicial
    $select = "SELECT * from forma_pg ";
    $consulta = mysqli_query($conecta, $select);
    if ($consulta) { //verifica se ocorreu tudo ok
        $qtd_consulta = mysqli_num_rows($consulta);
    } else {
        die("erro na consulta:" . mysqli_error($conecta));
    }
}

/*acao de cadastro*/
if (isset($_GET['addfpg'])) {
    $acao = "Cadastrar";
}
/*acao de editar*/
if (isset($_GET['editfpg'])) {
    $acao = "Alterar";
    $codigo = $_GET['codigo'];

    $resultado_tb = consulta_linhas_tb_filtro($conecta, 'forma_pg', "id_pg", $codigo); //consultar  tabela do usuario
    if ($resultado_tb) {
        foreach ($resultado_tb as $linha) { //trazer as informações das colunas
            $cod_fpg = $linha['id_pg'];
            $descricao = ($linha['nome_pg']);
            $status = ($linha['ativo']);
        }
    }
}

if (isset($_POST['form_fpg'])) {
    foreach ($_POST as $name => $value) { //define os valores das variaveis e os nomes com refencia do name do input no formulario
        ${$name} = ($value);
    }

    if ($acao == 'Cadastrar') { //cadastrar o usuario
        if ($descricao == "") {
            $alert = msg_alert_required("descricao");
        } elseif ($status == "sn") {
            $alert = msg_alert_required("status");
        } else {
            $insert = "INSERT INTO forma_pg (`nome_pg`, `ativo`) 
            VALUES ( '$descricao', '$status') ";
            $operacao_insert = mysqli_query($conecta, $insert);
            if ($operacao_insert) {
                $novo_id_inserido = mysqli_insert_id($conecta); //pegar o id do produto
                $alert_success = "Forma de pagamento cadastrada com sucesso";
                $acao_log = ("Usuário $usuario_logado cadastrou a forma de pagamento, código $novo_id_inserido");
                registrar_log($conecta, $usuario_logado, $acao_log);

                foreach ($_POST as $name => $value) { //redefinir os valores
                    ${$name} = "";
                }
            } else {
                die(mysqli_error($conecta));
                $acao_log = ("Erro, ao realizar o cadastro da forma de pgamento $descricao");
                registrar_log($conecta, $usuario_logado, $acao_log);
            }
        }
    } else { //editar o usuario
        if ($descricao == "") {
            $alert = msg_alert_required("descricao");
        } elseif ($status == "sn") {
            $alert = msg_alert_required("status");
        } else {
            $update = "UPDATE `forma_pg` SET `nome_pg` = '$descricao',
             `ativo` = '$status' WHERE `id_pg` = $codigo ";
            $operacao_update = mysqli_query($conecta, $update);
            if ($operacao_update) {
                $alert_success = "Forma de pagamento alterada com sucesso";
                $acao_log = ("Usuário $usuario_logado alterou a forma de pagamento de código $codigo");
                registrar_log($conecta, $usuario_logado, $acao_log);
            } else {
                die(mysqli_error($conecta));
                $acao_log = ("Erro, ao realizar alteração na forma de pagamento de código $codigo");
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
