<div class="p-3 shadow">
    <span class="badge mb-3 text-bg-dark">Consulta log</span>
    <form action="" method="POST">

        <div class="row">
        <div class="col-md-auto  mb-2">
                <div class="input-group">
                    <span class="input-group-text">Dt. Movimento</span>
                    <input type="date" class="form-control  " id="data_inicial" name="data_inicial" title="Data vencimento" placeholder="Data Inicial" value="<?php echo $data_inicial ?>">
                    <input type="date" class="form-control " id="data_final" name="data_final" title="Data vencimento" placeholder="Data Final" value="<?php echo $data_final; ?>">
                </div>
            </div>
            <div class="col-md  mb-2">
                <div class="input-group">
                    <input type="text" class="form-control" name="pesquisa_conteudo" value="<?php echo $conteudo_pesquisa; ?>" placeholder="Pesquise pelo nome de usuário ou pelo descrição" aria-label="Recipient's username" aria-describedby="button-addon2">
                    <button class="btn btn-outline-secondary" type="submit" id="pesquisar_filtro_pesquisa">Pesquisar</button>
                </div>
            </div>
        </div>
    </form>
    <div class="table-container">
        <table class="table  table-hover">
            <?php
            if ($qtd_consultar_log > 0) {
            ?>
                <thead>
                    <tr>
                        <th>Data</th>
                        <th>Usuário</th>
                        <th>Ação</th>
             
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($linha = mysqli_fetch_assoc($consultar_log)) {
                        $data_hora = formatarTimeStamp($linha['data_hora']);
                        $acao = $linha['acao'];
                        $usuario = ($linha['usuario']);


                    ?>
                        <tr>
                            <td><?php echo $data_hora; ?></td>
                            <td><?php echo $usuario; ?></td>
                            <td><?php echo ($acao); ?></td>
                         
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