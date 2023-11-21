<div class="p-3 shadow">
    <span class="badge mb-3 text-bg-dark">Relatório de Locações</span>
    <form action="" method="POST">

        <div class="row">
            <div class="col-md-auto  mb-2">
                <div class="input-group">
                    <span class="input-group-text">Dt. Vencimento</span>
                    <input type="date" class="form-control  " id="data_inicial" name="data_inicial" title="Data vencimento" placeholder="Data Inicial" value="<?php echo $data_inicial ?>">
                    <input type="date" class="form-control " id="data_final" name="data_final" title="Data vencimento" placeholder="Data Final" value="<?php echo $data_final; ?>">
                </div>
            </div>

            <div class="col-md  mb-2">
                <div class="input-group">
                    <input type="text" class="form-control" name="pesquisa_conteudo_rlt" value="<?php echo $conteudo_pesquisa; ?>" placeholder="Pesquise pelo nome do parceiro ou pela descrição" aria-label="Recipient's username" aria-describedby="button-addon2">
                    <button class="btn btn-outline-secondary" type="submit" id="pesquisar_filtro_pesquisa">Pesquisar</button>
                </div>
            </div>
        </div>

    </form>


    <div class="row  p-1">
        <div class="col-sm m-1   mb-1 ">
            <div id="card-top-1-1" class="card  border-0 Regular shadow">
                <div id="card_receita" class="card-header text-bg-dark">
                    Locações
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-8">
                            <h5 class="card-title"><?php echo real_format($valor_total_loc); ?></h5>
                        </div>
                        <div class="col-4 text-center">
                            <i class="bi btn btn-outline-light bi-graph-up-arrow "></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm m-1  mb-1 ">
            <div id="card-top-1-2" class="card  border-0 Regular shadow">
                <div id="card_despesa" class="card-header text-bg-dark">
                    Quantidade de Locações
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-8">
                            <h5 class="card-title"><?php echo ($qtd_loc); ?></h5>
                        </div>

                        <div class="col-4 text-center">
                            <i class="bi btn btn-outline-light bi-graph-down-arrow"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="row  p-1">
        <div class="col-sm m-1   mb-1 ">
            <div id="card-top-1-1" class="card  border-0 Regular shadow">
                <div id="card_receita" class="card-header text-bg-dark">
                    Historico de Locações
                </div>
                <div class="card-body">
                    <canvas id="locacoes_detalhado" height="100"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    var chart = document.getElementById('locacoes_detalhado').getContext('2d');
    var valor = [
        <?php
        $i = 0;
        while ($i <= 11) {
            $i = $i + 1;
            $resultado = valor_consulta_historico_loc($i, 2023);
            $valor_total_loc = $resultado['valor_total_loc'];

            echo       "'" . $valor_total_loc . "',";
        }
        ?>
    ];
    var quantidade = [
        <?php
        $i = 0;
        while ($i <= 11) {
            $i = $i + 1;
            $resultado = valor_consulta_historico_loc($i, 2023);
            $qtd_loc = $resultado['qtd_loc'];

            echo       "'" . $qtd_loc . "',";
        }
        ?>
    ];
    var myChart = new Chart(chart, {
        type: 'bar',
        data: {
            labels: ["Jan", "fev", "mar", "abr", "mai", "jun", 'jul', 'ago', 'set', 'out', 'nov', 'dez'],
            datasets: [{
                label: 'Valor R$',
                data: valor,
                type: 'line',
                borderColor: 'green',
                fill: false
            }, {
                label: 'Quatidade',
                data: quantidade,
                borderColor: 'green',
                backgroundColor: 'blue'

            }, ]
        },
        options: {
            locale: 'br-BR',
            elements: {
                line: {
                    tension: 0
                }
            },
            tooltips: {
                backgroundColor: 'rgba(255, 255, 255, 1)',
                bodyFontColor: 'rgba(0, 0, 0, 1)',
                titleFontColor: 'rgba(0, 0, 0, 1)',
                titleFontSize: 20,
                caretPadding: 10,
                xPadding: 5,
                yPadding: 15,

                caretSize: 10,
                titleFontStyle: 'bold',
            },

        }
    });
</script>