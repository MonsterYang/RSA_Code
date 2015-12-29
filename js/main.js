require.config({

		//baseUrl: "js/",

　　　　paths: {

　　　　　　'test': 'test/requireTest',  //测试rjs
			'jquery': 'jq/jquery.min',
			'Barrett': 'RSA/Barrett',
			'Biglnt': 'RSA/Biglnt',
			'RSA': 'RSA/RSA',

			'RSATest': 'test/RSATest'
　　　　}

　　});


require(['jquery', 'Barrett', 'Biglnt', 'RSA', 'RSATest', 'test'], 

	function() {

    	test_require_js();

	});