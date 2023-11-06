<table class="table table-hover">
    <?php
    $consultar_produtos = consulta_linhas_tb_filtro($conecta, 'itens_locacao', 'cod_locacao', $codigo_loc); //utilizando uma view itens locação

    if ($consultar_produtos > 0) {
    ?>
        <thead>
            <tr>
                <th>Código</th>
                <th>Descrição</th>
                <th>Qtd</th>
                <th>Valor</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php

            $total = 0;


            foreach ($consultar_produtos as $linha) {
                $codigo = $linha['id_item'];
                $id_prod = $linha['id_prod'];
                $descprd = $linha['descprd'];
                $qtd = $linha['qtd'];
                $valor = $linha['valor'];
                $total += $valor;
            ?>
                <tr>

                    <td><?php echo $id_prod; ?></td>
                    <td><?php echo $descprd; ?></td>
                    <td><?php echo $qtd ?></td>
                    <td><?php echo real_format($valor) ?></td>

                    <td><a href="?pg&removeitemloc&codigo=<?php echo $codigo; ?>" class="btn btn-sm btn-danger">Remover</a></td>
                </tr>

            <?php
            }

            ?>
        </tbody>
        <tfoot>

            <?php if ($taxa != 0 and $total > 0) {
            ?>
                <tr>
                    <th colspan="3">Taxa + </th>
                    <th><?= real_format($taxa); ?></th>
                    <th></th>
                </tr>
            <?php
            } ?>
            <?php if ($desconto != 0 and $total > 0) {
            ?>
                <tr>
                    <th colspan="3">Desconto -</th>
                    <th><?= real_format($desconto); ?></th>
                    <th></th>
                </tr>
            <?php
            } ?>
            <tr>
                <th colspan="3">Total</th>
                <th><?= real_format($total + $taxa - $desconto); ?></th>
                <th></th>
            </tr>
        </tfoot>
    <?php
    }

    ?>
</table>