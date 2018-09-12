<?php
@session_start();
require_once 'lib/vendor/autoload.php';
$appid='355587161647175';
$secretid='26bedaef64f2b6bf27b112f06463b98b';
 $fb = new Facebook\Facebook([
   'app_id' => $appid,
  'app_secret' =>$secretid,
  'default_graph_version' => 'v2.2',
  ]);
  ?>