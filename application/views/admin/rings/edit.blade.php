<?php
$type_list = array();
foreach ($types as $type)
	$type_list[$type->id] = $type->short_description;

echo Form::open_for_files('admin/rings/edit/' . $id, 'POST', array('id' => 'addForm', 'class' => 'form-horizontal'));

echo '<legend>Edit Ring</legend>';

echo '<div class = "control-group">';
echo Form::label('name', 'Name', array('class' => 'control-label'));
echo '<div class = "controls">';
echo Form::text('name', $name, array('class' => 'required'));
echo '</div></div>';

echo '<div class = "control-group">';
echo Form::label('display_picture', 'Display Picture', array('class' => 'control-label'));
echo '<div class = "controls">';
echo Form::file('display_picture', array('onchange'=>'setImage(this)'));
echo Form::hidden('display_changed', false, array('id'=>'display_changed'));
if ($display_picture !== null)
	echo '<br><img id="display_preview" src="' . URL::to_asset($display_picture) . '">';
else
	echo '<br><img id="display_preview" style="display: none;">';
echo '</div></div>';

echo '<div class = "control-group">';
echo Form::label('type_id', 'Type', array('class' => 'control-label'));
echo '<div class = "controls">';
echo Form::select('type_id', $type_list, $type_id);
echo '</div></div>';

echo '<div class = "control-group">';
echo Form::label('description', 'Description', array('class' => 'control-label'));
echo '<div class = "controls">';
echo Form::textarea('description', $description, array('class' => 'required'));
echo '</div></div>';

echo '<div class = "control-group">';
echo Form::label('price', 'Price', array('class' => 'control-label'));
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
function setImage(input)
{
	if (input.files && input.files[0])
	{
		var reader = new FileReader();

		reader.onload = function (e)
		{
			$('#display_preview').attr('src', e.target.result);
			$('#display_preview').show();
			$('#display_changed').val(true);
		}

		reader.readAsDataURL(input.files[0]);
	}
}

$(document).ready(function()
{
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
		errorElement: 'span'
	});
});
</script>




