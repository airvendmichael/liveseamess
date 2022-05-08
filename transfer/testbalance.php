<?php
include "/var/www/vhosts/api/secured/seamless/transfer/providus.php";
$mx = new ProvidusTransfer;
$response = $mx->accountBalance();
$response = $mx->confirmTransaction(["reference"=>"callphone-CPL-9556179"]);
print_r($response);
