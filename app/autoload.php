<?php

spl_autoload_register('AutoLoader');

function AutoLoader($className)
{
    $file = str_replace('\\', DIRECTORY_SEPARATOR, $className);
    require_once sprintf("%s.php", $file);
}