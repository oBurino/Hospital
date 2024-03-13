function ListarReservas(){// Executa uma chamada web que traz um array com vários son com as reservas do banco de dados
    $.ajax({
        url:"../php/gerenciarReserva.php",   
        type:"POST",    
        data: {Action:"ListarReservas"},   
        dataType:"JSON",    
        beforeSend: function(xhr) {$("main").load("tabela-reservas.html");},
        success: function (data,textStatus,jqXHR) {
            var K = data.dados.length; // Contar o numero de linhas encontradas no banco de dados
            if(K > 0) {
                for (var i = 0; i < K; i++){
                var tituloLinha = document.createElement("th"); // Gera uma coluna como titulo de uma linha 
                tituloLinha.scope ="row";
                tituloLinha.textContent = data.dados[i][0];  
                var novaLinha = GerarNovaLinhaReservasHtml(data.dados[i], tituloLinha); // $("#ListaDeReservas").append(novalLinha); // Coloca linha gerada na tabela
                $("#ListaDeReservas").append(novaLinha); 
                }
            }
        }, 
        error:function (jqXHR, textStatus, errorThrown){
        window.alert(errorThrown);   
        }
    });
}

function GerarNovaLinhaReservasHtml(dados,titulo){
    var linha = document.createElement("tr");

    linha.appendChild(titulo);

    for (var i = 1; i < dados.length; i++){
        var coluna = document.createElement("td");
        coluna.textContent = dados[i];
        linha.appendChild(coluna);
    }
    var colunaAlterar = document.createElement("td");
    colunaAlterar.textContent = "Alterar";
    colunaAlterar.onclick = function(){
        EventoAlterarReserva(dados[0]);
    };
    linha.appendChild(colunaAlterar);
    var colunaDeletar = document.createElement("td");
    colunaDeletar.textContent = "Excluir";
    colunaDeletar.onclick = function(){
        EventoDeletarReserva(dados[0]);
    };
    linha.appendChild(colunaDeletar);
    return linha;
}

function EventoAlterarReserva(id){
    $("main").load("./formulario-ReservaAltera.html",function(){
        CarregarReservaPorId(id);
    });
}

function CarregarReservaPorId(id){
    $.ajax({
        url:"../php/gerenciarReserva.php", // talvez seja preciso colcoar o "s" no final novamente
        method:"POST", 
        data:{ 
            Action:"BuscarPorId",
            id:id               
        },
        dataType:"JSON", 
        success:function (data, textStatus, jqXHR){
            if(data.dados.id > -1){
                var dados = data.dados;
                $("#id").val(dados.id);//mudar para possivel #ID
                $("input[id='Atportaria'][value="+dados.Atportaria+"]").prop("checked",true);
                $("input[id='recepcao'][value="+dados.recepcao+"]").prop("checked",true);
                $("input[id='atendimentoE'][value="+dados.atendimentoE+"]").prop("checked",true);
                $("input[id='atendimentoM'][value="+dados.atendimentoM+"]").prop("checked",true);
                $("input[id='higienizacao'][value="+dados.higienizacao+"]").prop("checked",true);
                $("input[id='instalacao'][value="+dados.instalacao+"]").prop("checked",true);
                $("input[id='atendimentoS'][value="+dados.atendimentoS+"]").prop("checked",true);
                $("input[id='servicoN'][value="+dados.servicoN+"]").prop("checked",true);
                $("input[id='Pinternamento'][value="+dados.Pinternamento+"]").prop("checked",true);
                $("input[id='indicacao'][value="+dados.indicacao+"]").prop("checked",true);
                $("#RespostaPQ").val(dados.RespostaPQ);
                $("#nome").val(dados.nome);
                $("#email").val(dados.email); 
                $("#telefone").val(dados.telefone);
                $("#dataC").val(dados.data_chegada);
                $("#dataR").val(dados.data_retorno);
                $("#AssRespon").val(dados.assinatura);
                $("#comentarios").val(dados.comentarios);
                Recalcular();
            }           
        },
        error:function (jqXHR, textStatus, errorThrown) { 
            window.alert(errorThrown); 
        }
    });
}

function AlterarReserva(){
    $.ajax({
        url:"../php/gerenciarReserva.php",
        type:"POST",
        data:{
            Action:"AlterarReserva",
            id:$("#id").val(),
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
            nome: $("#nome").val(), 
            email: $("#email").val(), 
            telefone: $("#telefone").val(),
            data_chegada: $("#dataC").val(),
            data_retorno: $("#dataR").val(),
            assinatura: $("#AssRespon").val(),
            comentarios: $("#comentarios").val(),     
        },
        dataType:"JSON",
        success:function(data, textStatus, jqXHR){
            window.alert(data.status.mensagem);
            $("#TabelaReservas").click();
        },
        error: function(jqXHR, textStatus,errorThrown){
            window.alert(errorThrown);
        }
    });
}

function EventoDeletarReserva(id){
    var decisao = window.confirm("Tem certeza que deseja excluir esta reserva?");
    if(decisao){
        $.ajax({
            url:"../php/gerenciarReserva.php",
            type:"POST",
            data:{
                Action:"RemoverReserva",
                id:id
            },
            dataType:"JSON",
            success: function(data,textStatus,jqXHR){
                window.alert(data.status.mensagem);
                $("#TabelaReservas").click();
            },
            error: function(jqXHR,textStatus,errorThrown){
                window.alert(errorThrown);
            }
        });
    }
}