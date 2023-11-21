<div class="menu-container">
    <div class="d-flex menu-acess flex-column flex-shrink-0 p-3 text-bg-dark">
        <a href="?pg=1" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
            <!-- <svg class="bi pe-none me-2" width="40" height="32">
            <use xlink:href="#bootstrap" />
        </svg> -->
            <span class="fs-4">Loc Fun</span>
        </a>
        <hr>
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item">
                <a href="?pg=1" class="nav-link <?php if ($check == false) {
                                                    echo 'active';
                                                } else {
                                                    echo 'text-white';
                                                }
                                                ?>" aria-current="page">
                    <i class="bi bi-house-fill"></i>
                    Home
                </a>
            </li>
            <li>
                <a class="nav-link <?php if ($check == "clt") {
                                        echo 'active';
                                    } else {
                                        echo 'text-white';
                                    } ?>">
                    <i class="bi bi-person-circle"></i>
                    Parceiros
                </a>
                <ul>
                    <li><a href="?pg&clt">Clientes/Fornecedor</a></li>
                    <li><a href="?pg&clt">Relatório Geral</a></li>
                </ul>
            </li>

            <li>
                <a class="nav-link <?php if ($check == "prd") {
                                        echo 'active';
                                    } else {
                                        echo 'text-white';
                                    }  ?>">
                    <i class="bi bi-bucket-fill"></i>
                    Estoque
                </a>
                <ul>
                    <li><a href="?pg&prd">Produtos</a></li>
                    <li><a href="?pg&ajstest">Ajuste de Estoque</a></li>
                </ul>
            </li>
            <li>
                <a class="nav-link <?php if ($check == "lcf" or $check=='rpgtrec') {
                                        echo 'active';
                                    } else {
                                        echo 'text-white';
                                    } ?>">
                    <i class="bi bi-person-circle"></i>
                    Financeiro
                </a>
                <ul>
                    <li><a href="?pg&lcf">Meu Financeiro</a></li>
                    <li><a href="?pg&rpgtrec">Pagamentos e Recebimentos</a></li>
                </ul>
            </li>
            <li>
                <a class="nav-link <?php if ($check == "lcc") {
                                        echo 'active';
                                    } else {
                                        echo 'text-white';
                                    }  ?>">
                    <i class="bi bi-cart-dash-fill"></i>
                    Locações
                </a>
                <ul>
                    <li><a href="?pg&lcc">Gerenciar Locações</a></li>
                    <li><a href="?pg&rloc">Relatorio de Locações</a></li>
                </ul>
            </li>
            <li>
                <a class="nav-link <?php if ($check == "user" or ($check == "conf") or ($check == "log") or ($check == "fpg")) {
                                        echo 'active';
                                    } else {
                                        echo 'text-white';
                                    }  ?> text-white">
                    <i class="bi bi-people"></i>
                    Configuração
                </a>
                <ul>
                    <li><a href="?pg&user">Usuário</a></li>
                    <li><a href="?pg&fpg">Forma de Pagamento</a></li>
                    <li><a href="?pg&log">Log de Sistema</a></li>
                </ul>
            </li>
        </ul>
        <hr>
        <div class="dropdown">
            <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="https://github.com/mdo.png" alt="" width="32" height="32" class="rounded-circle me-2">
                <strong><?php echo $usuario_logado; ?></strong>
            </a>
            <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                <li><a class="dropdown-item" href="#">Minha Conta</a></li>

                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="?logout">Sair</a></li>
            </ul>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
    // Oculta todos os elementos ul filhos inicialmente
    $('.nav-pills ul').hide();
    // Adiciona um ouvinte de clique a cada item pai
    $('.nav-pills > li > a').click(function(e) {
   
        $('.nav-pills > li > a').not(this).removeClass('active');
        $('.nav-pills > li > a').not(this).addClass('text-white');
        $(this).toggleClass('active');
        $('.nav-pills > li > ul').not($(this).siblings('ul')).slideUp();
        $(this).siblings('ul').slideToggle();
    });
</script>