<?php 
ini_set(‘max_execution_time’, ‘100’);
 require_once 'fbconfig.php';
 $access_token=$_SESSION['fb_access_token'];
if(isset($_GET['id']))
{
$id=$_GET['id'];
$name=$_GET['name'];
$album_download_directory = __DIR__.'Downloads/albums/'.uniqid().'/';
mkdir($album_download_directory, 0777,true);
 $url="https://graph.facebook.com/v3.1/".$id."/photos?fields=source,images,name&access_token=".$access_token;
    $pic=file_get_contents($url);
    $pictures=json_decode($pic);
    $page=(array)$pictures->paging;
    $album_directory = $album_download_directory.$name;
		if ( !file_exists( $album_directory ) ) {
			mkdir($album_directory, 0777,true);
		}
		$i=1;
     do{
            foreach($pictures->data as $my)
            {
                file_put_contents( $album_directory.'/'.$i.".jpg",file_get_contents($my->images[0]->source));
                $i++;
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
$rootPath = realpath($album_download_directory);
$filesToDelete = array();
$zip = new ZipArchive();
$zip->open('file.zip', ZipArchive::CREATE | ZipArchive::OVERWRITE);
$files = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($rootPath),
    RecursiveIteratorIterator::LEAVES_ONLY
);

foreach ($files as $name => $file)
{
    if (!$file->isDir())
    {
        $filePath = $file->getRealPath();
        $relativePath = substr($filePath, strlen($rootPath) + 1);

        $zip->addFile($filePath, $relativePath);
        $filesToDelete[] =$filePath; 
    }
}

$zip->close();
	header('Content-type: application/zip');
	header('Content-Disposition: attachment; filename="file.zip"');
	header("Content-length: " . filesize('file.zip'));
	header("Pragma: no-cache");
	header("Expires: 0");
    foreach ($filesToDelete as $file)
    {
        unlink($file);
    }
    rmdir($album_directory);
    rmdir($album_download_directory);
    
}
if ( isset( $_GET['select_album'] ) and count( $_GET['select_album'] ) > 0) 
{
	$selected_albums = explode("/", $_GET['select_album']);
	foreach ( $selected_albums as $selected_album ) 
	{
		$selected_album = explode( ",", $selected_album );
		$id=$selected_album[0];
		$name=$selected_album[1];
		$album_download_directory = __DIR__.'Downloads/albums/'.uniqid().'/';
        mkdir($album_download_directory, 0777,true);
        $url="https://graph.facebook.com/v3.1/".$id."/photos?fields=source,images,name&access_token=".$access_token;
        $pic=file_get_contents($url);
        $pictures=json_decode($pic);
        $page=(array)$pictures->paging;
        $album_directory = $album_download_directory.$name;
		if ( !file_exists( $album_directory ) ) 
		{
			mkdir($album_directory, 0777,true);
		}
		$i=1;
     do{
            foreach($pictures->data as $my)
            {
                file_put_contents( $album_directory.'/'.$i.".jpg",file_get_contents($my->images[0]->source));
                $i++;
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

	}
	$rootPath = realpath($album_download_directory);
$filesToDelete = array();
$zip = new ZipArchive();
$zip->open('album.zip', ZipArchive::CREATE | ZipArchive::OVERWRITE);
$files = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($rootPath),
    RecursiveIteratorIterator::LEAVES_ONLY
);

foreach ($files as $name => $file)
{
    if (!$file->isDir())
    {
        $filePath = $file->getRealPath();
        $relativePath = substr($filePath, strlen($rootPath) + 1);

        $zip->addFile($filePath, $relativePath);
        $filesToDelete[] =$filePath; 
    }
}

$zip->close();
	header('Content-type: application/zip');
	header('Content-Disposition: attachment; filename="album.zip"');
	header("Content-length: " . filesize('album.zip'));
	header("Pragma: no-cache");
	header("Expires: 0");
    foreach ($filesToDelete as $file)
    {
        unlink($file);
    }
    rmdir($album_directory);
    rmdir($album_download_directory);
}

?>