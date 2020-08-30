<!doctype html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Test</title>
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/css/bootstrap.min.css" rel="stylesheet" >
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/css/bootstrap-flex.min.css" rel="stylesheet" >
		<link href="/css/style.css" rel="stylesheet" >
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
		<script src="/js/bootstrap.min.js"></script>
		<script src="/js/script.js"></script>
	</head>
	<body>
	<div class="all-content">
		<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
			<a class="navbar-brand" href="#">Menu</a>
			<button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="navbar-collapse collapse" id="navbarColor01" style="">
				<ul class="navbar-nav mr-auto" style="list-style-type: none;">
					<li class="nav-item active">
						<a class="nav-link" href="/#" class="list-group-item">Home</a>
					</li>
					<?php if(isset($_SESSION['username'])):?>
					<li class="nav-item active">
						<a class="nav-link" href="/login"><?php echo $_SESSION['username'] . '\\'?>Logout</a>
					</li>
					<?php else:?>
					<li class="nav-item active">
						<a class="nav-link" href="/login">Login</a>
					</li>
					<li class="nav-item active">
						<a class="nav-link" href="/registration">Registration</a>
					</li>
					<?php endif;?>	
				</ul>
			</div>
		</nav>
		<div class="content">