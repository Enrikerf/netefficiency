<?php
include('versionb/All_classes/Main_finance.php');

if ($_SERVER['REQUEST_URI'] === 'time') {
    $data = new Main_finance();
    echo $data->today();
} elseif ($_SERVER['REQUEST_URI'] === 'vat') {
	$tax = 20;
	$price = 400;
	$data = new Main_finance();
    echo ' VAT: ' . $data->VAT($price, $tax);
    echo ' Tax: ' . $tax;
} else {
    echo 'Hello!';
}