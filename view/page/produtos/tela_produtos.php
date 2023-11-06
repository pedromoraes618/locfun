<div class="p-3 shadow">
    <span class="badge mb-3 text-bg-dark"><?php echo $acao; ?> Produtos</span>
    <?php if ($alert != "") { //alert para usuario corrigir
        echo "<div class='alert alert-danger' role='alert'>$alert</div>";
    } ?>
    <?php if ($alert_success != "") { //alert acão realizada com sucesso
        echo "<div class='alert alert-success' role='alert'>$alert_success</div>";
    } ?>

    <form action="" method="POST" enctype="multipart/form-data">
        
            <div class="row">
                <div class="col-md-2 mb-2">
                    <div class="upload-img  rounded-5 bg-secondary p-3 <?php if ($img_produto == null) {
                                                                            echo "bg.secondary";
                                                                        } ?>" style="background-image: url(<?php echo $img_produto; ?>);"></div>
                    <input type="hidden" name="diretorio_img" value="<?php echo $img_produto; ?>">
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 mb-2">
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <input class="form-control-sm" type="file" name="arquivo" id="formFile">
                        <button type="submit" name="upload_img" id="" class="btn btn-dark btn-sm">Alterar</button>
                    </div>
                </div>
            </div>
       

        <div class="row mb-2">
            <div class="col-md  mb-2">
                <label for="descricao" class="form-label">Descrição</label>
                <input type="text" class="form-control" placeholder="Ex. Brinquedo" name="descricao" id="descricao" value="<?= $descricao; ?>">
            </div>
            <div class="col-md  mb-2">
                <label for="categoria" class="form-label">Categoria</label>
                <select class="form-select" name="categoria" id="categoria">
                    <option value="0">Selecione</option>
                    <?php
                    $resultados = consulta_linhas_tb($conecta, 'categorias');
                    if ($resultados) {
                        foreach ($resultados as $linha) {
                            $id = $linha['id'];
                            $descricao_categoria = $linha['nome'];
                            $selected = ($id == $categoria) ? "selected" : "";
                            echo "<option value='$id' $selected>$descricao_categoria</option>";
                        }
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-md-2  mb-2">
                <label for="preco" class="form-label">Preço do Aluguel / H</label>
                <input type="number" step="any" class="form-control" placeholder="Ex. 20.50" name="preco" id="preco" value="<?= $preco; ?>">
            </div>
            <div class="col-md-2  mb-2">
                <label for="estoque" class="form-label">Estoque </label>
                <input type="number" step="any" disabled class="form-control" placeholder="Ex. 5" name="estoque" id="estoque" value="<?= $estoque; ?>">
            </div>
            <div class="col-md-2  mb-2">
                <label for="status" class="form-label">Status </label>
                <select class="form-select" name="status" id="status">
                    <option value="sn">Selecione..</option>
                    <option <?php if ($status == "1") {
                                echo "selected";
                            } ?> value="1">Ativo</option>
                    <option <?php if ($status == "0") {
                                echo "selected";
                            } ?> value="0">Inativo</option>
                </select>
            </div>

        </div>
        <div class="row mb-3">
            <div class="col-md  mb-2">
                <label for="observacao" class="form-label">Observacao</label>
                <textarea type="text" step="any" class="form-control" placeholder="Ex. Bicicleta em manutenção" name="observacao" id="observacao"><?= $observacao; ?></textarea>
            </div>
        </div>

        <button type="submit" name="form_produto" class="btn btn-sm btn-success" onclick="return confirm('Deseja <?php echo $acao; ?> esse produto?')"><?php echo $acao; ?></button>
        <a href="?pg&prd" class="btn btn-sm btn-secondary">Voltar</a>
    </form>
</div>
