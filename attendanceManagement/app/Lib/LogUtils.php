<?php
/**
 * LogUtil will dump logs in local server
 *
 * User: ankit.shah
 * Date: 24-12-2014
 * Time: 15:14
 */

class LogUtils {

    /**
     * log info, dump data/info in log file to back trace. It will
     * create directory/folder is specified else use default one
     * i.e. folder "app".
     *
     * Note: We will use default logs folder for dumping all custom
     * logs. In CakePHP "tmp" is the folder which will hold all such
     * log files.
     *
     * @param string $text2log
     * @param string $dir_name
     */
    public function logInfo($text2log) {

        //echo ROOT;die;
        $rootFolder = ROOT .'/logs/';

        if(!is_dir($rootFolder)){
            mkdir($rootFolder,0777,true);
        }

        /* Log will be saved in "Month_Year" based folder. It will create "Month_Year"
            named folder and dump log date wise.
            ../log/May_2015/... # Contains web page related logs
            ../log/June_2015/... # Contains app related logs */

        $today = getdate();
        $date = $today['mday'];
        $dir_name = $today['month'] . '_' . $today['year'] . '/';

        // Check app/web named folder is exist or not
        if (!file_exists($rootFolder . $dir_name)) {
            mkdir($rootFolder . $dir_name, 0777, true);
        }

        $filename = $rootFolder . $dir_name . "/log_$date.log";
        if (!file_exists($filename)) {
            $fh = fopen($filename, 'a+'); //implicitly creates file
            fwrite($fh, '==================================================================================' . "\r\n");
            fwrite($fh, 'II    Time(12 Hr)     Request' . "\r\n");
            fwrite($fh, '==================================================================================' . "\r\n");
            fwrite($fh, $text2log);
        } else {
            $fh = fopen($filename, "a+");
            fwrite($fh, $text2log);
        }
        fclose($fh);
    }
} 