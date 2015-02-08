<?php
    // CONFIGS

    // The directory of the domain where app is running;
    // If it is running on root domain, leave it blank.
    define('APP_DIR', '/open-event');
    // The app URL
    define('APP_URL', 'http://localhost/open-event');
    // The app title used on header and <title>
    define('APP_TITLE', 'open-event');

    // The first user to register using the this email address will be setted
    // as system's root user
    define('ADMIN_EMAIL', '');

    // FILES
    // All paths in file config should have a slash at the end

    // The root URL for uploaded files
    define('FILES_URL', APP_URL.'/uploads/');
    // The root URL for uploaded files with problems
    define('FILES_URL_FAILSAFE', APP_URL.'/uploads/failsafe/');
    // The full path to the directory where files will be uploaded
    define('FILES_DIR', '/var/www/open-event/uploads/');
    // The same, but for failsafe
    define('FILES_DIR_FAILSAFE', '/var/www/open-event/uploads/failsafe/');

    // Maximun filesize for uploaded files
    define('MAX_FILESIZE', '50MB');

    // DB Settings
    define('DB_HOST', '');
    define('DB_USER', '');
    define('DB_PASS', '');
    define('DB_NAME', '');

    // Default SQL log filename (with path, if you want).
    // ALL SQL activity is logged.
    define('SQL_LOG_FILENAME', 'sql.log');

    // Default maximum size for log files befor compact it.
    define('DEFAULT_LOG_MAX_FILESIZE', 1024000);  // 1MB in B

    // Sets default timezone.
    date_default_timezone_set("America/Sao_Paulo");

    // EMAILS
    // Default e-mail address to a real person
    define('DEFAULT_HUMAN_EMAIL', 'contato@open-event.net');

    // Default no-reply e-mail
    define('DEFAULT_EMAIL_FROM', 'noreply@open-event.net');
    // Default signature for all e-mails
    define('DEFAULT_EMAIL_SIGN', "<p>With love,<br />open-event.</p>");
    // Default greeting for all e-mails
    define('DEFAULT_EMAIL_GREETING', "<p>Hey!</p>");

    // Default e-mail subject
    define('DEFAULT_EMAIL_SUBJECT', APP_TITLE);

    // Include custom configs
    include_once("custom/custom_config.php");
?>
