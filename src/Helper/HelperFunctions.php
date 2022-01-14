<?php

namespace Framework\Helper;

class HelperFunctions
{
    public function dd($data): void
    {
        var_dump($data);
        die;
    }
}
