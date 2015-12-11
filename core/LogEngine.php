<?php

class LogEngine {

    private $logFilename;
    private static $logMaxFilesize = DEFAULT_LOG_MAX_FILESIZE;

    // name      : __construct
    // params    : string $filename
    // desc      : Creates a log file with the $filename.
    public function __construct($filename) {
        if (!isset($filename) || is_null($filename) || $filename == "") {
            throw new Exception("Cannot log whithout the log's filename.");
        }

        $this->logFilename = $filename;
    }

    // name      : log
    // params    : string $level, string $message
    // desc      : Appends the $string to the file.
    public function log($level, $message) {
        $now = date("Y-m-d H:i:s");
        $this->logIt("[$now] [$level] $message");
    }

    // name      : logIt
    // params    : string $string
    // desc      : Appends the $string to the file.
    public function logIt($string) {
        $file = new TxtFile($this->logFilename);
        $file->loadlessAppendNewLine($string);
        $file = $this->compactLogFile($file);
    }

    // name      : compactLogFile
    // params    : file $file
    // desc      : If the log file ir bigger than $logMaxFilesize, it is copied
    //             to a backup file.
    private function compactLogFile($file) {
        if ($file->getFileSize() > self::$logMaxFilesize) {
            $timestamp = new DateTime('now');
            $timestamp = $timestamp->format("YmdHis");
            $newFilename = $timestamp."_".$this->logFilename;
            
            $file = $file->moveFile($newFilename);

            if (!$file) {
                throw new Exception("LogEngine: Could not compact file.");
            }
        }
        
        return $file;
    }
}

?>
