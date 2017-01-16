<?php
/**
 * S3 Configuration Parameters
 *
 *
**/

define('S3_BUCKET', 'kitmoda'); //Changed from orkint to kitmoda
define('S3_ACCESS_KEY_ID', 'AKIAJJRFM43KLNS3CHDA');
define('S3_SECRET', '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');
define('S3_ACL', 'private');
define('S3_URL', 'https://'.S3_BUCKET.'.s3.amazonaws.com/');
define('S3_DOWNLOAD_EXPIRE_TIME', '+2 hours');




?>
