<!DOCTYPE html>
<html lang="zh_CN">

<head>
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>机台状态查询</title>
</head>
<style>
	* {
		padding: 0;
		margin: 0;
	}

	iframe {
		width: 100%;
		height: 98vh;
	}

	div {
		font-size: 0.8rem;
	}

	a {
		text-decoration: none;

	}
</style>
<?php
include(dirname(__DIR__) . '/www/config/common_config.php');
// var_dump($status_name);
?>

<body>
	<div><a href="http://<?php echo $status_name; ?>:<?php echo $status_password; ?>@<?php echo $status_url; ?>">也可以点此打开：http://<?php echo $status_name; ?>:<?php echo $status_password; ?>@<?php echo $status_url; ?></a></div>
	<iframe src="http://<?php echo $status_name; ?>:<?php echo $status_password; ?>@<?php echo $status_url; ?>" sandbox="allow-same-origin allow-scripts allow-popups allow-forms " frameborder="0" width="100%" style="display:block;width:100%;height:100vh;"></iframe>
</body>