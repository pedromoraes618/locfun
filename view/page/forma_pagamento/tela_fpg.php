<div class="p-3 shadow">
    <span class="badge mb-3 text-bg-dark"><?php echo $acao; ?> Forma Pagamento</span>
    <?php if ($alert != "") { //alert para usuario corrigir
        echo "<div class='alert alert-danger' role='alert'>$alert</div>";
    } ?>
    <?php if ($alert_success != "") { //alert acão realizada com sucesso
        echo "<div class='alert alert-success' role='alert'>$alert_success</div>";
    } ?>

    <form action="" method="POST" enctype="multipart/form-data">


        <div class="row mb-2">
            <div class="col-md  mb-2">
                <label for="descricao" class="form-label">Descrição</label>
                <input type="text" class="form-control" placeholder="Ex. Dinheiro" name="descricao" id="descricao" value="<?= $descricao; ?>">
            </div>

        </div>
        <div class="row mb-2">

            <div class="col-md-2  mb-2">
                <label for="status" class="form-label">Status </label>
                <select class="form-control" name="status" id="status">
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


        <button type="submit" name="form_fpg" class="btn btn-sm btn-success" onclick="return confirm('Deseja <?php echo $acao; ?> essa forma pagamento?')"><?php echo $acao; ?></button>
        <a href="?pg&fpg" class="btn btn-sm btn-secondary">Voltar</a>
    </form>
</div>