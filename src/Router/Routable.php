<?php

namespace App\Router;

interface Routable
{
    function getController();
    function getAction();
    function getParams();
    function isMatch($url, $verb);
    function getName();
}
