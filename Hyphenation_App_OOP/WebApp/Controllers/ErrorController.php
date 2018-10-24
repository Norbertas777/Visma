<?php
/**
 * Created by PhpStorm.
 * User: norbertas
 * Date: 18.10.23
 * Time: 12.46
 */

class ErrorController extends Controller
{
    public function process($params)
    {
        // HTTP header
        header("HTTP/1.0 404 Not Found");
        // HTML header
        $this->head['title'] = 'Error 404';
        // Sets the template
        $this->view = 'error';
    }
}
