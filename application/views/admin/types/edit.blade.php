<?php
echo Form::open('admin/types/edit/' . $id, 'POST', array('id' => 'addForm', 'class' => 'form-horizontal'));
echo '<legend>Edit Type</legend>';

echo '<div class = "control-group">';
echo Form::label('short_description', 'Short Description', array('class' => 'control-label'));
echo '<div class = "controls">';
echo Form::textarea('short_description', $short_description, array('class' => 'required'));
echo '</div></div>';

echo '<div class = "control-group">';
echo Form::label('description', 'Description', array('class' => 'control-label'));
echo '<div class = "controls">';
echo Form::textarea('description', $description, array('class' => 'required'));
echo '</div></div>';

echo '<div class = "control-group">';
echo '<div class = "controls">';
echo Form::submit('Submit', array('class' => 'submit', 'id' => 'addSubmit', 'class' => 'btn'));
echo '</div></div>';
echo Form::close();

?>
<?php echo HTML::script('js/jquery.validate.min.js'); ?>
<script type = "text/javascript">
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

