<?php

  $classes = array(
    // CORE
    "DBStuff" => "core/DBStuff.php",
    "Filler" => "core/Filler.php",
    "LogEngine" => "core/LogEngine.php",
    "Notification" => "core/Notification.php",
    "StrGenerator" => "core/StrGenerator.php",
    "Structure" => "core/Structure.php",
    "DataBinder" => "core/DataBinder.php",
    "TxtFile" => "core/TxtFile.php",
    "Utils" => "core/Utils.php",
    "Validation" => "core/Validation.php",

    // MODEL
    "GenericClass" => "model/GenericClass.php",
    "Blacklist" => "model/Blacklist.php",
    "Request" => "model/Request.php",
    "User" => "model/User.php",
    
    // DAO
    "GenericDAO" => "dao/GenericDAO.php",
    "BlacklistDAO" => "dao/BlacklistDAO.php",
    "UserDAO" => "dao/UserDAO.php"
  );

  foreach ($custom_classes as $key => $value) {
    $classes[$key] = "custom/".$value;
  }

  foreach ($classes as $key => $value) {
    include_once($value);
  }
?>
