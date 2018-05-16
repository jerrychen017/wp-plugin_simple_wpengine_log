<?php // Simple WPEngine Log - Core Functionality

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// copy access log files to desinated aws bucket
function swl_copy_access_log() {

  $options = get_option( 'swl_options', swl_options_default() );

  if ( isset( $options['aws_reigon'] ) && ! empty( $options['aws_reigon'] )
  && isset( $options['aws_endpoint'] ) && ! empty( $options['aws_endpoint'] )
&& isset( $options['aws_access_id'] ) && ! empty( $options['aws_access_id'] )
&& isset( $options['aws_access_key'] ) && ! empty( $options['aws_access_key'] )
&& isset( $options['aws_bucket_name'] ) && ! empty( $options['aws_bucket_name'] )
&& isset( $options['wpe_access_loc'] ) && ! empty( $options['wpe_access_loc'] )
&& isset( $options['wpe_error_loc'] ) && ! empty( $options['wpe_error_loc'] )) {

// AWS API keys
$aws_access_key_id = $options['aws_access_id'];
$aws_secret_access_key = $options['aws_access_key'];
// Bucket
$bucket_name = $options['aws_bucket_name'];
// AWS region
$aws_region = $options['aws_reigon'];
// AWS host name
$host_name = $bucket_name . '.' . $options['aws_endpoint'];
// Server path to file
$content_path = $options['wpe_access_loc'];
$content = file_get_contents($content_path);
// AWS file permissions
$content_acl = 'authenticated-read';
// MIME type of file
$content_type = 'text/plain';
// Service name for S3
$aws_service_name = 's3';
// UTC timestamp and date
$timestamp = gmdate('Ymd\THis\Z');
$date = gmdate('Ymd');
// Name of the content on S3
$content_title = $date . '-access-log.log';
// HTTP request headers as key & value
$request_headers = array();
$request_headers['Content-Type'] = $content_type;
$request_headers['Date'] = $timestamp;
$request_headers['Host'] = $host_name;
$request_headers['x-amz-acl'] = $content_acl;
$request_headers['x-amz-content-sha256'] = hash('sha256', $content);
// Sort it in ascending order
ksort($request_headers);
// Canonical headers
$canonical_headers = [];
foreach($request_headers as $key => $value) {
	$canonical_headers[] = strtolower($key) . ":" . $value;
}
$canonical_headers = implode("\n", $canonical_headers);
// Signed headers
$signed_headers = [];
foreach($request_headers as $key => $value) {
	$signed_headers[] = strtolower($key);
}
$signed_headers = implode(";", $signed_headers);
// Cannonical request
$canonical_request = [];
$canonical_request[] = "PUT";
$canonical_request[] = "/" . $content_title;
$canonical_request[] = "";
$canonical_request[] = $canonical_headers;
$canonical_request[] = "";
$canonical_request[] = $signed_headers;
$canonical_request[] = hash('sha256', $content);
$canonical_request = implode("\n", $canonical_request);
$hashed_canonical_request = hash('sha256', $canonical_request);
// AWS Scope
$scope = [];
$scope[] = $date;
$scope[] = $aws_region;
$scope[] = $aws_service_name;
$scope[] = "aws4_request";
// String to sign
$string_to_sign = [];
$string_to_sign[] = "AWS4-HMAC-SHA256";
$string_to_sign[] = $timestamp;
$string_to_sign[] = implode('/', $scope);
$string_to_sign[] = $hashed_canonical_request;
$string_to_sign = implode("\n", $string_to_sign);
// Signing key
$kSecret = 'AWS4' . $aws_secret_access_key;
$kDate = hash_hmac('sha256', $date, $kSecret, true);
$kRegion = hash_hmac('sha256', $aws_region, $kDate, true);
$kService = hash_hmac('sha256', $aws_service_name, $kRegion, true);
$kSigning = hash_hmac('sha256', 'aws4_request', $kService, true);
// Signature
$signature = hash_hmac('sha256', $string_to_sign, $kSigning);
// Authorization
$authorization = [
	'Credential=' . $aws_access_key_id . '/' . implode('/', $scope),
	'SignedHeaders=' . $signed_headers,
	'Signature=' . $signature,
];
$authorization = 'AWS4-HMAC-SHA256' . ' ' . implode( ',', $authorization);
// Curl headers
$curl_headers = [ 'Authorization: ' . $authorization ];
foreach($request_headers as $key => $value) {
	$curl_headers[] = $key . ": " . $value;
}

$url = 'https://' . $host_name . '/' . $content_title;
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, $curl_headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
if($http_code != 200)
	exit('Error : Failed to upload');
 }
}





