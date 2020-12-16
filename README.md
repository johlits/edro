
Commands are sent, carried out and returned from `server.php`. Add `config.php` and `crypto.php` in parent directory, see sections below for setting them up. 

# config.php

```
<?php
define('DB_SERVER', 'xxx');
define('DB_USERNAME', 'xxx');
define('DB_PASSWORD', 'xxx');
define('DB_NAME', 'xxx');

$db = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
if($db === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

$GLOBALS['log'] = true;
$GLOBALS['dev'] = true;
?>
```
# crypto.php
```
<?php
function decrypt($str) {
    // implement your decryption here
    return $str;
}

function encrypt($str) {
    // implement your encryption here
    return $str;
}
?>
```
