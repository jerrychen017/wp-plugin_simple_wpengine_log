<?php // Simple WPEngine Log - Core Functionality

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly



// schedule a cron job swl_copy_cron is it was not scheduled
if ( ! wp_next_scheduled( 'swl_copy_cron' ) ) {
  wp_schedule_event( time(), 'daily', 'swl_copy_cron' );
  // pause for 60 seconds to avoid repetitive scheduling
  sleep(60);
}

add_action('swl_copy_cron','copy_log');

register_deactivation_hook( __FILE__, 'swl_deactivate' );
function swl_deactivate() {
  wp_clear_scheduled_hook('swl_copy_cron');
}

// determines if all option fields have been setup
function is_set_all_fields() {
  // reigon is set and not empty
  return isset( $options['aws_reigon'] )
  && ! empty( $options['aws_reigon'] )
  // aws endpoint is set and not empty
  && isset( $options['aws_endpoint'] )
  && ! empty( $options['aws_endpoint'] )
  // aws access id is set and not empty
&& isset( $options['aws_access_id'] )
&& ! empty( $options['aws_access_id'] )
// aws secrete key is set and not empty
&& isset( $options['aws_access_key'] )
&& ! empty( $options['aws_access_key'] )
// aws bucket name is set and not empty
&& isset( $options['aws_bucket_name'] )
&& ! empty( $options['aws_bucket_name'] )
// wpe access log location is set and not empty
&& isset( $options['wpe_access_loc'] )
&& ! empty( $options['wpe_access_loc'] )
// wpe error log location is set and not empty
&& isset( $options['wpe_error_loc'] )
&& ! empty( $options['wpe_error_loc'] );
}

// copy access log files to desinated aws bucket
function swl_copy_access_log() {

  $options = get_option( 'swl_options', swl_options_default() );

  if ( is_set_all_fields()) {

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
if($http_code != 200) {
  $access_log_error = new WP_Erorr('Error', 'Access log could not be uploaded', 'Data??');
  print_r($access_log_error);
}
 }
}

// copy access log files to desinated aws bucket
function swl_copy_error_log() {

  $options = get_option( 'swl_options', swl_options_default() );

  if ( is_set_all_fields()) {

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
if($http_code != 200) {
  $error_log_error = new WP_Erorr('Error', 'Error log could not be uploaded', 'Data??');
  print_r($error_log_error);
}
 }
}

// copy both access log and error log, and send notification email to the admin
function copy_log() {
  swl_copy_access_log();
  swl_copy_error_log();
  return wp_mail("jerrychen017@gmail.com", "Notification Sent hourly", "TEST", null);
}
