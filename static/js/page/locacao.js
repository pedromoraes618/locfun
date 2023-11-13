$(".remover_item").click(function (e) {
    e.preventDefault()
    const id_item = $(this).attr('id_item')
    const id_prd = $(this).attr('id_prd')
    // Exibe um alerta de confirmação
    var confirmacao = window.confirm(`Tem certeza que deseja remover o item de código ${id_prd}?`);

    // Verifica se o usuário confirmou a ação
    if (confirmacao) {
        // Execute a função de remoção
        delete_item(id_item);
    }
})

function delete_item(id) {

    $.ajax({
        type: "POST",
        data: "gerenciar_loc=true&acao=delete_item&id=" + id,
        url: "model/models/page/gerenciador_api.php",
        async: false
    }).then(sucesso, falha);

    function sucesso(data) {

        $dados = $.parseJSON(data)["dados"];
        if ($dados.sucesso == true) {
            alert_api($dados.title, "alert-info")
            // Remove a <tr> com a classe correspondente
            $(".tr_id" + id).remove();

        } else {
            alert_api($dados.title, "alert-danger")
        }
    }
    function falha() {
        console.log("erro");
    }

}

function alert_api(msg, color) {
    $(".alert_api").html(msg);
    $(".alert_api").addClass(color);
    $(".alert_api").css("display", "block");
}




$('#parceiro').select2();
$('#prd_id').select2();
$('#forma_pg').select2();

