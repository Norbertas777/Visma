<?php



function autoloadFunction($class)
{
    // Ends with a string "Controller"?
    if (preg_match('/Controller$/', $class))
        require("Controllers/" . $class . ".php");
    else
        require("Models/" . $class . ".php");
}

spl_autoload_register("autoloadFunction");

include "/home/norbertas/PhpstormProjects/uzduotis1/Hyphenation_App_OOP/Classes/Side_Functions/Autoload.php";


$router = new RouterController();
$router->process(array($_SERVER['REQUEST_URI']));
$router->renderView();


