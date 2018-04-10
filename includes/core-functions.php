<?php // Simple WPEngine Log - Core Functionality

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

require 'vendor/autoload.php';
use Aws\S3\S3Client;
use Aws\Exception\AwsException;

// copy access log files to desinated aws bucket
function swl_copy_log() {

  $options = get_option( 'swl_options', swl_options_default() );

  if ( isset( $options['aws_reigon'] ) && ! empty( $options['aws_reigon'] )
&& isset( $options['aws_access_id'] ) && ! empty( $options['aws_access_id'] )
&& isset( $options['aws_access_key'] ) && ! empty( $options['aws_access_key'] )
&& isset( $options['aws_bucket_name'] ) && ! empty( $options['aws_bucket_name'] )
&& isset( $options['wpengine_log_reference_id'] ) && ! empty( $options['wpengine_log_reference_id'] )) {

  $bucket = $options['aws_bucket_name'];
  $file_Path = '/' . $options['wpengine_log_reference_id'] . '/logs/';
  $key = basename('current.log');
  try{
      //Create a S3Client
      $s3Client = new S3Client([
        'version'     => 'latest',
        'region'      => $options['aws_reigon'],
        'credentials' => [
            'key'    => $options['aws_access_id'],
            'secret' => $options['aws_access_key'],
        ],
    ]);

      $result = $s3Client->putObject([
          'Bucket'     => $bucket,
          'Key'        => $·key,
          'SourceFile' => $file_Path,
      ]);
  } catch (S3Exception $e) {
      echo $e->getMessage() . "\n";
  }
 }
}

if ( ! wp_next_scheduled( ‘swl_copy_log’ ) ) {
            wp_schedule_event( time(), ‘hourly’, ‘swl_copy_log’ );
}
