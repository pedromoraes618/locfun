<?php
if (isset($_POST['gerenciar_loc'])) {
    include "../../../conexao/conexao.php";
    include "../../../funcao/funcao.php";

    $retornar = array();
    $acao = $_POST['acao'];

    if ($acao == "delete_item") { // EDITAR
        $retornar["dados"] = array("sucesso" => true, "title" => "Item removido com sucesso");

        $id = $_POST['id'];
        $codigo_loc = consulta_tabela($conecta, "itens_locados", "id_item", $id, "cod_locacao");

        $delete = "DELETE FROM `itens_locados` WHERE `id_item` = $id ";
        $operacao_delete = mysqli_query($conecta, $delete);
        if ($operacao_delete) {
            recalcula_valor_locacao($conecta, $codigo_loc);
            $retornar["dados"] = array("sucesso" => true, "title" => "Item removido com sucesso");
        } else {
            $retornar["dados"] = array("sucesso" => false, "title" => "Erro");
        }
    }
    echo json_encode($retornar);
}
