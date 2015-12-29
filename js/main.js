require.config({

		//baseUrl: "js/",
		paths: {

            'test': 'test/requireTest',  //测试rjs
			'jquery': 'jq/jquery.min',
			'Barrett': 'RSA/Barrett',
			'Biglnt': 'RSA/Biglnt',
			'RSA': 'RSA/RSA',

			'RSATest': 'test/RSATest'
        },


        shim: {
            'RSATest':{
                deps: ['jquery']    //声明依赖
            }
        }
    });


require(['jquery', 'test', 'Barrett', 'Biglnt', 'RSA', 'RSATest'],
	function($, test) {

    	test_require_js();
        $('#status').load('status.html');
	});