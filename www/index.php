<?php
switch (@parse_url($_SERVER['REQUEST_URI'])['path'])
{
    case '/':
        require 'main.php';
        break;
    case '/readwise2roam-www.php':
        require 'readwise2roam-www.php';
        break;
    case '/test.php':
        require 'test.php';
        break;
    default:
        http_response_code(404);
        exit('Not Found');
}
?>