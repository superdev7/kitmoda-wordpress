<?php
/**
 * S3 Configuration Parameters
 *
 *
**/

define('S3_BUCKET', 'payload-k1'); //Changed from orkint to kitmoda
define('S3_ACCESS_KEY_ID', 'AKIAJXFC3FSC4ZBCFEXQ');
define('S3_SECRET', '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');
define('S3_ACL', 'private');
define('S3_URL', 'https://'.S3_BUCKET.'.s3.amazonaws.com/');
define('S3_DOWNLOAD_EXPIRE_TIME', '+2 hours');




?>
