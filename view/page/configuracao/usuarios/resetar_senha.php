<div class="p-3 shadow">
    <span class="badge mb-3 text-bg-dark"><?php echo $acao; ?> Senha de Usuário</span>
    <?php if ($alert != "") { //alert para usuario corrigir
        echo "<div class='alert alert-danger' role='alert'>$alert</div>";
    } ?>
    <?php if ($alert_success != "") { //alert acão realizada com sucesso
        echo "<div class='alert alert-success' role='alert'>$alert_success</div>";
    } ?>
    <form action="" method="POST">
        <div class="row mb-2">


            <div class="col-md  mb-2">
                <label for="usuario" class="form-label">Senha</label>
                <input type="text" class="form-control" placeholder="Ex. ds5d86@" name="senha" value="<?php echo $senha; ?>">
            </div>


            <div class="col-md  mb-2">
                <label for="usuario" class="form-label">Confirmar Senha</label>
                <input type="text" class="form-control" placeholder="Ex. ds5d86@" name="confirmar_senha" value="<?php echo $senha; ?>">
            </div>
        </div>

        <button type="submit" name="form_reset_usuario" class="btn btn-sm btn-success" onclick="return confirm('Deseja <?php echo $acao; ?> a senha desse usuário?')"><?php echo $acao; ?></button>
        <a href="?pg&user" class="btn btn-sm btn-secondary">Voltar</a>
    </form>

</div>