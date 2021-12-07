$(document).ready(function() {

    $('#enviar').click(function() {
        var username = $("#boleta").val();
        var password = $("#CURP").val();
        var dataString = 'boleta=' + username + '&CURP=' + password;

        $.ajax({
            type: "POST",
            url: "inicioSesion.php",
            data: dataString,
            cache: false,
            success: function(data) {
                $("#error").html("<span style='color:#cc0000'>Error:</span> Datos erroneos. ");

            }
        });

    });

});