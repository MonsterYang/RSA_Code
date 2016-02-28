
;(function(){


    //十六进制公钥
    var rsa_n = "D46A5D6EA41E1A4DF1D7BCDB9BF049E0623C3466A934CC812B4099E664B85D7AD8EB01071EC3992F6569E35E833FDA06C0E56F1637169CE022AB1AF7B7CC96042E789E95959097A5AE90AA87D2AA2D84335BAE8EADD4C7372C6B16E727BE297B2B0BE5548502DAF59B7CBD35025431E024EA31FDEF833F7A441E6BB4F540AEC7";


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

