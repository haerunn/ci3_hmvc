<?php
	
	function printr($string)
	{
		echo "<pre>";
		print_r($string);
		echo "</pre>";
	}

	// **
	// taken from: https://www.geeksforgeeks.org/copy-the-entire-contents-of-a-directory-to-another-directory-in-php/
	function rcopy($src, $dst) { 
		// open the source directory
		$dir = opendir($src); 

		// Make the destination directory if not exist
		@mkdir($dst);

		// Loop through the files in source directory
		while( $file = readdir($dir) ) {
			if (( $file != '.' ) && ( $file != '..' )) {
				if ( is_dir($src . '/' . $file) ){ 
					// Recursively calling custom copy function
					// for sub directory
					rcopy($src . '/' . $file, $dst . '/' . $file);
				} else {
					copy($src . '/' . $file, $dst . '/' . $file);
				}
			}
		}
		closedir($dir);
	}
?>