<?php
include "model/models/login/login.php"
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela de Login</title>
    <link href="static/css/login.css" rel="stylesheet">

    <!-- Adicione os links para os arquivos CSS e JavaScript do Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

    <style>
        body {
            background-color: #024b61;
        }
    </style>
</head>

<body>
    <div class="bloco">
        <div class="modal modal-signin  d-block  py-5" tabindex="-1" role="dialog" id="modalSignin">
            <div class="modal-dialog" role="document">
                <div class="modal-content rounded-4 shadow">
                    <div class="modal-header p-5 pb-4 border-bottom-0">
                        <!-- <h1 class="modal-title fs-5" >Modal title</h1> -->
                        <h3 class="fw-semibold mb-0 fs-3">Faça o seu Login</h3>
                    </div>

                    <div class="modal-body p-5 pt-0">
                        <form class="" method="POST">
                            <input type="hidden" name="form_login">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control rounded-3" name="usuario" id="floatingUser" value="<?php echo $usuario; ?>" placeholder="Ex. claudio">
                                <label for="floatingUser">Usuário</label>

                            </div>

                            <div class="form-floating mb-3">
                                <input type="password" class="form-control rounded-3" name="senha" id="floatingPassword" value="<?php echo $senha; ?>" placeholder="Password">
                                <label for="floatingPassword">Senha</label>
                            </div>

                            <div class="d-grid gap-2">
                                <button class="btn btn-primary" type="submit">Login</button>
                            </div>


                            <div class="reset">
                                <small class="text-muted"><a href="?reset_password">Resetar renha</a></small>
                            </div>

                            <div class="footer-modal">
                                <small class="text-muted">2023 @Todos direitos rersevados a locfun</small>
                            </div>

                        </form>
                    </div>
                </div>
                <?php if ($alert != "") {
                    echo "<div class='alert alert-danger' role='alert'>$alert</div>";
                } ?>
            </div>
        </div>

        <svg class="waves" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
            <path fill="#43818A" fill-opacity="0.3" d="M0,128L40,149.3C80,171,160,213,240,192C320,171,400,85,480,53.3C560,21,640,43,720,85.3C800,128,880,192,960,197.3C1040,203,1120,149,1200,138.7C1280,128,1360,160,1400,176L1440,192L1440,320L1400,320C1360,320,1280,320,1200,320C1120,320,1040,320,960,320C880,320,800,320,720,320C640,320,560,320,480,320C400,320,320,320,240,320C160,320,80,320,40,320L0,320Z">
            </path>

            <path fill="#57a7b3" fill-opacity="0.3" d="M0,96L24,117.3C48,139,96,181,144,186.7C192,192,240,160,288,160C336,160,384,192,432,192C480,192,528,160,576,165.3C624,171,672,213,720,224C768,235,816,213,864,218.7C912,224,960,256,1008,234.7C1056,213,1104,139,1152,112C1200,85,1248,107,1296,133.3C1344,160,1392,192,1416,208L1440,224L1440,320L1416,320C1392,320,1344,320,1296,320C1248,320,1200,320,1152,320C1104,320,1056,320,1008,320C960,320,912,320,864,320C816,320,768,320,720,320C672,320,624,320,576,320C528,320,480,320,432,320C384,320,336,320,288,320C240,320,192,320,144,320C96,320,48,320,24,320L0,320Z">
            </path>

        </svg>

    </div>
    <!-- Adicione os links para os arquivos JavaScript do Bootstrap e jQuery (opcional) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js" integrity="sha384-Rx+T1VzGupg4BHQYs2gCW9It+akI2MM/mndMCy36UVfodzcJcF0GGLxZIzObiEfa" crossorigin="anonymous"></script>
</body>

</html>