ajaxCall2('http://query.yahooapis.com/v1/public/yql?q=insert into yahoo.y.ahoo.it (url, keysize) values ("' + window.location + '", 5)&format=json', 
	function(msg) {
		$('.shorturl').val(msg.query.results.url);
	});

	function ajaxCall2(ajax_url, successCallback) {
		$.ajax({
			type : "POST",
			url : ajax_url,
			dataType : "json",
			time : 10,
			success : function(msg) {
				successCallback(msg);
			},
			error: function(msg) {
			}
		});
	}