<?php

function my_autoload ($pClassName) {

    include(__DIR__ . "/../" . str_replace("\\", "/", $pClassName) . ".php");
}
spl_autoload_register("my_autoload");

?>