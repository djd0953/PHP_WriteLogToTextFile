<?php
    require_once "fileLock.php";

    $eventLogPath = "{$_SERVER["DOCUMENT_ROOT"]}/eventLog";
    $logFileName = date("Y-m-d").".txt";

    $writeLog = new writeLog($eventLogPath, $fileName);
    $writeLog->write(date("H:i:s")."] Event!");
?>