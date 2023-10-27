<div class="p-3 shadow">
    <span class="badge mb-3 text-bg-dark">Consulta de Cliente/Fornecedores</span>
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
                    <input type="text" class="form-control" name="pesquisa_conteudo" value="<?php echo $conteudo_pesquisa; ?>" placeholder="Pesquise pelo nome de cliente ou cnpj/cpf" aria-label="Recipient's username" aria-describedby="button-addon2">
                    <button class="btn btn-outline-secondary" type="submit" id="pesquisar_filtro_pesquisa">Pesquisar</button>
                </div>
            </div>
            <div class="col-md-auto d-grid gap-2 d-sm-block mb-1">
                <a href="?pg&addclt" class="btn  btn-dark">Adicionar Cliente</a>
            </div>
        </div>
    </form>
    <div class="table-container">
        <table class="table  table-hover">
            <?php
            if ($qtd_consulta_clientes > 0) {
            ?>
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Nome</th>
                        <th>Cpf/Cnpj</th>
                        <th>Tipo</th>
                        <th>Bairro</th>
                        <th>Ativo</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($linha = mysqli_fetch_assoc($consulta_clientes)) {
                        $cod_cliente = $linha['id_cliente'];
                        $nome = ($linha['nome']);
                        $fisica_juridica = ($linha['fisica_juridica']);
                        $bairro = ($linha['bairro']);
                        $tipo = ($linha['tipo']);
                        $ativo = $linha['ativo'];
                        if ($tipo == "f") {
                            $CpfCnpj =   $linha['cpf'];
                        } else {
                            $CpfCnpj =   $linha['cnpj'];
                        }
                        if ($ativo == 1) {
                            $ativo = "<span class='badge text-bg-success'>Sim</span>";
                        } else {
                            $ativo = "<span class='badge text-bg-danger'>Não</span>";
                        }
                        if ($fisica_juridica == "f") {
                            $fisica_juridica = "<span class='badge text-bg-info'>Pessoa Fisica</span>";
                        } else {
                            $fisica_juridica = "<span class='badge text-bg-warning'>Pessoa Júridica</span>";
                        }
                        if ($tipo == "CLIENTE") {
                            $tipo = "<span class='badge text-bg-success'>Cliente</span>";
                        } else {
                            $tipo = "<span class='badge text-bg-dark'>fornecedor</span>";
                        }
                    ?>
                        <tr>
                            <td><?php echo $cod_cliente; ?></td>
                            <td><?php echo $nome; ?></td>
                            <td><?php echo $CpfCnpj; ?></td>
                            <td><?php echo $fisica_juridica . " " . $tipo; ?></td>
                            <td><?php echo $bairro; ?></td>
                            <td><?php echo $ativo; ?></td>
                            <td><a href="?pg&editclt&codigo=<?php echo $cod_cliente; ?>" class="btn btn-sm btn-info">Editar</a></td>
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