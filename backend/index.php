<?php
require "./Request.php";
require "./Response.php";

//get custom Parameters
$request = Request::getInputs();

//Discount
$customers = $request->getCustomers();
$customers->processDiscount($request);

//result
$response = new Response($customers);
$response->render();
exit;
