<script type="text/javascript">
var type_descriptions = new Array(
@foreach ($types as $tid=>$type)
@if ($tid < count($types) - 1)
"{{str_replace('"', '\\"', $type->description)}}", 
@else
"{{str_replace('"', '\\"', $type->description)}}"
@endif
@endforeach
);
</script>

<?php
$type_list = array();
foreach ($types as $type)
	$type_list[$type->id] = '('.($type->id).') '.$type->short_description;

echo Form::open_for_files('admin/rings/edit/' . $id, 'POST', array('id' => 'addForm', 'class' => 'form-horizontal'));

echo '<legend>Edit Ring</legend>';

echo '<div class = "control-group">';
echo Form::label('name', 'Catalog Number', array('class' => 'control-label'));
echo '<div class = "controls">';
echo Form::text('name', $name, array('class' => 'required'));
echo '</div></div>';

echo '<div class = "control-group">';
echo Form::label('display_picture', 'Pictures', array('class' => 'control-label'));
echo '<div class = "controls">';
echo Form::hidden('picture_count', 0);
echo Form::hidden('picture_moves', null);
echo '<input type="file" name="display_picture[]" id="display_picture" multiple />'; //manually entered for specail "multiple" property
echo '<div id="pictures-container">';
echo '<ul id="pictures-list">';
echo '</ul>';
echo '</div>';
echo '</div></div>';

echo '<div class = "control-group">';
echo Form::label('type_id', 'Type', array('class' => 'control-label'));
echo '<div class = "controls">';
echo Form::select('type_id', $type_list, $type_id);
echo '</div></div>';

echo '<div class = "control-group">';
echo Form::label('', 'Type Description', array('class' => 'control-label'));
echo '<div class = "controls">';
echo Form::textarea('', $types[$type_id-1]->description, array('disabled', 'id'=>'type_desc'));
echo '</div></div>';

echo '<div class = "control-group">';
echo Form::label('date', 'Date', array('class' => 'control-label'));
echo '<div class = "controls">';
echo Form::text('date', $date, array('class' => 'required'));
echo '</div></div>';

echo '<div class = "control-group">';
echo Form::label('origin', 'Origin', array('class' => 'control-label'));
echo '<div class = "controls">';
echo Form::text('origin', $origin, array('class' => 'required'));
echo '</div></div>';

echo '<div class = "control-group">';
echo Form::label('description', 'Attribution', array('class' => 'control-label'));
echo '<div class = "controls">';
echo Form::textarea('description', $description, array('class' => 'required'));
echo '</div></div>';

echo '<div class = "control-group">';
echo Form::label('source', 'Source', array('class' => 'control-label'));
echo '<div class = "controls">';
echo Form::text('source', $source, array('class' => 'required'));
echo '</div></div>';

echo '<div class = "control-group">';
echo Form::label('price', 'Value', array('class' => 'control-label'));
echo '<div class = "controls">';
echo Form::text('price', $price, array('class' => 'required'));
echo '</div></div>';

echo '<div class = "control-group">';
echo Form::label('quantity', 'Quantity', array('class' => 'control-label'));
echo '<div class = "controls">';
echo Form::text('quantity', $quantity, array('class' => 'required'));
echo '</div></div>';

echo '<div class = "control-group">';
echo '<div class = "controls">';
echo Form::submit('Submit', array('class' => 'submit', 'id' => 'addSubmit', 'class' => 'btn'));
echo '</div></div>';
echo Form::close();

	//protected $properties = array('id', 'name', 'type_id', 'description', 'price', 'quantity', 'display_picture');
?>
<?php echo HTML::script('js/jquery.validate.min.js'); ?>
<script ring = "text/javascript">
var uploads = new Array();
var upload_count = 0;

function addImage(type, id, src)
{
	var pic_cell = $('<li></li>');
	pic_cell.data('type', type);
	pic_cell.data('id', id);
	pic_cell.append('<img src="' + src + '" class="picture-icon">');
	pic_cell.append('<div class="picture-x"><i class="icon-remove"></i> </div>');

	$('#pictures-list').append(pic_cell);

	$('.picture-x').click(function() {
		$(this).parent().remove();
	});

	return pic_cell[0];
}

$('#display_picture').change( function()
{
	var input = this;

	if (input.files && input.files.length > 0)
	{
		for (var i = upload_count - 1; i >= 0; i--)
		{
			$(uploads[i]).remove();
		}
		for (var i = 0; i < input.files.length; i++)
		{
			(function(i) {
				var reader = new FileReader();

				reader.onload = function (e)
				{
					uploads[i] = addImage('uploaded', i, e.target.result);
				}
				reader.readAsDataURL(input.files[i]);
			})(i);
		}

		upload_count = input.files.length;
	}
});

$(document).ready(function()
{
	$('#type_id').change(function()
	{
		$('#type_desc').val(type_descriptions[$('#type_id').val() - 1]);
	});

	$('#addForm').validate({
		onkeyup: false,
		errorPlacement: function(error, element) {
			error.insertAfter($(element));
		},
		highlight: function(element, errorClass, validClass) {
			var con = $(element).parent().parent();
			con.addClass(errorClass);
		},
		unhighlight: function(element, errorClass, validClass) {
			var con = $(element).parent().parent();
			con.removeClass(errorClass);
		},
		errorElement: 'span',
		submitHandler: function(form) {

			//build image order array
			$('#pictures-list li').each(function(index, element) {
				$('#addForm').append('<input type="hidden" name="pictures[]" value="' + $(element).data('type') + ' ' + $(element).data('id') + '">');
			});

			form.submit();
		},
		rules: {
			name: {
				digits: true
			}
		}
	});

	$('#pictures-list').sortable();

	$('.picture-x').click(function() {
		$(this).parent().remove();
	});
});

@foreach ($pictures as $picture)
	addImage('old', {{ $picture->id }}, '{{ URL::to_asset($picture->url); }}');
@endforeach
</script>

