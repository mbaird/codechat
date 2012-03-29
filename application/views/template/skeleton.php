<!doctype html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="en">
<!--<![endif]-->
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<title><?php echo $title ?></title>
<title><?php echo $description ?></title>

<meta name="viewport" content="width=device-width">
<meta name="keywords" content="<?php echo $keywords ?>" />
<meta name="author" content="<?php echo $author ?>" />

<link rel="stylesheet" href="<?php echo base_url(CSS."style.css");?>">
<link rel="stylesheet" href="<?php echo base_url(CSS."global.css");?>">

<!-- extra CSS-->
<?php foreach($css as $c):?>
<link rel="stylesheet" href="<?php echo base_url().CSS.$c?>">
<?php endforeach;?>

<!-- extra fonts-->
<?php foreach($fonts as $f):?>
<link href="http://fonts.googleapis.com/css?family=<?php echo $f?>"
	rel="stylesheet" type="text/css">
<?php endforeach;?>
<script src="<?php echo base_url(JS."libs/modernizr-2.5.3.min.js");?>"></script>

</head>
<body>
	<?php echo $body ?>
	<script
		src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="<?php echo base_url(JS."libs/jquery-1.7.1.min.js");?>"><\/script>')</script>
	<script src="<?php echo base_url(JS."libs/underscore-1.3.1.min.js");?>"></script>

	<!-- extra js-->
	<?php foreach($javascript as $js):?>
	<script src="<?php echo base_url().JS.$js?>"></script>
	<?php endforeach;?>

	<script src="<?php echo base_url(JS."mode/xml/xml.js");?>"></script>
	<script src="<?php echo base_url(JS."mode/javascript/javascript.js");?>"></script>
	<script src="<?php echo base_url(JS."mode/css/css.js");?>"></script>
	<script src="<?php echo base_url(JS."mode/clike/clike.js");?>"></script>
	<script src="<?php echo base_url(JS."mode/php/php.js");?>"></script>
	<script src="<?php echo base_url(JS."mode/perl/perl.js");?>"></script>
	<script src="<?php echo base_url(JS."mode/python/python.js");?>"></script>
	<script src="<?php echo base_url(JS."mode/ruby/ruby.js");?>"></script>
	<script src="<?php echo base_url(JS."mode/mysql/mysql.js");?>"></script>

	<script src="<?php echo base_url(JS."plugins.js");?>"></script>
	<script src="<?php echo base_url(JS."script.js");?>"></script>

	<?php if ($pusher) { ?>
		<script src="<?php echo base_url(JS."pusher_code.js");?>"></script>
		<script src="<?php echo base_url(JS."shorturl.js");?>"></script>
	<?php } ?>
	
</body>
</html>
