<div class="p-3 shadow">
    <?php if ($alert != "") { //alert para usuario corrigir
        echo "<div class='alert alert-danger' role='alert'>$alert</div>";
    } ?>
    <?php if ($alert_success != "") { //alert acão realizada com sucesso
        echo "<div class='alert alert-success' role='alert'>$alert_success</div>";
    } ?>

    <span class="badge mb-3 text-bg-dark">Consulta de Produtos</span>
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
                    <input type="text" class="form-control" name="pesquisa_conteudo" value="<?php echo $conteudo_pesquisa; ?>" placeholder="Pesquise pela descrição ou pelo código" aria-label="Recipient's username" aria-describedby="button-addon2">
                    <button class="btn btn-outline-secondary" type="submit" id="pesquisar_filtro_pesquisa">Pesquisar</button>
                </div>
            </div>
            <div class="col-md-auto d-grid gap-2 d-sm-block mb-1">
                <button type="sumit" name="form_ajst" class="btn btn-success">Concluir Ajuste</button>
            </div>
        </div>

        <div class="table-container">
            <table class="table  table-hover">
                <?php
                if ($qtd_consulta > 0) {
                ?>
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Img</th>
                            <th>Descrição</th>
                            <th>Categoria</th>
                            <th>Estoque</th>
                            <th>Preço</th>
                            <th>Ativo</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($linha = mysqli_fetch_assoc($consulta)) {
                            $cod_produto = $linha['id_prod'];
                            $produto = ($linha['produto']);
                            $observacao = ($linha['observacao']);
                            $qtd = ($linha['qtd']);
                            $preco = real_format($linha['preco']);
                            $ativo = ($linha['ativo']);
                            $categoria = ($linha['categoria']);
                            $img_produto = ($linha['img_produto']);


                            if ($ativo == 1) {
                                $ativo = "<span class='badge text-bg-success'>Sim</span>";
                            } else {
                                $ativo = "<span class='badge text-bg-danger'>Não</span>";
                            }
                        ?>
                            <tr>
                                <td><?php echo $cod_produto; ?></td>
                                <td><img width="40" height="40" class="rounded-5" src="<?php echo $img_produto; ?>"></td>
                                <td><?php echo $produto; ?></td>
                                <td><?php echo $categoria; ?></td>
                                <td><?php echo $qtd; ?></td>
                                <td><?php echo $preco; ?></td>
                                <td><?php echo $ativo; ?></td>

                                <td>
                                    <input type="number" step="any" placeholder="Digite o novo estoque" class="form-control" name="ajst<?php echo $cod_produto ?>">
                                </td>

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
    </form>
</div>

<script type="text/javascript" src="static/js/page/produtos.js"></script>