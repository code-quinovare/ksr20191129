require.config({
	
	urlArgs: "v=" +  (new Date()).getHours(),//getHours 
    baseUrl: '/addons/zofui_task/public/js/app/',
    paths: {
        'jquery': '/app/resource/js/lib/jquery-1.11.1.min',
		'index':  'index',
		'webuploader' : '/web/resource/components/webuploader/webuploader.min',
		'makeVoice':  'makeVoice',
		'bootstrap' : '/web/resource/js/lib/bootstrap.min',
		'lazyLoad' : '/addons/zofui_task/public/js/lib/jquery.lazyload'
    },
	shim:{
		'bootstrap': {
			exports: "$",
			deps: ['jquery']
		},
		'lazyLoad': {
			exports: "lazyLoad",
			deps: ['jquery']
		}		
	}	
});
