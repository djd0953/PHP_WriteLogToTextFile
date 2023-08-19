<?php
    class writeLog
    {
        private $path;
        private $fileName;
        private $fb;

        function __construct($path, $fileName)
        {
            $this->path = $path;
            $this->fileName = $fileName;

            if (!is_dir($this->path)) mkdir($this->path, 0775, true);
            $this->acquire();
        }

        function acquire()
        {
            $this->fb = fopen("{$this->path}/{$this->fileName}", 'a');

            while (true)
            {
                if (flock($this->fb, LOCK_EX)) break;
                sleep(1 * 0.001);
            }
        }

        function write($message, $carriageReturn = true)
        {
            fwrite($this->fb, $message.($carriageReturn ? "\r\n" : ""));
        }

        function __destruct()
        {
            flock($this->fb, LOCK_UN);
        }
    }
?>