<?php
if (isset($_GET['clt'])) {
    include "model/models/page/clientes.php";
    include "view/page/clientes/consulta_clientes.php";
} elseif (isset($_GET['user'])) {
    include "model/models/page/usuarios.php";
    include "view/page/configuracao/usuarios/consulta_usuarios.php";
} elseif (isset($_GET['adduser']) or isset($_GET['edituser'])) { //tela para  add e alterar usuario
    include "model/models/page/usuarios.php";
    include "view/page/configuracao/usuarios/tela_usuario.php";
} elseif (isset($_GET['resetuser'])) { //tela para resetar senha do usuario
    include "model/models/page/usuarios.php";
    include "view/page/configuracao/usuarios/resetar_senha.php";
} elseif (isset($_GET['clt'])) { //consulta cliente
    include "model/models/page/clientes.php";
    include "view/page/clientes/consulta_clientes.php";
} elseif (isset($_GET['addclt']) or isset($_GET['editclt'])) { //tela para  add e alterar cliente
    include "model/models/page/clientes.php";
    include "view/page/clientes/tela_clientes.php";
} elseif (isset($_GET['prd'])) { //consulta PRODUTOS
    include "model/models/page/produtos.php";
    include "view/page/produtos/consulta_produtos.php";
} elseif (isset($_GET['ajstest'])) { //ajuste de estoque
    include "model/models/page/produtos.php";
    include "view/page/produtos/ajuste_estoque_tela.php";
} elseif (isset($_GET['addprd']) or isset($_GET['editprd'])) { //tela para  add e alterar produto
    include "model/models/page/produtos.php";
    include "view/page/produtos/tela_produtos.php";
} elseif (isset($_GET['historprd'])) { //tela para consultar historico do produto
    include "model/models/page/produtos.php";
    include "view/page/produtos/historico.php";
} elseif (isset($_GET['lcf'])) { //consulta financeiro
    include "model/models/page/financeiro.php";
    include "view/page/financeiro/consulta_financeiro.php";
} elseif (isset($_GET['addlcf']) or isset($_GET['editlcf'])) { //tela para  add e alterar financeiro
    include "model/models/page/financeiro.php";
    include "view/page/financeiro/tela_financeiro.php";
} elseif (isset($_GET['log'])) { //consulta log
    include "model/models/page/log.php";
    include "view/page/configuracao/log_sistema/consulta_log.php";
} elseif (isset($_GET['fpg'])) { //consulta forma de pagamento
    include "model/models/page/forma_pagamento.php";
    include "view/page/forma_pagamento/consulta_fpg.php";
} elseif (isset($_GET['addfpg']) or isset($_GET['editfpg'])) { //consulta add e alterar forma de pagamento
    include "model/models/page/forma_pagamento.php";
    include "view/page/forma_pagamento/tela_fpg.php";
} elseif (isset($_GET['lcc'])) { //consulta locações
    include "model/models/page/locacao.php";
    include "view/page/locacao/consulta_locacao.php";
} elseif (isset($_GET['addlcc']) or isset($_GET['editlcc'])) { //tela para  add e alterar locações
    include "model/models/page/locacao.php";
    include "view/page/locacao/tela_locacao.php";
} elseif (isset($_GET['fechlcc'])) { //tela para  concluir locação
    include "model/models/page/locacao.php";
    include "view/page/locacao/tela_fechar_locacao.php";
} else {
    include "model/models/page/dashboard.php";
    include "view/page/dashboard/inicial.php";
}
