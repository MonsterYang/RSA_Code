
;(function(){


    //十六进制公钥
    var rsa_n = "D24109169ADC7C08C410E314C81A1390324463709F7C2654FD4EED2FA62F82BB0B2F807573ED87C79556AE5B85C6FB74ABC2C1AF06F8352E5F3FD9F6241C9C0DFE300FCA84C60FE0573CC96A567C109EC8EF56B997DE898FA306C79E063842062137CB7BB1991569403C247AAA9DBD6BB8FAE1CBB69B000F61DEC3D1BCCA015D";


    $("#send").click(function() {

        clean();

        var data = $('#data').val();

        if(data == '') { write_status('data can not be empty.');return; }
        else data = encodeURI(data);  //中文转义

        write_status('data:' + data);

        setMaxDigits(131); //131 => n的十六进制位数/2+3
        var key = new RSAKeyPair("10001", '', rsa_n); //10001 => e的十六进制
        data = encryptedString(key, data);

        write_status('encryptedData:' + data);

        $.post('http://localhost/RSACODE/accept.php',{
            data: data
        }, function( result ) {
            write_status('browser--------->server: success accept result.');
            write_status('result:' + decodeURI(result));
        });
    });

    function write_status( string ) {
        $('#msg').append(string + '<br/><hr/>');
    }

    function clean() {
        $('#msg').html('');
    }



})();

