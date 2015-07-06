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

    $('#lightbox_overlay').css('position', 'fixed');
    $('#lightbox_overlay').css('left', '0px');
    $('#lightbox_overlay').css('top', '0px');
    $('#lightbox_overlay').height($(window).height());
    $('#lightbox_overlay').width($(window).width());
    $('#lightbox_overlay').fadeIn('fast');
    $('#lightbox').fadeIn('fast');
}

function bindMasks() {
    $('.cpf').mask("999.999.999-99");
    $('.phone').mask("(00) 0000-0000");
    $('.mobile').mask("(00) 00009-0000");
    $('.date').mask("00/00/0000");
    $('.br-postal_code').mask("00000-000");
    $('.cep').mask("00000-000");
    $('.money').mask('000.000.000.000.000,00', {reverse: true});
    $('.weight').mask('000000,000', {reverse: true});

    $('input[type="date"]').datepicker();
    $('input.datepicker').datepicker();

    $('input.datetimepicker').datetimepicker({
        datepicker: true,
        format:'d/m/Y H:i:s',
        mask: true,
        scrollTime: true,
        allowTimes: [
            "00:00", "00:15", "00:30", "00:45",
            "01:00", "01:15", "01:30", "01:45",
            "02:00", "02:15", "02:30", "02:45",
            "03:00", "03:15", "03:30", "03:45",
            "04:00", "04:15", "04:30", "04:45",
            "05:00", "05:15", "05:30", "05:45",
            "06:00", "06:15", "06:30", "06:45",
            "07:00", "07:15", "07:30", "07:45",
            "08:00", "08:15", "08:30", "08:45",
            "09:00", "09:15", "09:30", "09:45",
            "10:00", "10:15", "10:30", "10:45",
            "11:00", "11:15", "11:30", "11:45",
            "12:00", "12:15", "12:30", "12:45",
            "13:00", "13:15", "13:30", "13:45",
            "14:00", "14:15", "14:30", "14:45",
            "15:00", "15:15", "15:30", "15:45",
            "16:00", "16:15", "16:30", "16:45",
            "17:00", "17:15", "17:30", "17:45",
            "18:00", "18:15", "18:30", "18:45",
            "19:00", "19:15", "19:30", "19:45",
            "20:00", "20:15", "20:30", "20:45",
            "21:00", "21:15", "21:30", "21:45",
            "22:00", "22:15", "22:30", "22:45",
            "23:00", "23:15", "23:30", "23:45",
        ]
    });
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
