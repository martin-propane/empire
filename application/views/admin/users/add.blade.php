<?php
echo Form::open('admin/users/add', 'POST', array('id' => 'addForm', 'class' => 'form-horizontal'));
echo '<legend>Add User</legend>';

echo '<div class = "control-group">';
echo Form::label('email', 'Email', array('class' => 'control-label'));
echo '<div class = "controls">';
echo Form::text('email', null, array('class' => 'required'));
echo '</div></div>';

echo '<div class = "control-group">';
echo Form::label('password', 'Password', array('class' => 'control-label'));
echo '<div class = "controls">';
echo Form::password('password', array('class' => 'required'));
echo '</div></div>';

$admin_levels = array(
	0 => 'User',
	1 => 'Manager',
	2 => 'Admin'
);

echo '<div class = "control-group" id = "admin">';
echo Form::label('admin', 'Admin', array('class' => 'control-label'));
echo '<div class = "controls">';
echo Form::select('admin', $admin_levels);
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
		rules: {
			name: 'required',
		},
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


