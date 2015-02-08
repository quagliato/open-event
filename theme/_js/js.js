$(document).ready(function(){
    setEvents();
});

function closeLightbox() {
    $('#lightbox_overlay').fadeOut('fast');
    $('#lightbox').fadeOut('fast');

    $('#lightbox #content').html("");
}

function openLightbox(href) {
    var values = {};

    var success = function(data){
        // alert(data);
        $('#lightbox #content').html(data);
    };
    
    $.get(href, values, success);

    $('#lightbox_overlay').fadeIn('fast');
    $('#lightbox').fadeIn('fast');
}

function bindMasks() {
    $('.cpf').mask("999.999.999-99");
    $('.phone').mask("(00) 0000-0000");
    $('.mobile').mask("(00) 00009-0000");
    $('.date').mask("00/00/0000");
    $('.br-postal_code').mask("00000-000");
    $('.money').mask('000.000.000.000.000,00', {reverse: true});
    $('.weight').mask('000000,000', {reverse: true});

    $('input[type="date"]').datepicker();
    $('input.datepicker').datepicker();
}

function validatePassword() {
    if (document.getElementById('senha').value != document.getElementById('confirmacao_senha').value) {
        document.getElementById('senha').className = 'error';
        document.getElementById('confirmacao_senha').className = 'error';
    } else {
        document.getElementById('senha').className = 'good';
        document.getElementById('confirmacao_senha').className = 'good';
    }
}

function validateRestorePassword() {
    var senha = document.getElementById('senha').value;
    var confirmacao_senha = document.getElementById('confirmacao_senha').value;

    if (senha != confirmacao_senha) {
        alert("A confirmação da senha está diferente da senha.\nPor favor, corrija.");
        return false;
    } else if (senha == null || senha == "") {
        alert("Por favor, digita uma senha, né?");
        return false;
    }

    return true;
}