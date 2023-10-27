<div class="p-3 shadow">
    <span class="badge mb-3 text-bg-dark"><?php echo $acao; ?> Cliente/Fornecedor</span>

    <span style="display: none;" class='alert alert_api' role='alert'></span>
    <?php if ($alert != "") { //alert para usuario corrigir
        echo "<div class='alert alert-danger' role='alert'>$alert</div>";
    } ?>
    <?php if ($alert_success != "") { //alert acão realizada com sucesso
        echo "<div class='alert alert-success' role='alert'>$alert_success</div>";
    } ?>
    
    <form action="" method="POST">
        <?php if ($codigo != "") {
        ?>
            <div class="row mb-2">
                <div class="col-md-1  mb-2">
                    <input type="text" class="form-control" disabled value="<?= $codigo; ?>">
                </div>
            </div>
        <?php
        } ?>

        <div class="row mb-2">
            <div class="col-md  mb-2">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" class="form-control" placeholder="Ex. Paulo" name="nome" id="nome" value="<?= $nome; ?>">
            </div>
            <div class="col-md-3  mb-2">
                <label for="cpfcnpj" class="form-label">Cpf/Cnpj</label>
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Ex. 614385608" name="CpfCnpj"
                     id="cpfcnpj" value="<?= $CpfCnpj; ?>">
                    <button class="btn btn-secondary" type="button" id="consular_cnpj">Buscar Cnpj</button>
                </div>
            </div>
            <div class="col-md-3  mb-2">
                <label for="ie_estadual" class="form-label">IE. Estadual </label>
                <input type="number" class="form-control" placeholder="Ex. 12359987" name="ie_estadual" id="ie_estadual" value="<?= $telefone; ?>">
            </div>
        </div>
        <div class="row mb-2">

            <div class="col-md  mb-2">
                <label for="cep" class="form-label">Cep </label>
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Ex. 65057798" name="cep" id="cep" value="<?= $cep; ?>">
                    <button class="btn btn-secondary" type="button" id="consultar_cep">Buscar</button>
                </div>
            </div>
            <div class="col-md-2  mb-2">
                <label for="cidade" class="form-label">Cidade</label>
                <input type="text" class="form-control" placeholder="Ex. 988568879" name="cidade" id="cidade" value="<?= $cidade; ?>">
            </div>
            <div class="col-md-2  mb-2">
                <label for="estado" class="form-label">Estado </label>
                <select class="form-control" name="estado" id="estado">
                    <option value="0">Selecione..</option>
                    <option <?php if ($estado == "MA") {
                                echo "selected";
                            } ?> value="MA">MA</option>
                    <option <?php if ($estado == "SP") {
                                echo "selected";
                            } ?> value="SP">SP</option>
                    <option <?php if ($estado == "RJ") {
                                echo "selected";
                            } ?> value="RJ">RJ</option>
                </select>
            </div>
            <div class="col-md-2  mb-2">
                <label for="bairro" class="form-label">Bairro </label>
                <input type="text" class="form-control" placeholder="Ex. 12359987" name="bairro" id="bairro" value="<?= $bairro; ?>">
            </div>

            <div class="col-md  mb-2">
                <label for="endereco" class="form-label">Endereço </label>
                <input type="text" class="form-control" placeholder="Ex. 12359987" name="endereco" id="endereco" value="<?= $endereco; ?>">
            </div>
        </div>
        <div class="row mb-2">


            <div class="col-md-2  mb-2">
                <label for="telefone" class="form-label">Telefone</label>
                <input type="text" class="form-control" placeholder="Ex. 988568879" name="telefone" id="telefone" value="<?= $telefone; ?>">
            </div>

            <div class="col-md  mb-2">
                <label for="email" class="form-label">Email </label>
                <input type="text" class="form-control" placeholder="Ex. claudio@gmail.com" name="email" id="email" value="<?= $email; ?>">
            </div>
            <div class="col-md-2  mb-2">
                <label for="tipo_parceiro" class="form-label">Tipo</label>
                <select class="form-control" name="tipo_parceiro" id="tipo_parceiro">
                    <option value="0">Selecione..</option>
                    <option <?php if ($tipo_parceiro == "CLIENTE") {
                                echo "selected";
                            } ?> value="CLIENTE">Cliente</option>
                    <option <?php if ($tipo_parceiro == "FORNECEDOR") {
                                echo "selected";
                            } ?> value="FORNECEDOR">Fornecedor</option>
                </select>
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

        <button type="submit" name="form_cliente" class="btn btn-sm btn-success"
         onclick="return confirm('Deseja <?php echo $acao; ?> esse cliente/fornecedor?')"><?php echo $acao; ?></button>
        <a href="?pg&clt" class="btn btn-sm btn-secondary">Voltar</a>
    </form>
</div>

<script src="static/js/page/clientes.js"></script>