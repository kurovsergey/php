$(document).ready(function(){
    $('form[name="main"]').submit(function () {
        var params = $(this).serialize();
        var url = $(this).attr('action');
        $.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: params,
            cache: false,
            success: function (data) {
                $('#result').html('<strong>We sent confirm link on your email</strong>');
            },
            statusCode: {
                400: function () {
                    alert('Invalid parameters');
                }
            }
        });
        return !1;
    });

});
