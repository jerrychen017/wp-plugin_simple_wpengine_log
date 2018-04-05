<?php // Simple WPEngine Log - Core Functionality

// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {

	exit;

}

require 'vendor/autoload.php';
use Aws\S3\S3Client;
use Aws\Exception\AwsException;

// copy access log files to desinated aws bucket
function swl_copy_access_log() {

  $options = get_option( 'swl_options', swl_options_default() );

  if ( isset( $options['aws_reigon'] ) && ! empty( $options['aws_reigon'] )
&& isset( $options['aws_access_id'] ) && ! empty( $options['aws_access_id'] )
&& isset( $options['aws_access_key'] ) && ! empty( $options['aws_access_key'] )
&& isset( $options['aws_bucket_name'] ) && ! empty( $options['aws_bucket_name'] )
&& $options['aws_reigon'] != 'NULL'
&& $options['aws_access_id'] != 'NULL'
&& $options['aws_access_key'] != 'NULL'
&& $options['aws_bucket_name'] != 'NULL') {

  $bucket = $options['aws_bucket_name'];
  $file_Path = '/';
  $key = basename('test.log');
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
          'Key'        => $key,
          'SourceFile' => $file_Path,
      ]);
  } catch (S3Exception $e) {
      echo $e->getMessage() . "\n";
  }
}
}
add_action('wp_loaded', 'swl_copy_access_log');
