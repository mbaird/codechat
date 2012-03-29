<div class="span9">

<h2>Code List</h2>
<table class="table table-striped table-bordered" id="code_list_table" >
	<thead>
	<tr>
		<th>Title</th>
		<th>Description</th>
		<th>Language</th>
		<th>Created</th>
		<th>Link</th>
	</tr>
</thead>
<tbody>

<?php  foreach($pastes as $p):?>
<tr>
	<?php echo '<td>' . $p['title'] . '</td><td>' . $p['description'] . '</td><td>'. $p['pretty'] . '</td><td> ' . date('jS M Y H:i', $p['created']) . '</td><td><a href="/view/' . $p['pid'] . '/">View Paste</a></td>'; ?>
</tr>
<?php endforeach;?>
</tbody>
</table>

<?php echo $links;?>

</div>
 <div class="span3">
 </div>

