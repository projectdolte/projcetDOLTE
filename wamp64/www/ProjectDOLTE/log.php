<?PHP
    $ip = getenv("REMOTE_ADDR");
    $date = date("d") . "\t" . date("F") . " " . date("Y");
    $intofile = $ip . "        " . $date . PHP_EOL;
    $hfile = fopen("logfile.txt", "a+");
    fwrite($hfile, $intofile);
    fclose($hfile);
?>