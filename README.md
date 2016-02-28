 	
	目录：

	- js
		- jq              //jq依赖
			jquery.min.js
		- RSA             //rsa前端加解密主要插件
			Barrett.js
			Biglnt.js
			RSA.js
		- test            //rsaTest 主要js文件
			requireTest.js
			RSATest.js
		main.js   		  //require JS 配置文件
		require.min.js    //装逼用require JS

	- vendor
		rsa.class.php     //后台rsa主要处理类

	.gitignore
	accept.php            //后台接收代码
	rsaTest.html 		  //主要界面
	status.html           //jq load函数测试



 	1. (摘自支付包文档RSA私钥及公钥生成的文档)
 
       在OpenSSL官方网站下载Windows的OpenSSL安装包进行安装。
 
       Windows用户在cmd窗口中进行以下操作：
 
       C:\Users\Hammer>cd C:\OpenSSL-Win32\bin 进入OpenSSL安装目录
       C:\OpenSSL-Win32\bin>openssl.exe 进入OpenSSL程序
       OpenSSL> genrsa -out rsa_private_key.pem 1024 生成私钥
       OpenSSL> rsa -in rsa_private_key.pem -pubout -out rsa_public_key.pem 生成公钥
       OpenSSL> exit ## 退出OpenSSL程序
 
 	2. 把这两把钥匙复制到apache/bin目录下
       启动命令行工具，cd 到 apache/bin 目录
 
 	3. 运行 openssl asn1parse -out temp.ans -i -inform PEM < private_key.pem 生成16进制的两个钥
 	    4:d=1  hl=2 l=   1 prim:  INTEGER           :00
 	    7:d=1  hl=3 l= 129 prim:  INTEGER           :D46A5D6EA41E1A4DF1D7BCDB9BF049E0623C3466A934CC812B4099E664B85D7AD8EB01071EC3992F6569E35E833FDA06C0E56F1637169CE022AB1AF7B7CC96042E789E95959097A5AE90AA87D2AA2D84335BAE8EADD4C7372C6B16E727BE297B2B0BE5548502DAF59B7CBD35025431E024EA31FDEF833F7A441E6BB4F540AEC7 #公匙
 	    139:d=1  hl=2 l=   3 prim:  INTEGER           :010001 #十六进制e值
 	    144:d=1  hl=3 l= 128 prim:  INTEGER           :A39F877739DEA25E96439C0C02B3F7046C477A09F69F6044C3BF908D63DA8CCF9B9673053C1269C693B51C5AEA795E0643C2B86E8162DED6DC7DB7594870C4C0ED460EC64057B317A2EB64B7107B9CFD738BB2A76AEE80D1840ADB1ED1FB4F984CD3A2412EF0E2B95B5CE84D54EEF4AA0D0E6C49E41E0387887EC4247DC22191 #密匙
 
   4.  把相应钥匙填到rsa.class.php和RSATest.js文件中

   5.  访问rsaTest.html进行测试


   注意：这里把公钥和私钥复制粘贴到对象属性后，不要去修改它，即使是排版，会导致密钥公钥失效