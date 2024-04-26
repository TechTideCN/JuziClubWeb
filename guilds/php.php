<?php

if (function_exists('fastcgi_finish_request')) {
    echo 'fastcgi_finish_request is available on this server.';
} else {
    echo 'fastcgi_finish_request is NOT available on this server.';
}

?>