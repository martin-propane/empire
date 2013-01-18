<!DOCTYPE html>
<html>
<head>
<title>{{ $title }}</title>
<?php echo Asset::scripts(); ?>
<?php echo Asset::styles(); ?>
</head>
<body>
{{ $content }}
</body>
</html>

