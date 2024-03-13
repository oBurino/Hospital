
function CadastrarReserva(){//Atualizar o JQuery para a versão completa "minified"
    $.ajax({
        url:"../php/cadastrarReserva.php", // caminho que a requisição vai chamar a funcionalidade
        method:"POST", // tipo da requisiçãojQueryAJAXfuncionalidade
        data:{ // objeto JSON com os dados do formulário da requisição(data = reposta)
            Action:"CadastrarReserva",
            ID:"",
            Atportaria:$("input[id='Atportaria']:checked").val(),
            recepcao:$("input[id='recepcao']:checked").val(),
            atendimentoE:$("input[id='atendimentoE']:checked").val(),
            atendimentoM:$("input[id='atendimentoM']:checked").val(),
            higienizacao:$("input[id='higienizacao']:checked").val(),
            instalacao:$("input[id='instalacao']:checked").val(),
            atendimentoS:$("input[id='atendimentoS']:checked").val(),
            servicoN:$("input[id='servicoN']:checked").val(),
            Pinternamento:$("input[id='Pinternamento']:checked").val(),
            indicacao:$("input[id='indicacao']:checked").val(),
            RespostaPQ:$("#RespostaPQ").val(),
            nome: $("#nome").val(), //(#=id html) (.= classe html)
            email: $("#email").val(), 
            telefone: $("#telefone").val(),
            data_chegada: $("#dataC").val(),
            data_retorno: $("#dataR").val(),
            assinatura: $("#AssRespon").val(),
            comentarios: $("#comentarios").val(),         
        },
        dataType:"JSON", // tipo dos dados da requisição JSON
        success:function (data, textStatus, jqXHR) { // O evento disparado para uma requisição bem sucedida 
            window.alert(data.status.mensagem); // mensagem exibida - (processador vai queimar)            
        },
        error:function (jqXHR, textStatus, errorThrown) { // o evento disparado para uma requisição com erro 
            window.alert(errorThrown); // mensagem exibida com o erro da requisição
        }
    });

}





