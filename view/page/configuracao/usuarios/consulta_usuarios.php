<div class="p-3 shadow">
    <span class="badge mb-3 text-bg-dark">Consulta de Usuários</span>
    <form action="" method="POST">

        <div class="row">
            <div class="col-md-2 mb-2">
                <select name="status" class="form-select" id="status">
                    <option value="sn">Status..</option>
                    <option <?php if ($status == "1") {
                                echo 'selected';
                            } ?> value="1">Ativo</option>
                    <option <?php if ($status == "0") {
                                echo 'selected';
                            } ?> value="0">Inativo</option>
                </select>
            </div>
            <div class="col-md  mb-2">
                <div class="input-group">
                    <input type="text" class="form-control" name="pesquisa_conteudo_user" value="<?php echo $conteudo_pesquisa; ?>" placeholder="Pesquise pelo nome de usuário ou pelo código" aria-label="Recipient's username" aria-describedby="button-addon2">
                    <button class="btn btn-outline-secondary" type="submit" id="pesquisar_filtro_pesquisa">Pesquisar</button>
                </div>
            </div>
            <div class="col-md-auto d-grid gap-2 d-sm-block mb-1">
                <a href="?pg&adduser" class="btn  btn-dark">Adicionar Usuário</a>
            </div>
        </div>
    </form>
    <div class="table-container">
        <table class="table  table-hover">
            <?php
            if ($qtd_operacao_select_user > 0) {
            ?>
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Usuário</th>
                        <th>Grupo</th>
                        <th>Ativo</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($linha = mysqli_fetch_assoc($operacao_select_user)) {
                        $cod_user = $linha['cod_user'];
                        $nome = $linha['nome'];
                        $grupouser = utf8_encode($linha['grupouser']);
                        $ativo = $linha['ativo'];
                        if ($ativo == 1) {
                            $ativo = "<span class='badge text-bg-success'>Sim</span>";
                        } else {
                            $ativo = "<span class='badge text-bg-danger'>Não</span>";
                        }
                    ?>
                        <tr>
                            <td><?php echo $cod_user; ?></td>
                            <td><?php echo $nome; ?></td>
                            <td><?php echo $grupouser; ?></td>
                            <td><?php echo $ativo; ?></td>
                            <td><a href="?pg&edituser&codigo=<?php echo $cod_user; ?>" class="btn btn-sm btn-info">Editar</a></td>
                            <td><a href="?pg&resetuser&codigo=<?php echo $cod_user; ?>" class="btn btn-sm btn-danger">Resetar senha</a></td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>

            <?php

            }
            ?>
        </table>
    </div>

</div>