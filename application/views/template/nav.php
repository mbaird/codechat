<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
</a>
<a class="brand" href="/"><?php echo $this->config->item('site_title'); ?></a>
<div class="nav-collapse">
  <ul class="nav">
  	<li class=" active"><a class="<?php echo isActive($pageName,"home")?>" href="<?php echo  base_url()?>">Home</a></li>
  	<li><a class="<?php echo isActive($pageName,"code")?>" href="<?php echo  base_url()?>">Code</a></li>
  </ul>
</div>