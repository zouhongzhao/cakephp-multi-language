<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
	<?php echo $this->Html->charset(); ?>
	<title>
		PGW -
		<?php echo $this->fetch('title'); ?>
	</title>
		<link href="/js/plugins/jquery-ui-1.11.2/jquery-ui.css" type="text/css" rel="stylesheet">
	<?php
		echo $this->Html->meta('icon');
		echo $this->Html->css('bootstrap.min');
        //echo $this->Html->css('sbadmin2/plugins/metisMenu/metisMenu.min');
        //echo $this->Html->css('sbadmin2/plugins/timeline');
        echo $this->Html->css('sbadmin2/sb-admin-2');
        echo $this->Html->css('style');
//         echo $this->Html->css('jquery-ui.css');
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>

	    <!-- jQuery -->
    <script src="/js/jquery.js"></script>
	<!-- Custom Fonts -->
    <link href="/fonts/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
    <div id="wrapper">

    <!-- Navigation -->
	    <?php echo $this->Session->flash(); ?>
	    <?php echo $this->fetch('content'); ?>

 <!-- Bootstrap Core JavaScript -->
    <script src="/js/bootstrap.min.js"></script>
     <script src="/js/plugins/jquery-ui-1.11.2/jquery-ui.min.js"></script>
	<?php echo $this->element('sql_dump'); ?>
</body>
</html>