// copy access log files to desinated aws bucket
function swl_copy_error_log() {

  $options = get_option( 'swl_options', swl_options_default() );

  if ( isset( $options['aws_reigon'] ) && ! empty( $options['aws_reigon'] )
  && isset( $options['aws_endpoint'] ) && ! empty( $options['aws_endpoint'] )
&& isset( $options['aws_access_id'] ) && ! empty( $options['aws_access_id'] )
&& isset( $options['aws_access_key'] ) && ! empty( $options['aws_access_key'] )
&& isset( $options['aws_bucket_name'] ) && ! empty( $options['aws_bucket_name'] )
&& isset( $options['wpe_access_loc'] ) && ! empty( $options['wpe_access_loc'] )
&& isset( $options['wpe_error_loc'] ) && ! empty( $options['wpe_error_loc'] )) {

// AWS API keys
$aws_access_key_id = $options['aws_access_id'];
$aws_secret_access_key = $options['aws_access_key'];
// Bucket
$bucket_name = $options['aws_bucket_name'];
// AWS region
$aws_region = $options['aws_reigon'];
// AWS host name
//$host_name = $bucket_name . '.s3.amazonaws.com';
$host_name = $bucket_name . '.' . $options['aws_endpoint'];
// Server path to file
$content_path = $options['wpe_error_loc'];
$content = file_get_contents($content_path);
// AWS file permissions
$content_acl = 'authenticated-read';
// MIME type of file
$content_type = 'text/plain';
// Service name for S3
$aws_service_name = 's3';
// UTC timestamp and date
$timestamp = gmdate('Ymd\THis\Z');
$date = gmdate('Ymd');
// Name of the content on S3
$content_title = $date . '-error-log.log';
// HTTP request headers as key & value
$request_headers = array();
$request_headers['Content-Type'] = $content_type;
$request_headers['Date'] = $timestamp;
$request_headers['Host'] = $host_name;
$request_headers['x-amz-acl'] = $content_acl;
$request_headers['x-amz-content-sha256'] = hash('sha256', $content);
// Sort it in ascending order
ksort($request_headers);
// Canonical headers
$canonical_headers = [];
foreach($request_headers as $key => $value) {
	$canonical_headers[] = strtolower($key) . ":" . $value;
}
$canonical_headers = implode("\n", $canonical_headers);
// Signed headers
$signed_headers = [];
foreach($request_headers as $key => $value) {
	$signed_headers[] = strtolower($key);
}
$signed_headers = implode(";", $signed_headers);
// Cannonical request
$canonical_request = [];
$canonical_request[] = "PUT";
$canonical_request[] = "/" . $content_title;
$canonical_request[] = "";
$canonical_request[] = $canonical_headers;
$canonical_request[] = "";
$canonical_request[] = $signed_headers;
$canonical_request[] = hash('sha256', $content);
$canonical_request = implode("\n", $canonical_request);
$hashed_canonical_request = hash('sha256', $canonical_request);
// AWS Scope
$scope = [];
$scope[] = $date;
$scope[] = $aws_region;
$scope[] = $aws_service_name;
$scope[] = "aws4_request";
// String to sign
$string_to_sign = [];
$string_to_sign[] = "AWS4-HMAC-SHA256";
$string_to_sign[] = $timestamp;
$string_to_sign[] = implode('/', $scope);
$string_to_sign[] = $hashed_canonical_request;
$string_to_sign = implode("\n", $string_to_sign);
// Signing key
$kSecret = 'AWS4' . $aws_secret_access_key;
$kDate = hash_hmac('sha256', $date, $kSecret, true);
$kRegion = hash_hmac('sha256', $aws_region, $kDate, true);
$kService = hash_hmac('sha256', $aws_service_name, $kRegion, true);
$kSigning = hash_hmac('sha256', 'aws4_request', $kService, true);
// Signature
$signature = hash_hmac('sha256', $string_to_sign, $kSigning);
// Authorization
$authorization = [
	'Credential=' . $aws_access_key_id . '/' . implode('/', $scope),
	'SignedHeaders=' . $signed_headers,
	'Signature=' . $signature,
];
$authorization = 'AWS4-HMAC-SHA256' . ' ' . implode( ',', $authorization);
// Curl headers
$curl_headers = [ 'Authorization: ' . $authorization ];
foreach($request_headers as $key => $value) {
	$curl_headers[] = $key . ": " . $value;
}

$url = 'https://' . $host_name . '/' . $content_title;
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, $curl_headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
if($http_code != 200)
	exit('Error : Failed to upload');
 }
}

register_activation_hook(__FILE__, 'set_up_cron');

function set_up_cron() {
  if ( ! wp_next_scheduled( ‘wp_loaded’ ) ) {
    wp_schedule_event( time(), 'hourly', 'wp_loaded' );
  }
}

add_action('wp_loaded','copy_log');

// copy both access log and error log
function copy_log() {
  return wp_mail("jerrychen017@gmail.com", "Notification TEST", "TEST", null);
  swl_copy_access_log();
  swl_copy_error_log();
}


register_deactivation_hook(__FILE__, 'my_deactivation');

function my_deactivation() {
	wp_clear_scheduled_hook('wp_loaded');
}


// if ( ! wp_next_scheduled( ‘swl_copy_log’ ) ) {
//             wp_schedule_event( time(), ‘daily’, ‘swl_copy_log’ );
//     }
