<?php
require_once __DIR__."/Database.php";
if(isset($_REQUEST["Action"])){
    if($_REQUEST["Action"]=="ListarReservas"){
        ListarReservas();
    }if($_REQUEST["Action"]=="BuscaPorId"){
        $id = $_REQUEST["id"];
        BuscaReservaPorId($id);
    }else if($_REQUEST["Action"]=="AlterarReserva"){
        $Params["id"] = $_REQUEST["id"];
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

        AlterarReserva($Params);

    }else if($_REQUEST["Action"]=="RemoverReserva"){
        $Params["id"] = $_REQUEST["id"];
        RemoverReservas($Params);
    }
    
}
function ListarReservas(){
    $database = new Database();
    $status = $database->Conectar();
    if($status == "CONN"){
        try{
            $sql = $database->Connection->prepare("
                SELECT id,
                Atportaria,
                recepcao,
                atendimentoE,
                atendimentoM,
                higienizacao,
                instalacao,
                atendimentoS,
                servicoN,
                Pinternamento,
                indicacao,
                RespostaPQ,
                nome,
                email,
                telefone,
                data_chegada,
                data_retorno,
                assinatura,
                comentarios
            FROM hospital_santa_house.form_reservar");
        $executou = $sql->execute();
            if($executou){
                $resultado = $sql->fetchAll(PDO::FETCH_NUM);

                for($r = 0;$r<count($resultado);$r++){
                    $resutado[$r][4] = date("d/m/y",strtotime($resultado[$r][4]));
                }
                $k = count($resultado);
                $status = [
                    "codigo"=>"OK",
                    "mensagem" =>"Foram encontradas$k linhas",
                ];
            }else{
                $status = [
                    "codigo"=>$database->Connection->errorCode(),
                    "mensagem" =>$database->Connection->errorInfo(),
                ];
            }
        }catch(PDOException $Erro){
            $status = [
                "codigo"=>$Erro->getCode(),
                "mensagem"=>$Erro->getMessage(),
            ];
        }

    }else{
        $status =[
            "codigo"=>"NCONN",
            "mensagem"=>"Sem conexão com o banco de dados!"
        ];
    }
    print json_encode([
        "dados"=>$resultado,
        "status"=>$status
    ]);
}

function BuscarReservaPorId($id){
    $database = new Database();
    $status = $database->Conectar();
    $resultado = [];
    if($status == "CONN"){
        try{
            $sql = $database->Connection->prepare("
                SELECT id,
                Atportaria,
                recepcao,
                atendimentoE,
                atendimentoM,
                higienizacao,
                instalacao,
                atendimentoS,
                servicoN,
                Pinternamento,
                indicacao,
                RespostaPQ,
                nome,
                email,
                telefone,
                data_chegada,
                data_retorno,
                assinatura,
                comentarios
            FROM form_reservar
            WHRE id = :ID");
            $sql->bindParam(":ID",$id);
            $executar = $sql->execute();
            if($executar){
                $resultado = $sql->fetch(PDO::FETCH_ASSOC);
                $resultado["data_chegada"] = date("d/m/Y",strtotime($resultado["data_chegada"]));
                $status = [
                    "codigo"=>"OK",
                    "mensagem"=>"Reserva carregada com sucesso",
                ];
            }else{
                $status = [
                    "codigo"=>$database->Connection->errorCode(),
                    "mensagem"=>$database->Connection->errorInfo(),
                ];
            }
        }catch(PDOException $Erro){
            $status = [
                "codigo" =>$Erro->getCode(),
                "mensagem" =>$Erro->getMessage(),
            ];
        }
    }else{
        $status = [
            "codigo" => "NCONN",
            "mensagem" =>"Sem conexão com o banco de dados"
        ];    
    }
    print json_encode([
        "dados" =>$resultado,
        "status"=>$status
    ]);
}
function AlterarReserva($Params){
    $database = new Database();
    $status = $database->Conectar();

    if($status == "CONN"){
        try{
            $sql = $database->Connection->prepare("
                UPDATE form_reservar SET
                Atportaria=:Atportaria,
                recepcao=:recepcao,
                atendimentoE=:atendimentoE,
                atendimentoM=:atendimentoM,
                higienizacao=:higienizacao,
                instalacao=:instalacao,
                atendimentoS=:atendimentoS,
                servicoN=:servicoN,
                Pinternamento=:Pinternamento,
                indicacao=:indicacao,
                RespostaPQ=:RespostaPQ,
                nome=:nome,
                email=:email,
                telefone=:telefone,
                data_chegada=:data_chegada,
                data_retorno=:data_retorno,
                assinatura=:assinatura,
                comentarios=:comentarios
                WHERE ID = :id");

            $sql->bindParam(":id",$Params["id"]);
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
                $k = $sql->rowCount();
                if($k > 0){
                    $status = [
                        "codigo" =>"OK",
                        "mensagem"=>"Alteração Realizada com Sucesso!",
                    ];
                }else{
                    $status = [
                        "codigo" => $database->Connection->errorCode(),
                        "mensagem"=>$database->Connection->errorInfo(),
                    ];
                }
            }else{
                $status = [
                    "codigo" => $database->Connection->errorCode(),
                    "mensagem"=>$database->Connection->errorInfo(),
                ];
            }
        }catch(PDOException $Erro){
            $status = [
                "codigo"=>$Erro->getCode(),
                "mensagem"=>$Erro->getMessage(),
            ];
        }
    }else{
        $status = [
            "codigo" =>"NCONN",
            "mensagem"=>"Sem conexão com banco de dados"
        ];
    }
    print json_encode([
        "dados" => $Params,
        "status" => $status
    ]);
}

function RemoverReservas($Params){
    $database = new Database();
    $status = $database->Conectar();
    if($status == "CONN"){
        try{
            $sql = $database->Connection->prepare("
                DELETE FROM form_reservar WHERE ID =:id");
                $sql->bindParam(":id",$Params["id"]);
                $executou = $sql->execute();
                
                if($executou){
                    $status = [
                        "codigo"=>"OK",
                        "mensagem"=>"A reserva foi excluida",
                    ];
                }else{
                    $status = [
                        "codigo" => $database->Connection->errorCode(),
                        "mensagem" => $database->Connection->errorInfo(),
                    ];
                }
        }catch(PDOException $Erro){
            $status = [
                "codigo" => $Erro->getCode(),
                "mensagem"=> $Erro->getMessage(),
            ];
        }
    }else{
        $status = [
            "codigo" => "NCONN",
            "mensagem"=> "Sem conexão com o banco de dados"
        ];
    }
    print json_encode([
        "dados" =>$Params,
        "status"=>$status
    ]);
}