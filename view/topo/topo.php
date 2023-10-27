<div class="topo-container text-bg-dark p-3">
    <i class="bi bi-list icon_hamburguer"></i>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(".icon_hamburguer").click(function() {
        $(".menu-container").css("display", "block")
    
        $(document).on("click", function(event) {
            if (!$(event.target).closest(".menu-container").length && !$(event.target).hasClass("icon_hamburguer")) {
                // Se o clique não estiver dentro do menu e não for no ícone de hamburguer, oculte o menu
                $(".menu-container").css("display", "none");
            }
        });
    })
</script>