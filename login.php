<?php
require_once 'fbconfig.php';
$helper = $fb->getRedirectLoginHelper();
$permissions = ['email','user_photos'];
$loginUrl = $helper->getLoginUrl('https://mehulranartchallenge.herokuapp.com/fb-callback.php',$permissions);

?>
<html>
<head>
    <link href="assets/css/homepage_style.css" type="text/css" rel="stylesheet"/>
    <link href="lib/bootstrap/dist/css/bootstrap.min.css" type="text/css" rel="stylesheet"/>
    <script src="lib/bootstrap/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        body
        {
            text-align:center;
            width:100%;
            margin:0 auto;
            padding:0px;
            font-family:"lucida grande",tahoma,verdana,arial,sans-serif;
            background: linear-gradient(white, #D3D8E8);
            background-image: linear-gradient(to bottom, #FFFFFF 0%, #D3D8E8 100%);
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
        .navbar-default{
            background-color:#4c66a4;
            border-bottom:none;
        }
        .navbar-default .navbar-brand{
                color:#fff;
                font-size:30px;
                font-weight:bold;
        }
        #home{
                margin-top:50px;
        }
        #home .slogan{
                color: #0e385f;
                line-height: 29px;
                font-weight:bold;
        }
        .navbar-brand{
                padding:35px 15px;
        }

    </style>
</head>
<body>
    <div id="wrap">
      <div class="navbar navbar-default navbar-fixed-top">
        <div class="container">
          <div class="navbar-header">
            <a class="navbar-brand" href="https://mehulranartchallenge.herokuapp.com">Facebook Album Downloader</a>
          </div>
        </div>
      </div>
      <div class="container" id="home">
		<div class="row">
			<div class="col-md-12">
				<h3 class="slogan">
					Facebook helps you connect and share with the people in your life.
				</h3>
				<img src="assets/images/facebook.png" class="img-responsive" style="width:inherit" />
                <?php

echo '<a href="' . htmlspecialchars($loginUrl) . '" class="btn btn-primary"><i class="fa fa-facebook"></i>&nbsp;&nbsp;&nbsp;Sign in with Facebook!</a>';
        ?>

			</div>
		</div>
		<div>
		    <h4 style="color:blue">Develop By Mehul Rana</h4>
		    <h5 style="color:blue">Email Id: ranamehulj@gmail.com</h5>
		</div>
      </div>
    </div>
</body>
</html>
