<?php

/**
 * Generic function to show a message to the user using WP's 
 * standard CSS classes to make use of the already-defined
 * message colour scheme.
 *
 * @param $message
 *    The message you want to tell the user.
 * @param $is_error
 *    If true, the message is an error, so use the red message style. If false, 
 *    the message is a status message, so use the yellow information message 
 *    style.
 */
function wle_show_message($message, $is_error = false) {
  $class = ($is_error) ? "error" : "updated fade";

  echo '<div id="message" class="' . $class . '"><p>' . $message . '</p></div>';
}  

// remove Folders (recursive) and Files
function deleteDirAndFile($dirPath){
  if (is_dir($dirPath)) {
    if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
        $dirPath .= '/';
    }
    $files = glob($dirPath . '*', GLOB_MARK);
    foreach ($files as $file) {
        if (is_dir($file)) {
            deleteDir($file);
        } else {
            unlink($file);
        }
    }
    rmdir($dirPath);
  } else {
    unlink($dirPath);
  }
}

/**
 * Remove scripts version (js & css)
 */
function remove_ver_scripts($src){
  if ( strpos( $src, 'ver=' ) )
    $src = remove_query_arg( 'ver', $src );
  return $src;
}