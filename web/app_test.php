<?php

use Symfony\Component\Debug\Debug;
use Symfony\Component\HttpFoundation\Request;

umask(0000);
require __DIR__.'/../vendor/autoload.php';

Debug::enable();
$kernel = new AppKernel('test', false);

$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);