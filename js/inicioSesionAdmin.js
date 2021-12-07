$(document).ready(function() {
    $('#enviar').click(function() {
        var username = $("#user").val();
        var password = $("#password").val();
        var dataString = 'user=' + username + '&password=' + password;
        console.log(username + password);
        $.ajax({
            type: "POST",
            url: "inicioSesionAdminEnviar.php",
            data: dataString,
            cache: false,
            success: function(data) {
                $("#error").html("<span style='color:#cc0000'>Error:</span> Datos erroneos. ");

            }
        });

    });

});