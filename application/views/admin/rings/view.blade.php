<?php
$attr_list = array(
	'id'=>'ID',
	'name'=>'Catalog Number',
	'display_picture'=>'Picture',
	'type_id'=>'Type',
	'price'=>'Value',
	'ring_size'=>'Ring Size (mm)',
);

$type_list = array();
$type_list['all'] = 'All';
foreach ($types as $id=>$type)
	$type_list[$type->id] = '('.($type->id).') '.$type->short_description;
?>
<legend>Rings</legend>
	{{ Form::open(URI::current(), 'GET', array('class'=>'form-inline', 'id'=>'view_form')) }}
		{{ Form::select('type_id', $type_list, $params['type_id']) }}
		{{ Form::text('name', $params['name'], array('class'=>'input-medium', 'placeholder'=>'Catalog Number')) }}
		{{ Form::hidden('page', $params['page'], array('id'=>'page')) }}
		{{ Form::hidden('sort', $params['sort'], array('id'=>'sort')) }}
		{{ Form::hidden('order', $params['order'], array('id'=>'order')) }}
		{{ Form::submit('Go', array('class'=>'btn')) }}
		<span class="inline pull-right">
@for ($i = 1; $i <= $count; $i++)
	{{ $i == $params['page'] ? $i : '<a href="javascript:void(0)" onClick="submitPage('.$i.')">'.$i.' </a>' }}
@endfor
		</span>
	{{ Form::close() }}
<table class="table table-hover">
	<thead>
		<tr>
			@foreach ($attr_list as $key=>$text)
			<td class="header_col">
				<a href="javascript:void(0)" onClick="submitSort('{{$key}}')">{{$text}}<?php
				if ($params['sort'] === $key)
				{
					if ($params['order'] === 'asc')
						echo '<i class="icon-chevron-down"> </i>';
					else
						echo '<i class="icon-chevron-up"> </i>';
				}
				else
					echo '<i class="icon-chevron-right"> </i>';
				?></a>
			</td>
			@endforeach
			<td>Edit</td>
			<td>Delete</td>
		</tr>
	</thead>
	<?php foreach ($entities as $e): ?>
	<tbody>
		<tr>
			<td><?php echo $e->id ?></td>
			<td><?php echo $e->name ?></td>
			<td>
			@if (isset($e->pictures[0]))
				<a href="{{ URL::to_asset($e->pictures[0]->url); }}" rel="lightbox"><img src="{{ URL::to_asset($e->pictures[0]->url); }}" class="ring_img"></a>
			@else
				<img class="ring_img">
			@endif
			</td>
			<td><?php echo $type_list[$e->type_id] ?></td>
			<td><?php echo '$'.$e->price ?></td>
			<td><?php echo $e->ring_size ?></td>
			<td><?php echo HTML::link_to_action('admin.rings@edit', 'Edit', array($e->id), array('class'=>'btn')) ?></td>
			<td><a href="javascript:void(0)" onClick="deleteItem({{ $e->id }}, '{{ $e->name }}')" class = "btn">Delete</a></td>
		</tr>
	</tbody>
	<?php endforeach; ?>
</table>
@for ($i = 1; $i <= $count; $i++)
	{{ $i == $params['page'] ? $i : '<a href="javascript:void(0)" onClick="submitPage('.$i.')">'.$i.' </a>' }}
@endfor
<script type = "text/javascript">
function deleteItem(id, name)
{
	var conf = confirm('Do you really want to delete "' + name + '?"');
	if (conf)
		window.location = '<?php echo URL::to_action('admin.rings@delete')?>/' + id;
}

function submitPage(page)
{
	$('#page').val(page);
	$('#view_form').submit();
}

function submitSort(sort)
{
	if (sort === $('#sort').val())
		$('#order').val($('#order').val() === 'asc' ? 'desc' : 'asc');
	else
	{
		$('#sort').val(sort);
		$('#order').val('asc');
	}

	$('#page').val(1);

	$('#view_form').submit();
}
</script>


