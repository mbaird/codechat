<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
</a>
<a class="brand" href="/"><?php echo $this->config->item('site_title'); ?></a>
<div class="nav-collapse">
  <ul class="nav">
  	<li class="<?php echo isActive($pageName,"pages/view");  echo isActive($pageName,"pages/home");?>" ><a  href="<?php echo  base_url()?>">Home</a></li>
  	<li class="<?php echo isActive($pageName,"pages/all")?>" ><a  href="<?php echo  base_url() . 'list'; ?>">View Code List</a></li>
  </ul>
</div>