<!DOCTYPE html>
<html>
<head>
<title>{{ $title }}</title>
<?php echo Asset::scripts(); ?>
<?php echo Asset::styles(); ?>
</head>
<body>
	<div class="container-fluid">
		<div class="row-fluid">
			<div class="span2">
				@if (isset($manager_menu))
					{{ $manager_menu }}
				@endif
				@if (isset($admin_menu))
					{{ $admin_menu }}
				@endif
				<br>
				{{ $user }}
			</div>
			<div class="span10">
				{{ $content }}
			</div>
		</div>
	</div>
</body>
</html>

