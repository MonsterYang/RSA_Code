<?php
/*
 *  #1.在c盘建立C:\openssl-1.0.1l-win64\ssl 文件夹，把apache/conf/openssl.cnf copy进去。
 *
 *	#2.启动命令行工具，cd 到 bin 目录
 *	      运行openssl genrsa -des3 -out private_key.pem 2048，生成密钥。
 *
 *	#3.运行 openssl rsa -in private_key.pem -pubout -out public_key.pem
 *	      分离公钥
 *
 *	#4.运行 openssl asn1parse -out temp.ans -i -inform PEM < private_key.pem
 *	      生成16进制的两个钥
 *	   4:d=1  hl=2 l=   1 prim:  INTEGER           :00
 *	   7:d=1  hl=3 l= 129 prim:  INTEGER           :CCA66E51897478C3DEFF551B6F5FEF169004739EA1889A77DD0E4A4F0EB482455F42DBB8D9E881ED6D86D3996D11E6830C891756D24C1580395CB228ECD3C21FB454BDE249405B8C1D81958B953D62A6B9CDD109FBACD75FD762156DFB2DF051CD2DD5DC53906B404853537DEE00C218B7045D300227AD5AF9F57AE98A9E25CEF5ADC15812CF54C74A6BF8E77E9EA3D807BF38F4BF5B8520872C083F5513C64FF17DCFFAA2AAB10D09C8E727A3043D969B7A92FC97C425D358E8F9E44850F983F0D5FE7DE0916844C5C78815DB22ED0BC55F5D332467DCD001163A39A67B715574DD4E84B627D3A406E5C580C0F59E2D1FD3ADD370C2A2E828F888C096860313 #公匙
 *	   139:d=1  hl=2 l=   3 prim:  INTEGER           :010001 #十六进制e值
 *	   144:d=1  hl=3 l= 128 prim:  INTEGER           :A5A917E6430998749E003CA98FB7ADB7AAEF1F94CA97E4CAA093DFCD2D4F2BA0F26311B00A1D2F87BDC0856B4E224E61C8F4F482A08B5C60468EE5DD41108DB4D26A42A779BA7220F305A1C3B31454D637D406A2392B89D0986E5A8083F284F602CC56B11AA7EE59C3F247C4C9B3AD6B0A43AB17A0B6F39A907A897BA16D31966A1B1D6C93146714132A6AD95EC89DDECB49A96C789A8B6828986D38DD2F7DDE4948F4865796A8A31EB8B606A7A0169A26EBDDE2AAE2BB58CA3774EFF23B58703FE5EF5EB9E3909F49BF897CE46263D10CA9359B8D9C6174A405E9EBACF9D2C929B4D84D55E52D092BCDA67A3379295EF5099F871C5EED175717D29EA5AFAB19 #密匙
 *
 *  #5. 注意：这里把公钥和私钥复制粘贴到对象属性后，不要去修改它，即使是排版，会导致密钥公钥失效
 *
 *
 */


class RSA {

	private static $PRIVATE_KEY = '-----BEGIN RSA PRIVATE KEY-----
MIICXAIBAAKBgQDSQQkWmtx8CMQQ4xTIGhOQMkRjcJ98JlT9Tu0vpi+CuwsvgHVz
7YfHlVauW4XG+3SrwsGvBvg1Ll8/2fYkHJwN/jAPyoTGD+BXPMlqVnwQnsjvVrmX
3omPowbHngY4QgYhN8t7sZkVaUA8JHqqnb1ruPrhy7abAA9h3sPRvMoBXQIDAQAB
AoGAZK3Lwk1JgwNXj5aNXvxNneDUKqHFXNemHt3qacS0P299fbOPioGVYRa7uSYO
OygxyAWsZTl7JUwdRCAE42nnt1Vcu76VdFWg40CXPP+/deOUpNXM+/gjQC7mia6e
CFTx4FDhLhgFY3Ba5oxZpAbZQaAeB3Cryqjw85r35AErWoECQQDtzed2YGSO5yrf
GJ+Jj+3q3KGkXZvJwY4N+lmdbTgbDhQSI1ETOjZLzjUaghZTM5iikJWxRcjhSqV2
RtBoY3pRAkEA4ld6ew9kZihdm/HottxURp+7wTDyhxdT13YdM1sw+a00KqdHC8il
ioqn6Wu+jz8+k5Iw9zCotN7V7PRf7qYHTQJBANfO27Z3BesV6Lcr7mR1pNFWRq8W
cHHpYJRY1Qjj/F25KgfH2yTa2Dl1OoYC9mWtVmB5XA/Tp9ik2IH9A9coJ/ECQATM
D9d92wXjQyCj/uepQcwBZKxSikFcuDUv1qyY+S/BgQKKaxIP3ZpTF/31f6Nvlrbv
+UOz709uDaCpCUN4l10CQFVd8N831z7pqY8V0OAkXppfoEAqyWaDZBCa3dEp1k5h
6Jt0SLNE58kjSieXP3MqcK6vMmnkEyJ6mD58uq5RDAU=
-----END RSA PRIVATE KEY-----';

	private static $PUBLIC_KEY = '-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDSQQkWmtx8CMQQ4xTIGhOQMkRj
cJ98JlT9Tu0vpi+CuwsvgHVz7YfHlVauW4XG+3SrwsGvBvg1Ll8/2fYkHJwN/jAP
yoTGD+BXPMlqVnwQnsjvVrmX3omPowbHngY4QgYhN8t7sZkVaUA8JHqqnb1ruPrh
y7abAA9h3sPRvMoBXQIDAQAB
-----END PUBLIC KEY-----';

	/*
	 *  十六进制公钥：
     *  D24109169ADC7C08C410E314C81A1390324463709F7C2654FD4EED2FA62F82BB0B2F807573ED87C79556AE5B85C6FB74ABC2C1AF06F8352E5F3FD9F6241C9C0DFE300FCA84C60FE0573CC96A567C109EC8EF56B997DE898FA306C79E063842062137CB7BB1991569403C247AAA9DBD6BB8FAE1CBB69B000F61DEC3D1BCCA015D
	 *	十六进制密钥：
	 *	64ADCBC24D498303578F968D5EFC4D9DE0D42AA1C55CD7A61EDDEA69C4B43F6F7D7DB38F8A81956116BBB9260E3B2831C805AC65397B254C1D442004E369E7B7555CBBBE957455A0E340973CFFBF75E394A4D5CCFBF823402EE689AE9E0854F1E050E12E180563705AE68C59A406D941A01E0770ABCAA8F0F39AF7E4012B5A81
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