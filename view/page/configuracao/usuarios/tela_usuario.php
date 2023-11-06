<div class="p-3 shadow">
    <span class="badge mb-3 text-bg-dark"><?php echo $acao; ?> Usuário</span>
    <?php if ($alert != "") { //alert para usuario corrigir
        echo "<div class='alert alert-danger' role='alert'>$alert</div>";
    } ?>
    <?php if ($alert_success != "") { //alert acão realizada com sucesso
        echo "<div class='alert alert-success' role='alert'>$alert_success</div>";
    } ?>
    <form action="" method="POST">
        <div class="row mb-2">
            <div class="col-md  mb-2">
                <label for="usuario" class="form-label">Usuário</label>
                <input type="text" <?php if ($acao == "Alterar") { //bloquar o campo usuario para realizar edição
                                        echo "readonly";
                                    } ?> class="form-control" placeholder="Ex. Paulo" name="usuario" value="<?php echo $usuario; ?>">
            </div>
            <?php if ($acao != "Alterar") { ?>
                <div class="col-md  mb-2">
                    <label for="usuario" class="form-label">Senha</label>
                    <input type="text" class="form-control" placeholder="Ex. ds5d86@" name="senha" value="<?php echo $senha; ?>">
                </div> <?php } ?>

            <div class="col-md  mb-2">
                <label for="email" class="form-label">Email</label>
                <input type="text" class="form-control" placeholder=" Ex. Paulo" name="email" value="<?php echo $email; ?>">
            </div>

        </div>
        <div class="row mb-2">
            <div class="col-md-3 mb-2">
                <label for="email" class="form-label">Grupo</label>
                <select class="form-select" name="grupo" id="">
                    <option value="0">Selecione..</option>
                    <?php
                    $resultados = consulta_linhas_tb($conecta, 'grup_user');
                    if ($resultados) {
                        foreach ($resultados as $linha) {
                            $id = $linha['cod_grup'];
                            $descricao = $linha['grupo'];
                            $selected = ($id == $grupo) ? "selected" : "";
                            echo "<option value='$id' $selected>$descricao</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-2  mb-2">
                <label for="email" class="form-label">Ativo</label>
                <select class="form-select" name="ativo" id="">
                    <option <?php if ($ativo == 1) {
                                echo 'selected';
                            } ?> value="1">Sim</option>
                    <option <?php if ($ativo == "0") {
                                echo 'selected';
                            } ?> value="0">Não</option>
                </select>
            </div>
        </div>
        <button type="submit" name="form_usuario" class="btn btn-sm btn-success" onclick="return confirm('Deseja <?php echo $acao; ?> esse usuário?')"><?php echo $acao; ?></button>
        <a href="?pg&user" class="btn btn-sm btn-secondary">Voltar</a>



    </form>


</div>