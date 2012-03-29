


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


