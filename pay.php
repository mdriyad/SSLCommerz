<?php
require_once('config.php');

// if you have order id generated catch the order_id key and query in your database. otherwise pass json data to postdata key of button to catch here
$post_data = array();
$post_data['store_id']			= $store_id;
$post_data['store_passwd']		= $store_passwd;

$post_data['tran_id'] 			= "your unique order id".uniqid();
$post_data['currency'] 			= "BDT";
$post_data['total_amount'] 		= "53";

$post_data['success_url'] 		= "http://localhost/SSLCommerz_customized/success";
$post_data['fail_url']			= "http://localhost/SSLCommerz_customized/fail";
$post_data['cancel_url']		= "http://localhost/SSLCommerz_customized/cancel";

# CUSTOMER INFORMATION
$post_data['cus_name'] 			= "Test name";
$post_data['cus_email']			= "test@gmail.com";
$post_data['cus_add1'] 			= "Dhaka";
$post_data['cus_add2'] 			= "";
$post_data['cus_city'] 			= "Dhaka";
$post_data['cus_state'] 		= "Dhaka";
$post_data['cus_postcode'] 		= "1000";
$post_data['cus_country'] 		= "Bangladesh";
$post_data['cus_phone'] 		= '01710101010';
$post_data['cus_fax'] 			= "";

# Additional Information
$post_data["shipping_method"] 	= "No";
$post_data["product_name"]		= "Computer";
$post_data["product_category"] 	= "Electronic";
$post_data["product_profile"] 	= "general";


/*
 * REST API
 * Method: GET
 * Sandbox/Test Environment: https://sandbox.sslcommerz.com
 * Live Environment: https://securepay.sslcommerz.com
 */
 
# REQUEST SEND TO SSLCOMMERZ
$direct_api_url 				= "https://sandbox.sslcommerz.com/gwprocess/v4/api.php";

$handle = curl_init();
curl_setopt($handle, CURLOPT_URL, $direct_api_url );
curl_setopt($handle, CURLOPT_TIMEOUT, 30);
curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 30);
curl_setopt($handle, CURLOPT_POST, 1 );
curl_setopt($handle, CURLOPT_POSTFIELDS, $post_data);
curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, FALSE); # KEEP IT FALSE IF YOU RUN FROM LOCAL PC

$content = curl_exec($handle );
$code = curl_getinfo($handle, CURLINFO_HTTP_CODE);

if($code == 200 && !( curl_errno($handle))) {
    curl_close( $handle);
    $sslcommerzResponse = $content;
} else {
    curl_close( $handle);
    echo "FAILED TO CONNECT WITH SSLCOMMERZ API";
    exit;
}

# PARSE THE JSON RESPONSE
$sslcz = json_decode($sslcommerzResponse, true );


//var_dump($sslcz); exit;

/*
if(isset($sslcz['GatewayPageURL']) && $sslcz['GatewayPageURL']!="") {
	// this is important to show the popup, return or echo to sent json response back
	return  json_encode(['status' => 'success', 'data' => $sslcz['GatewayPageURL'], 'logo' => $sslcz['storeLogo'] ]);
} else {
	return  json_encode(['status' => 'fail', 'data' => null, 'message' => "JSON Data parsing error!"]);
}
*/
?>

<script>window.location = '<?php echo $sslcz['GatewayPageURL']; ?>';</script>
