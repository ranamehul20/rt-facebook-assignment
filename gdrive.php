<?php
error_reporting(0);
@session_start();
$albumid=$_GET['id'];
$albumname=$_GET['name'];

include_once 'lib/src/Google_Client.php';
include_once 'lib/src/contrib/Google_Oauth2Service.php';
require_once 'lib/src/contrib/Google_DriveService.php';
require_once 'lib/vendor/autoload.php';
$fb = new Facebook\Facebook([
       'app_id' => '355587161647175',
      'app_secret' => '26bedaef64f2b6bf27b112f06463b98b',
      'default_graph_version' => 'v2.2',
      ]);

$client = new Google_Client();
$client->setClientId('587017132534-s267qdejgl5gj9q84mvfo7tcvmfqsoj7.apps.googleusercontent.com');
$client->setClientSecret('bWLpSwR6unbYXNJzDjnsEcrc');
$client->setRedirectUri('https://mehulranartchallenge.herokuapp.com/gdrive.php');
$client->setScopes(array('https://www.googleapis.com/auth/drive.file'));

if (isset($_GET['code']) || (isset($_SESSION['access_token']))) 
{
	
	
	$service = new Google_DriveService($client);
    if (isset($_GET['code'])) {
		$client->authenticate($_GET['code']);
	    $_SESSION['access_token'] = $client->getAccessToken();	
			
    } else
        $client->setAccessToken($_SESSION['access_token']);
        
    $access_token=$_SESSION['fb_access_token'];
    $folderName="facebook_".$_SESSION['uname']."_albums";
	$folder = new Google_DriveFile();
    $folder->setTitle($folderName);
    $folder->setMimeType('application/vnd.google-apps.folder');

    $createdFolder = $service->files->insert($folder, array(
      'mimeType' => 'application/vnd.google-apps.folder'
    ));
    $parentId  = $createdFolder['id'];
 	$subfolderName=$albumname;
	$subfolder = new Google_DriveFile();
	if ($parentId != null)
	{
        $parent = new Google_ParentReference();
        $parent->setId($parentId);
        $subfolder->setParents(array($parent));
    }
    $subfolder->setTitle($subfolderName);
    $subfolder->setMimeType('application/vnd.google-apps.folder');

    $createdsubFolder = $service->files->insert($subfolder, array(
      'mimeType' => 'application/vnd.google-apps.folder'
    ));
    $spId  = $createdsubFolder['id'];
    //Insert a file
	$file = new Google_DriveFile();
	if ($spId != null)
	{
        $parent = new Google_ParentReference();
        $parent->setId($spId);
        $file->setParents(array($parent));
    }
    $file->setTitle(uniqid().'.jpg');
    $file->setMimeType('image/jpeg');
    $url="https://graph.facebook.com/v3.1/".$albumid."/photos?fields=source,images,name&access_token=".$access_token;
    $pic=file_get_contents($url);
    $pictures=json_decode($pic);
    $page=(array)$pictures->paging;
    
    do{
        foreach($pictures->data as $my)
        {
            $data=file_get_contents($my->images[0]->source);
            $created = $service->files->insert($file, array(
                'data' =>$data,
                'mimeType' => 'image/jpeg',
		        'uploadType'=>'multipart'
            ));
        }
        if(array_key_exists("next",$page))
        {
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
	header('Location:https://mehulranartchallenge.herokuapp.com');

} 
else 
{
    
    $authUrl = $client->createAuthUrl();
    header('Location: ' . $authUrl);
    exit();
}
?>
