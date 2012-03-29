<div class="span9">
	
	<section id="typography">
		<div id="theEditor" class="editorArea"></div>
	</section>
</div>
 <div class="span3">
<?php echo validation_errors(); ?>
	<form class="well" action="<?=base_url()?>" method="post" >
			<div class="control-group">
		<label>Title</label>
		<input type="text" name="title" value="<?php echo set_value('title'); ?>" placeholder="Untitled">
	</div>
	<div class="control-group">
		<label>Description</label>
		<textarea rows="6" name="desc" placeholder="Type a short description"><?php echo set_value('desc'); ?></textarea>
	</div>
	<input class="swapme" type="hidden" name="code" value="" />
			<div class="control-group">
		<label>Language</label>
		<?php $lang_extra = 'id="select01" tabindex="3"'; echo form_dropdown('lang', $languages, 'text/x-php', $lang_extra); ?>
	</div>
		<div class="control-group">
            <button type="submit" name="submit" value="submit" class="btn btn-primary">Save Code Snippet</button>
          </div>

		
	</form>

 </div>

