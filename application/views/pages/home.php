<div class="span9">
	
	<section id="typography">
		<div id="theEditor" class="editorArea"></div>
	</section>
</div>
 <div class="span3">
 	<?php echo $this->form_validation->error_string(); ?>
	<form class="well" action="<?=base_url()?>" method="post" >
			<div class="control-group">
		<label>Title</label>
		<input type="text" class="span2" placeholder="Untitled">
	</div>
	<input class="swapme" type="hidden" name="code" value="" />
			<div class="control-group">
		<label>Language</label>
		<?php $lang_extra = 'id="select01" class="select" tabindex="3"'; echo form_dropdown('lang', $languages, 'php', $lang_extra); ?>
	</div>
		<div class="control-group">
            <button type="submit" name="submit" value="submit" class="btn btn-primary">Save Code Snippet</button>
          </div>

		
	</form>

 </div>

