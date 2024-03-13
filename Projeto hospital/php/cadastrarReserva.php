<?php
require_once __DIR__."/Database.php";
if(isset($_REQUEST["Action"])&&$_REQUEST["Action"]=="CadastrarReserva"){

    $Params["ID"] = "";
    $Params["Atportaria"] = $_REQUEST["Atportaria"];
    $Params["recepcao"] = $_REQUEST["recepcao"];
    $Params["atendimentoE"] = $_REQUEST["atendimentoE"];
    $Params["atendimentoM"] = $_REQUEST["atendimentoM"];
    $Params["higienizacao"] = $_REQUEST["higienizacao"];
    $Params["instalacao"] = $_REQUEST["instalacao"];
    $Params["atendimentoS"] = $_REQUEST["atendimentoS"];
    $Params["servicoN"] = $_REQUEST["servicoN"];
    $Params["Pinternamento"] = $_REQUEST["Pinternamento"];
    $Params["indicacao"] = $_REQUEST["indicacao"];
    $Params["RespostaPQ"] = $_REQUEST["RespostaPQ"];
    $Params["nome"] = $_REQUEST["nome"];
    $Params["email"] = $_REQUEST["email"];
    $Params["telefone"] = $_REQUEST["telefone"];
    $Params["data_chegada"] = date("Y-m-d",strtotime(str_replace("/","-",$_REQUEST["data_chegada"])));
    $Params["data_retorno"] = date("Y-m-d",strtotime(str_replace("/","-",$_REQUEST["data_retorno"])));
    $Params["assinatura"] = $_REQUEST["assinatura"];
    $Params["comentarios"] = $_REQUEST["comentarios"];

    CadastrarReserva($Params);
}
function CadastrarReserva($Params){
    $database = new Database();
    $status = $database->Conectar();

    if($status == "CONN"){
        try{
            $sql = $database->Connection->prepare("
            INSERT INTO form_reservar VALUES(
                :ID,
                :Atportaria,
                :recepcao,
                :atendimentoE,
                :atendimentoM,
                :higienizacao,
                :instalacao,
                :atendimentoS,
                :servicoN,
                :Pinternamento,
                :indicacao,
                :RespostaPQ,
                :nome,
                :email,
                :telefone,
                :data_chegada,
                :data_retorno,
                :assinatura,
                :comentarios
            )");
            $sql->bindParam(":ID",$Params["ID"]);
            $sql->bindParam(":Atportaria",$Params["Atportaria"]);
            $sql->bindParam(":recepcao",$Params["recepcao"]);
            $sql->bindParam(":atendimentoE",$Params["atendimentoE"]);
            $sql->bindParam(":atendimentoM",$Params["atendimentoM"]);
            $sql->bindParam(":higienizacao",$Params["higienizacao"]);
            $sql->bindParam(":instalacao",$Params["instalacao"]);
            $sql->bindParam(":atendimentoS",$Params["atendimentoS"]);
            $sql->bindParam(":servicoN",$Params["servicoN"]);
            $sql->bindParam(":Pinternamento",$Params["Pinternamento"]);
            $sql->bindParam(":indicacao",$Params["indicacao"]);
            $sql->bindParam(":RespostaPQ",$Params["RespostaPQ"]);
            $sql->bindParam(":nome",$Params["nome"]);
            $sql->bindParam(":email",$Params["email"]);
            $sql->bindParam(":telefone",$Params["telefone"]);
            $sql->bindParam(":data_chegada",$Params["data_chegada"]);
            $sql->bindParam(":data_retorno",$Params["data_retorno"]);
            $sql->bindParam(":assinatura",$Params["assinatura"]);
            $sql->bindParam(":comentarios",$Params["comentarios"]); 
            
            $executou = $sql->execute();

            if($executou){
                $_REQUEST["ID"] = $database->Connection->lastInsertId();
                $status = [
                    "codigo"=>"OK",
                    "mensagem"=>"Reserva efetuada",
                ];
            }else{
                $status = [
                    "codigo" => $database->Connection->errorCode(),
                    "mensagem" => $database->Connection->errorInfo(),
                ];
            }
        }catch (PDOException $Erro){
            $status = [
                "codigo" => $Erro->getCode(),
                "mensagem" =>$Erro->getMessage(),
            ];
        }
    }else{
        $status = [
            "codigo" => "NCONN",
            "mensagem" => "Sem conexão com o banco de dados"
        ];
    }
    print json_encode([
        "dados" => $_REQUEST["ID"],
        "status" => $status 
    ]);
}
