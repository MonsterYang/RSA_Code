<?php

class RSA {

private static $PRIVATE_KEY = '-----BEGIN RSA PRIVATE KEY-----
MIICXQIBAAKBgQDUal1upB4aTfHXvNub8EngYjw0Zqk0zIErQJnmZLhdetjrAQce
w5kvZWnjXoM/2gbA5W8WNxac4CKrGve3zJYELnielZWQl6WukKqH0qothDNbro6t
1Mc3LGsW5ye+KXsrC+VUhQLa9Zt8vTUCVDHgJOox/e+DP3pEHmu09UCuxwIDAQAB
AoGBAKOfh3c53qJelkOcDAKz9wRsR3oJ9p9gRMO/kI1j2ozPm5ZzBTwSacaTtRxa
6nleBkPCuG6BYt7W3H23WUhwxMDtRg7GQFezF6LrZLcQe5z9c4uyp2rugNGECtse
0ftPmEzTokEu8OK5W1zoTVTu9KoNDmxJ5B4Dh4h+xCR9wiGRAkEA/fOPeNUunhDs
hd/EKx3l5cXO1EapjYQ0JAcb7GI68/Jgg3d2Q3gLscC7xxrON+Rf11z8STnfzFCf
mn9S65UOqQJBANYhByjOAPLyTYuseQiUEQI/hRU2AvsHzXaaIgcsui+mHA9ZIPBZ
kRP2ogJy9deVF/5cONff/KvLAI7K2iPiZ+8CQQDgEGYmVvIqxQPrmuOap2aQtVco
NLClDGB06VDZ4FHjq5c8Z8sQ/HpU+5iytBP/fKCThJeUhFvSCdDIoE6pTXsBAkAy
jGNzR4ZD091ofpOn6cRGIpaZFkIH3qSrPeGQjgd53h27pc+3zX0JGGzQZTER7llW
q5CjrXWpXGfKTarHU9gzAkBfJYDaT0is9JvQpl+byMoT4Jh751+TRf3HP7rmMpuc
qrvdGYlTTW0FoyOLinOAOeyS74eo9lS5TJf9Rpl1o+wo
-----END RSA PRIVATE KEY-----';

    private static $PUBLIC_KEY = '-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDUal1upB4aTfHXvNub8EngYjw0
Zqk0zIErQJnmZLhdetjrAQcew5kvZWnjXoM/2gbA5W8WNxac4CKrGve3zJYELnie
lZWQl6WukKqH0qothDNbro6t1Mc3LGsW5ye+KXsrC+VUhQLa9Zt8vTUCVDHgJOox
/e+DP3pEHmu09UCuxwIDAQAB
-----END PUBLIC KEY-----';


	/*
	 *  十六进制公钥：
     *  D46A5D6EA41E1A4DF1D7BCDB9BF049E0623C3466A934CC812B4099E664B85D7AD8EB01071EC3992F6569E35E833FDA06C0E56F1637169CE022AB1AF7B7CC96042E789E95959097A5AE90AA87D2AA2D84335BAE8EADD4C7372C6B16E727BE297B2B0BE5548502DAF59B7CBD35025431E024EA31FDEF833F7A441E6BB4F540AEC7
	 *	十六进制密钥：
	 *	A39F877739DEA25E96439C0C02B3F7046C477A09F69F6044C3BF908D63DA8CCF9B9673053C1269C693B51C5AEA795E0643C2B86E8162DED6DC7DB7594870C4C0ED460EC64057B317A2EB64B7107B9CFD738BB2A76AEE80D1840ADB1ED1FB4F984CD3A2412EF0E2B95B5CE84D54EEF4AA0D0E6C49E41E0387887EC4247DC22191
	 */


	/**
    *返回对应的私钥
    */
    private static function getPrivateKey() {

        return openssl_pkey_get_private(self::$PRIVATE_KEY);
    }

    /**
    *返回对应的公钥
    */
    private static function getPublicKey() {

        return openssl_pkey_get_public(self::$PUBLIC_KEY);
    }




    /**
     * 私钥加密  (加密后无法密钥解密，未解决)
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    public static function privEncrypt($data) {

        if(!is_string($data)) return null;

        return openssl_private_encrypt($data, $encrypted, self::getPrivateKey())? base64_encode($encrypted) : null;
    }

    /**
     * 公钥加密
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    public static function encrypt($data){

        if (openssl_public_encrypt($data, $encrypted, self::getPublicKey()))
            $data = base64_encode($encrypted);
        else
            throw new Exception('Unable to encrypt data. Perhaps it is bigger than the key size?');

        return $data;
    }
    
    /**
     * 私钥解密
     * @param  [type]  $encrypted 密文（二进制格式且base64编码）
     * @param  boolean $fromjs    密文是否来源于JS的RSA加密
     * @return [type]             [description]
     */
    public static function privDecrypt($encrypted, $fromjs = FALSE) {

        if(!is_string($encrypted)) return null;

        $padding = $fromjs ? OPENSSL_NO_PADDING : OPENSSL_PKCS1_PADDING;  
        if (openssl_private_decrypt(base64_decode($encrypted), $decrypted, self::getPrivateKey(), $padding)) {
            return $fromjs ? trim(strrev($decrypted)) : $decrypted;
        }
        return null;
    }

}