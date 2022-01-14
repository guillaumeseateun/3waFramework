<?php

namespace Controllers;

use App\Controller;

class NotFoundController extends BaseController
{
    public function index()
    {
        return "404";
    }
}
