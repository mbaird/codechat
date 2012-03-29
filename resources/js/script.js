
$('.dropdown-toggle').dropdown();

/* CodeMirror Stuff */

	$('.alert').alert();

		/* New Paste Editor */
		if ($('#theEditor').length != 0) {
			var Editor = CodeMirror.fromTextArea(document.getElementById('theEditor'), {
				theme: 'default',
				mode: "application/x-httpd-php",
				lineNumbers: true,
				onChange: function () {
				//Something
				}
			});
			Editor.setValue("<?php\n\n\tif (is_array($model))\n\t{\n\t\tforeach($model as $babe)\n\t\t{\n\t\t\t$this->model($babe);\n\t\t}\n\t\treturn;\n\t}\n\n?>");
		}

		/* View Paste Editor */
		if ($('#theViewer').length != 0) {
			var Editor = CodeMirror.fromTextArea(document.getElementById('theViewer'), {
				theme: 'default',
				mode: "application/x-httpd-php",
				lineNumbers: true/*,
				readOnly: "nocursor"*/
			});
			Editor.setValue($('.dropCode').val());
			Editor.setOption("mode", $('.dropLang').val());
		}

		Editor.focus();

	/* Editor Language Changing */
	$('#select01').change(function() {
		Editor.setOption("mode", this.value);
	});

	/* Revision Changing */
	$("#select02").change(function(){
	 	window.location = $(this).find("option:selected").val();
	});

	/* On click, fill new box */
	$('.well button').click(function() {
		$('.swapme').val(Editor.getValue());
	});


	/* URL Shorten */

	//alert(window.location);

	ajaxCall('http://query.yahooapis.com/v1/public/yql?q=insert into yahoo.y.ahoo.it (url, keysize) values ("' + 'http://www.google.com' + '", 5)&format=json', 
	function(msg) {
		//alert(msg.query.results.url);
		$('.shorturl').val(msg.query.results.url);
	});

	function ajaxCall(ajax_url, successCallback) {
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

	/*
	var short = function(){
		var x = document.getElementById('shortform');
		x.onsubmit = function(){
			//var url = document.getElementById('url').value;
			var url = 'http://localhost/view/12567313/1';
			var service = 
			var jp = document.createElement('script');
			jp.setAttribute('type','text/javascript');
			jp.setAttribute('src',service);
			document.getElementsByTagName('head')[0].appendChild(jp);
			return false;
		}
		return {
			shorter:function(o){
				document.getElementById('output').innerHTML = 'Your shorter URL: <input type="text" value="'+o.query.results.url+'">';
			}
		}
	}()
	*/


