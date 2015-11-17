<link href="style.css" rel="stylesheet" type="text/css" media="screen" />
<script src="http://code.jquery.com/jquery-1.8.3.min.js"></script>
<script src="bin/jsencrypt.js"></script>
</head>
<body>
<div id="header">
	<div id="menu">
		<ul>
        <?php
					if(!valid_session()){?>
				<li><a href="index.php">Login</a></li>
				<li><a href="register.php">Register</a></li>
        <?php
			}else{
		?>
        		<li><a href="members.php">Main</a></li>
				<li><a href="post.php">Post</a></li>
                <li><a href="logout.php">logout</a></li>
        <?php }?>
		</ul>
	</div>
	<!-- end #menu -->
</div>
<!-- end #header -->
<div id="logo">
	<h1><a href="#">hackme </a></h1>
	<p><em>an information security bulletin board</em></p>
</div>
<hr />
<!-- end #logo -->
<div id="page">
	<div id="page-bgtop">
		<div id="page-bgbtm">
			<div id="content">
