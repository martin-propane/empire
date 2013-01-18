<legend>Users</legend>
<table class="table table-hover">
	<thead>
		<tr>
			<td>ID</td>
			<td>Email</td>
			<td>Admin Level</td>
			<td>Edit</td>
			<td>Delete</td>
		</tr>
	</thead>
	<?php foreach ($users as $user): ?>
	<tbody>
		<tr>
			<td><?php echo $user->id ?></td>
			<td><?php echo $user->email ?></td>
			<td><?php 
				switch ($user->admin)
				{
					case 0:
						echo 'User';
						break;
					case 1:
						echo 'Manager';
						break;
					case 2:
						echo 'Admin';
						break;
				}
			?></td>
			<td><?php echo HTML::link_to_action('admin.users@edit', 'Edit', array($user->id), array('class'=>'btn')) ?></td>
			<td><a href="javascript:void(0)" onClick="deleteItem({{ $user->id }}, '{{ $user->email }}')" class = "btn">Delete</a></td>
		</tr>
	</tbody>
	<?php endforeach; ?>
</table>

<script type = "text/javascript">
function deleteItem(id, name)
{
	var conf = confirm('Do you really want to delete "' + name + '?"');
	if (conf)
		window.location = '<?php echo URL::to_action('admin.users@delete')?>/' + id;
}
</script>



