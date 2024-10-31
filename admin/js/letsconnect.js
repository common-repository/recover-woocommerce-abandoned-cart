/*
 *  Lets Connect
 *  EcartChat - WooCommerce Popup
 */

(function ($) {
    'use strict';

    $(function () {
        $('.ecart-letsconnect').on('click', function (e) {
            $('.ecart-letsconnect').off("click");
            function getParam(sParam){
                var sPageURL = window.location.search.substring(1);
                var sURLVariables = sPageURL.split('&');
                var uuid = 0;
                for (var i = 0; i < sURLVariables.length; i++) {
                    var sParameterName = sURLVariables[i].split('=');
                    if (sParameterName[0] == sParam) {
                        return sParameterName[1];
                    }
                };
            }

            var uuid = getParam('uuid');

            $.ajax({
                url: 'admin-ajax.php',
                type: 'POST',
                data: {
                    action: 'submit_connect_user_details',
                    uuid: uuid
                },
                beforeSend: function () {
                    $('.ecart-letsconnect').addClass('disabled');
                    $('.ecart-letsconnect').text('Connecting.......');
                },
                success: function (response) {
                    $('.ecart-letsconnect').text('Connected');
                    setTimeout(function(){
                        window.location.replace('https://app.ecart.chat');
                    }, 2000);
                    return false;
                }
            });
        });
    });

    $('#popup-anchor').trigger( "click" );

}(jQuery));