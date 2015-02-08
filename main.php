<?php
    include_once("url_response.php");
    include_once("urls.php");
    include_once("custom/custom_urls.php");

    foreach ($custom_urlpatterns as $key => $value) {
        $urlpatterns[$key] = "custom/".$value;
    }

    url_response($urlpatterns);
?>
