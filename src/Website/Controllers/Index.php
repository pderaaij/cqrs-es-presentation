<?php
namespace CESPres\Website\Controllers;

use \Symfony\Component\HttpFoundation\Request;
use \Symfony\Component\HttpFoundation\Response;

/**
 * Basic Index controller
 *
 * @author pderaaij
 */
class Index
{
    public function index(Request $request) {
        
        return new Response("hello world!");
    }
}
