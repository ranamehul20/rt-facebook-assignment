<?php 
require_once 'fbconfig.php';
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
    $useralbums_response = $fb->get("/" . $id . "/albums?fields=picture,name,id");
    $useralbums = $useralbums_response->getGraphEdge()->asArray();
    $albumjson=json_encode($useralbums);
    echo '<pre>';
    //print_r($albumjson);
    echo '</pre>';

    /*$url= "https://graph.facebook.com/v3.1/me?fields=albums%7Bpicture%7D&access_token=".$access_token;
    $result=file_get_contents($url);
    $pictures=json_decode($result);*/
    $cnt=0;
}
else
{  
    header('Location:https://ranamehulj.000webhostapp.com/login.php');
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
    <script type="text/javascript">
		
		function myfunction(id,name)
       {
		   
			req=new  XMLHttpRequest(); 
			req.onreadystatechange=function()
			{
            // To check readyState of XMLHTTPRequest
            //alert(req.readyState); 
	
				if(req.readyState==4 &&req.status==200) 
				{ 
					alert("Zip file created suceessfully"); //document.getElementById("response").innerHTML=req.responseText;
					document.getElementById("result").innerHTML="<a href='http://ranamehulj.000webhostapp.com/file.zip' download>Download Zip file</a>";
				}
			}
			// Example query String ==> str="q=123"
			//req.open(method,url,async/sync(i.e. true/false))
			alert("Downloading image!");
			document.getElementById("result").innerHTML="Creating Zip file";	
			req.open("GET","https://ranamehulj.000webhostapp.com/downloadalbum.php?id=" + id+ "&name=" + name,true); 
			req.send();
       }
	   function share(id,name)
	   {
	       var queryString = "?id=" + id + "&name=" + name;
	       window.location="gdrive.php" +queryString;
	   }
	   function logout() 
	   {
			if (confirm("Are you sure Leave this page ?")) 
			{
				window.location="logout.php";
			} 
			else 
			{
        
			}
		}

		function download_selected()
		{
			var select_album = document.getElementsByName('album[]');
			var vals = "";
			for (var i=0, n=select_album.length;i<n;i++) 
			{
				if (select_album[i].checked) 
				{
					vals +="/"+select_album[i].value;
				}
			}
			req=new  XMLHttpRequest(); 
			req.onreadystatechange=function()
			{
            // To check readyState of XMLHTTPRequest
            //alert(req.readyState); 

				if(req.readyState==4 &&req.status==200) 
				{ 
				   alert("Download complete sucessful");
					document.getElementById("result").innerHTML="<a href='http://ranamehulj.000webhostapp.com/album.zip' download>Download Zip file</a>";
				}
			}
			alert("Downloading image!");
			document.getElementById("result").innerHTML="Downloading Image....";
			req.open("GET","https://ranamehulj.000webhostapp.com/downloadalbum.php?select_album="+vals,true); 
	   
			req.send();	
		}
	   function download_all()
	   {
	       req=new  XMLHttpRequest(); 
			req.onreadystatechange=function()
			{
				if(req.readyState==4 &&req.status==200) 
				{ 
				   alert("Download complete sucessful");
					document.getElementById("result").innerHTML="<a href='http://ranamehulj.000webhostapp.com/album.zip' download>Download Zip file</a>";
				}
			}
			alert("Downloading image!");
			document.getElementById("result").innerHTML="Downloading Image....";
			req.open("GET","https://ranamehulj.000webhostapp.com/downloadalbum.php?flag=all",true); 
			req.send();
	   }
	   

		</script>

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

              <!-- Breadcrumbs-->
              <ol class="breadcrumb">
                <li>
                 <div class="col-sm-12">
                        <a href="javascript:download_all()" id="download-all-albums" class="center">
                            <span class="btn btn-primary col-sm-12 col-xs-12">
                                Download All
                            </span>
                        </a>
                    </div>
                  </li>
                  <li >
                    <div class="col-sm-12">
                        <a href="javascript:download_selected()" id="download-selected-albums" class="center">
                            <span class="btn btn-warning col-sm-12 col-xs-12">
                                Download Selected
                            </span>
                        </a>
                    </div>
                  </li>
                  <li >
                    <div class="col-sm-12">
                        <a href="#" id="move_all" class="center">
                            <span class="btn btn-success col-sm-12 col-xs-12">
                                Move All
                            </span>
                        </a>
                    </div>
                  </li>
                  <li>
                    <div class="col-sm-12">
                        <a href="#" id="move-selected-albums" class="center">
                            <span class="btn btn-info col-sm-12 col-xs-12">
                                Move Selected
                            </span>
                        </a>
                    </div>
                </li>
              </ol>
	<div id="result" style="color:red;background-color: yellow">
	</div>
              <!-- Icon Cards-->
              <div class="row">
                
<?php
        foreach($useralbums as $useralbum){
             $url="https://graph.facebook.com/v3.1/".$useralbum['id']."/photos?fields=images%2Calbum&access_token=".$access_token;
                    $pic=file_get_contents($url);
                    $pictures=json_decode($pic);
                    $url1=$url;
                    $page=(array)$pictures->paging;
    ?>          
                
                <div class="box col-md-4 col-sm-12"  >
                    <div data-toggle="buttons" class="btn-group bizmoduleselect" style="width:100%">
                     <label class="btn btn-default">
                    <input type="checkbox" name="album[]" value="<?php echo $useralbum['id'].','.$useralbum['name'];?>">
                    <span class="glyphicon glyphicon-ok glyphicon-lg"></span>
                    <div class="item" style="background:url('<?php echo $useralbum['picture']['url']; ?>'); background-position: center; background-size: cover;" >
                        <img src="<?php echo $useralbum['picture']['url']; ?>" /> </div>
                    <h4>
                    <center><a href=""> <?php echo $useralbum['name']; ?> </a></center> 
                    </h4>
                     </label>
                    </div>
                    <div class="row" >
                    <div class="col-lg-4 col-md-4 ">
                         <?php
                         $c=0;
                    do{
        
                        foreach($pictures->data as $my)
                        {
                            if($c==0){
                ?>
                            <a class="example-image-link btn btn-primary btn-block" href="<?php echo $my->images[0]->source; ?>" data-lightbox="<?php echo $useralbum['name']; ?>" data-title="" >View</a>
                <?php
                          $c=$c+1;
                            }
                            else{ ?>
                            <a class="example-image-link" href="<?php echo $my->images[0]->source; ?>" data-lightbox="<?php echo $useralbum['name']; ?>" data-title=""></a>
                <?php
                            }
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
                    <div class="col-lg-4 col-md-4">
                        <button style="margin-right: 10px;" id="single-download"  class="btn btn-primary btn-block" onclick="myfunction('<?php echo $useralbum['id'];?>','<?php echo $useralbum['name'];?>')">Download </button>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <button style="margin-right: 10px;"  class="btn btn-primary btn-block" onclick="share('<?php echo $useralbum['id'];?>','<?php echo $useralbum['name'];?>')" >Google Drive </button>
                    </div>
                    </div>
                       
                  </div> 
                  
<?php } ?>
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


        <!-- Custom scripts for all pages-->
        <script src="assets/js/sb-admin.min.js"></script>

      </body>

    </html>