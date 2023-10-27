$("#consular_cnpj").click(function () {

    var cnpj = $("#cpfcnpj").val()

    if (cnpj == "") {//infomar o cnpj
        alert_api("Favor, informe o cnpj", "alert-danger")
    } else {
        //document.getElementById("carregando").style.display = "block";
        alert_api("Buscando..", "alert-info")
        $.ajax({
            'url': 'https://www.receitaws.com.br/v1/cnpj/' + cnpj.replace(/[^0-9]/g, '', ".", "-"),
            'type': "GET",
            'dataType': 'jsonp',
            'success': function (data) {

                if (data.nome == undefined) {
                    alert_api("Cnpj não encontrado, favor verifique", "alert-danger")
                } else {
                    console.log(data)
                  
                    $("#nome").val(data.nome);
                    $("#cep").val(data.cep);
                    $("#endereco").val(data.logradouro);
                    $("#bairro").val(data.bairro);
                    $("#telefone").val(data.telefone);
                    $("#email").val(data.email);
                    $("#cidade").val(data.municipio);
                    $("#estado").val(data.uf);



                    // function falha() {
                    //     console.log("erro ao requisitar ao bd")
                    // }

                    $(".alert_api").css("display", "none");
                }

            }

        })

    }
})

function alert_api(msg, color) {
    $(".alert_api").html(msg);
    $(".alert_api").addClass(color);
    $(".alert_api").css("display", "block");
}


