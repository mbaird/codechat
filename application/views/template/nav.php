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
  	<li class="dropdown">
	    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Copy Link<b class="caret"></b></a>
	    <ul class="dropdown-menu">
	      <li><input type="text" /></li>
	      <li><a href="#">Another action</a></li>
	      <li><a href="#">Something else here</a></li>
	      <li class="divider"></li>
	      <li><a href="#">Separated link</a></li>
	    </ul>
	  </li>

  </ul>
</div>