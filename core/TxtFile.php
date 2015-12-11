<?php

    class TxtFile {

    private $filename;
    private $buffer;
    private $writtenContent;

    // name      : __construct
    // params    : string $filename
    // desc      : creates the TxtFile object and sets its filename.
    public function __construct($filename) {
        if (!isset($filename) || is_null($filename) || $filename == "") {
            throw new Exception("TxtFile cannot be initialized without a filename.");
        }
        $this->filename = $filename;
    }
    
    // name      : fileExists
    // params    : void
    // desc      : Verify if the file exists.
    public function fileExists() {
        if (!isset($this->filename) || is_null($this->filename) || $this->filename == "") {
            return false;
        }

        return file_exists($this->filename);
    }

    // name      : getFileSize
    // params    : void
    // desc      : Returns filesize in bytes.
    public function getFileSize() {
        if ($this->fileExists()) {
            return filesize($this->filename);
        }
        
        return -1;
    }

    // name      : getBufferContent
    // params    : void
    // desc      : Returns the content of the buffer of the TxtFile object.
    public function getBufferContent() {
        return $this->buffer;
    }

    // name      : getWrittenContent
    // params    : void
    // desc      : Returns the content actual text file.
    public function getWrittenContent() {
        return $this->loadContent();
    }

    public function getContent() {
        $aux = $this->buffer;
        if ($this->fileExists() && $this->getFileSize() > -1) {
            $this->loadContent();
            $aux = array_merge($this->writtenContent, $this->buffer);
        }

        return $aux;
    }

    // name      : loadContent
    // params    : void
    // desc      : Gets the content already written at the file, sets it to
    //             local property and returns it.
    private function loadContent() {
        $this->writtenContent = array();

        if ($this->fileExists()) {
            $handle = fopen($this->filename, "r");
            if ($handle) {
                while (($line = fgets($handle)) != false) {
                    $this->writtenContent[] = $line;        
                }
            } else {
                throw new Exception("TxtFile could not load file content.");
            }
            fclose($handle);
        }
            
        return $this->writtenContent;
    }

    // name      : appendNewLine
    // params    : string $string
    // desc      : Inserts a new string with CR on the buffer.
    public function appendNewLine($string) {
        if (sizeof($this->buffer) > 0 || ($this->fileExists() && $this->getFileSize() > -1)) {
            $string = "\n".$string;
        }
        $this->appendNewString($string);
    }

    // name      : appendNewString
    // params    : string $string
    // desc      : Inserts a new string on the buffer.
    public function appendNewString($string) {
        if (!is_array($this->buffer) || is_null($this->buffer)) {
            $this->buffer = array();
        }
        
        $this->buffer[] = $string;
    }

    // name      : loadlessAppendNewLine
    // params    : string $string
    // desc      : Inserts a new string with CR right on the file, without
    //             writing on the buffer.
    public function loadlessAppendNewLine($string) {
        if ($this->fileExists() && $this->getFileSize() > -1) {
            $string = "\n".$string;
        }

        file_put_contents($this->filename, $string, FILE_APPEND);
    }

    // name      : write
    // params    : int $flag
    // desc      : Write the buffer content to the file, cleaning it or not
    //             using $flag as parameter (0 clean it).
    public function write($flag) {
        return $this->writeBuffer($flag);
    }

    // name      : writeBuffer
    // params    : int $flag
    // desc      : Write the buffer content to the file, cleaning it or not
    //             using $flag as parameter (0 clean it).
    private function writeBuffer($flag) {
        if (!is_array($this->buffer) || is_null($this->buffer) || sizeof($this->buffer) == 0) {
            return false;
        }

        if ($flag == 0) {
            unlink($this->filename);
        }

        foreach ($this->buffer as $line) {
            file_put_contents($this->filename, $line, FILE_APPEND);
        }

        $this->buffer = array();

        return true;
    }

    // name      : clearFile
    // params    : void
    // desc      : Clean both buffer and file.s
    public function clearFile() {
        if ($this->fileExists() && $this->getFileSize() > -1) {
            $this->buffer = array();
            $this->appendNewLine("");
            $this->write(0);
        }

        $this->buffer = array();
    }

    // name      : copyFile
    // params    : string $newFilename
    // desc      : Copy the written content of this file to the other file.
    // obs       : Non-written buffer will not be copied.
    public function copyFile($newFilename) {
        if ($this->fileExists() && $this->getFileSize() > -1) {
            return copy($this->filename, $newFilename);
        }

        return false;
    }

    // name      : moveFile
    // params    : string $newFilename
    // desc      : Move this file to another file and returns a new TxtFile
    //             object for the new file.
    // obs       : Write what is in the buffer and move after that.
    public function moveFile($newFilename) {
        var_dump($this->buffer);
        if (isset($this->buffer) && !is_null($this->buffer) && sizeof($this->buffer) > 0) {
            $writeResult = $this->write(1);
            if (!$writeResult) {
                return $writeResult;
            }
        }

        if ($this->fileExists() && $this->getFileSize() > -1) {
            if ($this->copyFile($newFilename)) {
                unlink($this->filename);
                return new TxtFile($newFilename);
            }
        }

        return false;
    }
}

?>