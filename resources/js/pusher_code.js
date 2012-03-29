/* Some Global Var Stuff */
var has_chat = false;
var channel_name = 'presence-' + $('.dropPid').val();
var pid = $('.dropPid').val();

$(document).ready(function() {
  pusherEvents();

  


});

function pusherEvents() {

	pusher = new Pusher('04d8103e47702d3d06e3'); 
	Pusher.channel_auth_endpoint = '/chat/auth';

	channel = pusher.subscribe(channel_name); 

	$('#chat_widget_login_button').button();


	channel.bind('pusher:subscription_error', function(members) {  

			$('#chat_widget_login').slideDown(); //Hide Login
			$('#chat_widget_main_container').hide(); //Show Chat
			$('#chat_widget_container h4').html('Chat');

		});
	
	/* Pusher Events */
	pusher.connection.bind('connected', function() {

		channel.bind('pusher:subscription_succeeded', function(members) {  

			$('#chat_widget_login').hide(); //Hide Login
			$('#chat_widget_main_container').slideDown(); //Show Chat
			$('#chat_widget_container h4').html('Chat');

			var whosonline_html = '';
			members.each(function(member) {
				whosonline_html += '<li class="chat_widget_member" id="chat_widget_member_' +
				member.id + '">' + member.info.username + '</li>';
			});
			$('#chat_widget_online_list').html(whosonline_html);
			updateOnlineCount();

			// Get Chat History
			ajaxCall('/chat/history/', { pid : pid }, function(obj) {

				for (var i in obj.history) {
				    $('#chat_widget_messages').append('<strong>&lt;' + obj.history[i].username + '&gt;</strong> ' +  obj.history[i].message + '<br />');
				} 

			});

		});

	

		channel.bind('pusher:member_added', function(member) {
			$('#chat_widget_online_list').append('<li class="chat_widget_member" ' +
				'id="chat_widget_member_' + member.id + '">' + member.info.username + '</li>');
			updateOnlineCount();
		});

		channel.bind('pusher:member_removed', function(member) {
			$('#chat_widget_member_' + member.id).remove();
			updateOnlineCount();
		});

		channel.bind('new_message', function(data) {
			newMessageCallback(data);
		});

		channel.bind('new_revision', function() {
			$('.new-revision').fadeIn();
		});

	});

}

/* Pusher Chat */
$('#chat_widget_login_button').click(function() {

	$('#chat_widget_login_button').button('loading');

	// Get & Filter Username
	username = $('#chat_widget_username').val();
	username = username.replace(/[^a-z0-9]/gi, '');
	if( username == '' ) { 
		alert('Please provide a valid username (alphanumeric only)');
	} else { 

		ajaxCall('/chat/start/', { username : username }, pusherEvents());
	}
}); // END CLICK FUNCTION

	$('#chat_widget_input').keypress(function() {


		var value = $(this).val();
    	if ( value.length > 255 ) {
    		$('#chat_widget_input').tooltip('show');
    		$('#chat_widget_button').attr("disabled", true);
    		$('#chat_widget_button').addClass('disabled');
    		return false;
    	} else {
    		$('#chat_widget_input').tooltip('hide');
    		$('#chat_widget_button').removeClass("disabled");
    		$('#chat_widget_button').removeAttr('disabled');
    	}


	});

/* New Message */
$('#chat_widget_form').submit(function() {

	var chat_widget_input = $('#chat_widget_input'),
	chat_widget_button = $('#chat_widget_button'),
	message = chat_widget_input.val(); 

	$('#chat_widget_button').button('loading');
	ajaxCall('/chat/send/', { message : message, channel_name : channel_name }, function(msg) {
		chat_widget_input.val(''); 
		chat_widget_button.removeClass('disabled');
		chat_widget_button.removeAttr("disabled");   
		chat_widget_button.html('Send');
	});

	return false;
});

function updateOnlineCount() {
	$('#chat_widget_counter').html($('.chat_widget_member').length);
}

function newMessageCallback(data) {
	if( has_chat == false ) { //if the user doesn't have chat messages in the div yet
		has_chat = true; //and set it so it won't go inside this if-statement again
	}

	$('#chat_widget_messages').append(data.message + '<br />');
}

function ajaxCall(ajax_url, ajax_data, successCallback) {
	$.ajax({
		type : "POST",
		url : ajax_url,
		dataType : "json",
		data: ajax_data,
		time : 10,
		success : function(msg) {
			if( msg.success ) {
				successCallback(msg);
			} else {
				alert(msg.errormsg);
			}
		},
		error: function(msg) {
		}
	});
}

/* End Pusher Chat */