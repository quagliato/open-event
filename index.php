<?php
  include_once("custom/custom_app.php");
  include_once("custom/custom_urls.php");
  include_once("app.php");
  include_once("config.php");
  include_once("urls.php");

  if (DEBUG !== false) {
    error_reporting(E_ERROR);
    ini_set("display_errors", 1);
    ini_set('memory_limit', '-1');
    set_time_limit(3600);
  }

  define('REQUEST_URI', $_SERVER['REQUEST_URI']);

  $dbcon = new DBStuff;

  if (!$dbcon->testDB()) {
    include_once("view/db_problems.php");

  } else {
    if(strpos(REQUEST_URI, '?') != 0){
      $request_uri_no_param = substr(REQUEST_URI, 0, strpos(REQUEST_URI, '?'));
    }else{
      $request_uri_no_param = REQUEST_URI;
    }

    if (STATIC_FILES) {
      // We suggest that you move this rules to you webserver config file
      $staticFiles = array();
      if (preg_match_all('~(js|css|html|txt|svg|ico|gif|jpg|png|pdf|otf|ttf|eot|woff|woff2)$~', $request_uri_no_param, $staticFiles)) {
        switch ($staticFiles[0][0]) {
          case "css":
          case "js":
          case "txt":
          case "html":
          case "svg":
            header("Content-type: text/".$staticFiles[0][0]);
            echo file_get_contents(substr(REQUEST_URI, 1));
            break;
          case "ico":
          case "gif":
          case "jpg":
          case "png":
          case "pdf":
          case "otf":
          case "eot":
            header("Content-type: application/vnd.ms-fontobject");
            echo file_get_contents(substr(REQUEST_URI, 1));
            break;
          case "ttf":
            header("Content-type: application/x-font-ttf");
            echo file_get_contents(substr(REQUEST_URI, 1));
            break;
          case "woff":
            header("Content-type: application/font-woff");
            echo file_get_contents(substr(REQUEST_URI, 1));
            break;
          case "woff2":
            header("Content-type: application/font-woff");
            echo file_get_contents(substr(REQUEST_URI, 1));
            break;
        }
        exit(0);
      }
    }

    if(!empty(APP_DIR)) $request_uri_no_param = strtr($request_uri_no_param,array(APP_DIR=>''));
    if(isset($urlpatterns[$request_uri_no_param])) {
      $actual = $urlpatterns[$request_uri_no_param];
      include_once($actual);
    } else {
      include_once("view/404.php");
    }

  }
?>
