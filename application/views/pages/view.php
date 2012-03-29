<div class="span9">

	<section id="typography">
		<div id="theViewer" class="editorArea"></div>
	</section>
		<form>
		<input type="hidden" name="code" class="dropCode" value="<?php if(isset($raw)){ echo $raw; }?>" />
		<input type="hidden" name="code" class="dropPid" value="<?php if(isset($pid)){ echo $pid; }?>" />
		<input type="hidden" name="lang" class="dropLang" value="<?php if(isset($lang_code)){ echo $lang_code; }?>"/>
	</form>
	
</div>
 <div class="span3">
	<form class="well" action="<?=base_url() . 'view/' . $pid . '/'  ?>" method="post" >
	<input class="swapme" type="hidden" name="code" value="" />
		<input type="hidden" name="lang" class="dropLang" value="<?php if(isset($lang_code)){ echo $lang_code; }?>"/>
		<label>Revision</label>
		<?php $rev_extra = 'id="select02" class="select" tabindex="3"';  echo form_dropdown('rev_select', $revs, $rev, $rev_extra); ?>

            <button type="submit" name="submit" value="submit" class="btn btn-primary">Save New Revision</button>
   

		
	</form>

	<div id="chat_widget_container" class="well" >
	 	<h4>Chat</h4>


     	<div id="chat_widget_login">
         	<label for="chat_widget_username">Name:</label>
         	<input type="text" id="chat_widget_username" />
         	<button type="button" class="btn btn-primary" data-loading-text="Loading..." id="chat_widget_login_button">Login</button>
         </div>

 
      	<div id="chat_widget_main_container" >
         	<div id="chat_widget_messages_container" class="chat-messages" >
            	<div id="chat_widget_messages"></div>
         	</div>
         
	         <div id="chat_widget_online">
	            <p>Who's Online (<span id="chat_widget_counter">0</span>)</p>
	            <ul id="chat_widget_online_list"></ul>
	         </div>

         	<div class="clear"></div>

	         <div id="chat_widget_input_container">
	            <form method="post" id="chat_widget_form">
	               <input type="text" id="chat_widget_input" placeholder="Type a message here..." />
	               <input type="hidden" id="channel_name" value="presence-<?php if(isset($pid)){ echo $pid; }?>" />
	               <button type="submit"id="chat_widget_button" data-loading-text="Sending..." class="btn btn-secondary" >Send</button>
	            </form>
	         </div>

      	</div>
   </div>

 </div>

