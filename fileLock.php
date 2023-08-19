<?php
    class writeLog
    {
        private $path;
        private $fileName;
        private $fb;

        // 생성자
        function __construct($path, $fileName)
        {
            $this->path = $path;
            $this->fileName = $fileName;

            // 폴더 없으면 생성
            if (!is_dir($this->path)) mkdir($this->path, 0775, true);
            $this->acquire();
        }

        function acquire()
        {
            // 파일 읽기 (없으면 생성)
            $this->fb = fopen("{$this->path}/{$this->fileName}", 'a');

            // PHP에 뮤텍스, 세라포어는 외부 라이브러리를 설치해야해서 기본 제공하는 File Lock 사용
            while (true)
            {
                if (flock($this->fb, LOCK_EX)) break;
                sleep(1 * 0.001); // sleep 함수 기본 second단위라 ms로 변경
            }
        }

        function write($message, $carriageReturn = true)
        {
            fwrite($this->fb, $message.($carriageReturn ? "\r\n" : ""));
        }

        // 소멸자
        function __destruct()
        {
            flock($this->fb, LOCK_UN);
        }
    }
?>
