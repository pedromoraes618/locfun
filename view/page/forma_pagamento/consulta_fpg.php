<div class="p-3 shadow">
    <span class="badge mb-3 text-bg-dark">Consulta de Forma Pagamento</span>
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
                <a href="?pg&addfpg" class="btn  btn-dark">Adicionar Forma Pagamento</a>
            </div>
        </div>
    </form>
    <div class="table-container">
        <table class="table  table-hover">
            <?php
            if ($qtd_consulta > 0) {
            ?>
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Descrição</th>
        
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($linha = mysqli_fetch_assoc($consulta)) {
                        $cod_fpg = $linha['id_pg'];
                        $descricao = $linha['nome_pg'];
                        $ativo = $linha['ativo'];
                   
                        if ($ativo == 1) {
                            $ativo = "<span class='badge text-bg-success'>Sim</span>";
                        } else {
                            $ativo = "<span class='badge text-bg-danger'>Não</span>";
                        }
                    ?>
                        <tr>
                            <td><?php echo $cod_fpg; ?></td>
                            <td><?php echo $descricao; ?></td>
                            <td><?php echo $ativo; ?></td>
                   
                            <td style="width: 200px;">
                                <a href="?pg&editfpg&codigo=<?php echo $cod_fpg; ?>" class="btn btn-sm btn-info">Editar</a>
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

</div>

<script type="text/javascript" src="static/js/page/produtos.js"></script>