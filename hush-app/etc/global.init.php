<?php
/**
 * Global init logics
 */
if (defined('__HUSH_CLI')) {
	
	// check path
	if (!is_dir(__COMM_LIB_DIR)) {
		mkdir(__COMM_LIB_DIR, 0777, true);
	}
	if (!is_dir(__HUSH_LIB_DIR)) {
		mkdir(__HUSH_LIB_DIR, 0777, true);
	}
	
	// check core libraries
	$hushDir = __HUSH_LIB_DIR . DIRECTORY_SEPARATOR . 'Hush';
	if (!is_dir($hushDir)) {
		// download Zend Framework
		echo "\nInstalling Hush Framework ..\n";
		$downFile = 'http://hush-framework.googlecode.com/files/HushFramework.zip';
		$saveFile = $hushDir . 'HushFramework.zip';
		$savePath = $hushDir . '.';
		if (_hush_download($downFile, $saveFile)) {
			echo "Extracting.. ";
			$zip = new ZipArchive;
			$zip->open($saveFile);
			$zip->extractTo($savePath);
			$zip->close();
			unset($zip);
			echo "Done!\n";
		}
	}
}

// check other libraries
$zendDir = __COMM_LIB_DIR . DIRECTORY_SEPARATOR . 'Zend';
if (!is_dir($zendDir)) {
	echo "Please enter 'hush_app/bin' and use 'hush sys init' command to complete the installation.";
	exit(1);
}