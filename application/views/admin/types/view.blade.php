<legend>Types</legend>
<table class="table table-hover">
	<thead>
		<tr>
			<td>ID</td>
			<td>Short Description</td>
			<td>Edit</td>
			<td>Delete</td>
		</tr>
	</thead>
	<?php foreach ($entities as $entity): ?>
	<tbody>
		<tr>
			<td>{{ $entity->id }}</td>
			<td>{{ $entity->short_description }}</td>
			<td>{{ HTML::link_to_action('admin.types@edit', 'Edit', array($entity->id), array('class'=>'btn')) }}</td>
			<td><a href="javascript:void(0)" onClick="deleteItem({{ $entity->id }}, '{{ $entity->id }}')" class = "btn">Delete</a></td>
		</tr>
	</tbody>
	<?php endforeach; ?>
</table>

<script type = "text/javascript">
function deleteItem(id, name)
{
	var conf = confirm('Do you really want to delete "' + name + '?"');
	if (conf)
		window.location = '{{ URL::to_action('admin.entitys@delete') }}/' + id;
}
</script>



