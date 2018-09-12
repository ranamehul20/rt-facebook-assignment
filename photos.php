<?php 
require_once 'fbconfig.php';
if (isset($_GET['useralbumid'])) {
if(isset($_SESSION['fb_access_token'])){
    $access_token=$_SESSION['fb_access_token'];
    if(isset($access_token)) {
        try {
            $response = $fb->get('/me',$access_token);
            $fb->setDefaultAccessToken($_SESSION['fb_access_token']);
            $fb_user = $response->getGraphUser();

            $id=$fb_user['id'];
            $name=$fb_user['name'];
            $str="https://graph.facebook.com/".$id."/picture?type=square";
            
            $_SESSION["uid"]=$id;
            $_SESSION['uname']=$name;

            //  var_dump($fb_user);
        } catch (\Facebook\Exceptions\FacebookResponseException $e) {
            echo  'Graph returned an error: ' . $e->getMessage();
        } catch (\Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
        }
    }
   
}
else
{  
    header('Location:https://ranamehulj.000webhostapp.com/login.php');
}
}else {
    header("location:./");
}
?>
    <!DOCTYPE html>
    <html lang="en">

      <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
		
        <title>Facebook Album Downloader</title>

        <!-- Bootstrap core CSS-->
        <link href="lib/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.5/angular.min.js"></script>
        <!-- Custom fonts for this template-->
        <link href="lib/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
		<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <link href="assets/css/sb-admin.css" rel="stylesheet">
        <link href="assets/css/mainpage.css" rel="stylesheet">
        <link rel="stylesheet" href="lib/slider/dist/css/lightbox.min.css">
      </head>

      <body id="page-top" >
	 
           <nav class="navbar navbar-expand-lg navbar-light bg-light">
               <a class="navbar-brand" href="#">Facebook Album Downloader</a>
              <div class="navbar-inner">
                  <ul class="navbar-nav navbar-right">
                    <li class="active">
                        <h4 style="padding-top: 16px;"><?php echo $name ?>&nbsp;</h4>
                    </li>
                    <li class="dropdown">
                      <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img class="img-circle" src="<?php echo $str ?>"/>
              </a>
                      <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="javascript:logout()">Logout</a></li>
                      </ul>
                    </li>
                  </ul>
              </div><!-- navbar inner -->
            </nav>
			
        <div id="wrapper">

          <!-- Sidebar -->

          <div id="content-wrapper">

            <div class="container-fluid">
                <?php 
                    $url="https://graph.facebook.com/v3.1/".$_GET['useralbumid']."/photos?fields=images%2Calbum&access_token=".$access_token;
                    $pic=file_get_contents($url);
                    $pictures=json_decode($pic);
                    $url1=$url;
                    $page=(array)$pictures->paging; 
                ?>
                <div class="col-sm-6 col-md-4 card-img-top img-responsive">
                <?php
                    do{
        
                        foreach($pictures->data as $my)
                        {
                ?>
                            <a class="example-image-link" href="<?php echo $my->images[0]->source; ?>" data-lightbox="example-set" data-title="">click</a>
                <?php
                        }
                        if(array_key_exists("next",$page)){
                            $url=$page["next"];
                            $pic=file_get_contents($url);
                            $pictures=json_decode($pic);
                            $page=(array)$pictures->paging;
                           
                        }
                        else
                        {
                            $url='none';       
                        }
                        
                    }while($url!='none');
                ?>
                 </div>

              </div>
            <!-- /.container-fluid -->
            
                     </div>
          <!-- /.content-wrapper -->
          </div>
        <!-- /#wrapper -->

        <footer class="sticky-footer" style="width:100%;height:49px;position:fixed">
              <div class="container my-auto">
                <div class="copyright text-center my-auto">
                  <span>Copyright © Mehul Rana</span>
                </div>
              </div>
            </footer>
        <!-- Scroll to Top Button-->
        <a class="scroll-to-top rounded" href="#page-top">
          <i class="fas fa-angle-up"></i>
        </a>
              
<script src="lib/slider/dist/js/lightbox-plus-jquery.min.js"></script>
<!-- Bootstrap core JavaScript-->
        <script src="lib/jquery/jquery.min.js"></script>
        <script src="lib/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

        <!-- Core plugin JavaScript-->
        <script src="lib/jquery-easing/jquery.easing.min.js"></script>

        <!-- Page level plugin JavaScript-->
        <script src="lib/chart.js/Chart.min.js"></script>
        <script src="lib/datatables/jquery.dataTables.js"></script>
        <script src="lib/datatables/dataTables.bootstrap4.js"></script>

        <!-- Custom scripts for all pages-->
        <script src="assets/js/sb-admin.min.js"></script>

        <!-- Demo scripts for this page-->
        <script src="assets/js/demo/datatables-demo.js"></script>
        <script src="assets/js/demo/chart-area-demo.js"></script>
        
      </body>

    </html>