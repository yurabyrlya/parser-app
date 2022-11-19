<?php
declare(strict_types=1);
namespace App;

use App\Services\Parser\ACMEParser;

require_once  __DIR__ . '/vendor/autoload.php';


$acmeDemoParser = new ACMEParser('https://wltest.dns-systems.net');

$products = $acmeDemoParser->getProductList();
$sortedProducts = $acmeDemoParser->oderByPrice($products);
$acmeDemoParser->saveToFile(
    $acmeDemoParser->toJson($sortedProducts)
);

