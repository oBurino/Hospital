window.onload = PegaTecla;
function PegaTecla(){
    document.getElementById("nome").onkeypress = TrataTecla;
    document.getElementById("AssRespon").onkeypress = TrataTecla;
}

function TrataTecla(CharCode){
    var valorNome = document.getElementById("nome");
    var TECLA = CharCode.which;
    if((TECLA > 64 && TECLA < 91)||(TECLA > 96 && TECLA < 123)||(TECLA >= 0 && TECLA <33)){
        return true

    }else{
        alert("Caractere invalido!")
        return false
    }
}
var email = document.getElementById("email");

function Validar(){
    //console.log(email.value);
    var resultado1 = email.value.indexOf("@outlook.com") > -1;
    var resultado2 = email.value.indexOf("@gmail.com") > -1;
    //console.log(resultado1)
    if(resultado1 == true){
        return true
    }else if(resultado2 == true){
        return true
    }else if(email.value == ""){
        alert("Preencha o campo email!")
        email.focus();
        return false
    }else{
        alert("Preencha o campo email contendo @outlook.com ou @gmail.com")
        email.value="";
        return false
    }     
}