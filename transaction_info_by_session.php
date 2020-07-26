<?php
require_once('config.php');

$sessionkey=urlencode("your unique session id");
$requested_url = ("https://sandbox.sslcommerz.com/validator/api/merchantTransIDvalidationAPI.php?sessionkey=".$sessionkey."&store_id=".$store_id."&store_passwd=".$store_passwd."&v=1&format=json");

$handle = curl_init();
curl_setopt($handle, CURLOPT_URL, $requested_url);
curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false); # IF YOU RUN FROM LOCAL PC
curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false); # IF YOU RUN FROM LOCAL PC

$result = curl_exec($handle);


$code = curl_getinfo($handle, CURLINFO_HTTP_CODE);
if($code == 200 && !( curl_errno($handle)))
{
	# TO CONVERT AS ARRAY
	$result = json_decode($result, true);
	# $status = $result['status'];
	
	echo "<pre>";
	print_r($result);

} else {
	
	echo "Failed to connect with SSLCOMMERZ";
}

?>