<?php
require "./Request.php";

//get custom Parameters
$request = Request::getInputs();
var_dump($request);

//discount prices
$response = new Response;

//result
$response->render();

exit;
