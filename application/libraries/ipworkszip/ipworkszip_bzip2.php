<?php

require_once('ipworkszip_keys.php');

/**
 * IPWorks ZIP 2020 PHP Edition - Bzip2 Component
 *
 * Copyright (c) 2021 /n software inc. - All rights reserved.
 *
 * For more information, please visit http://www.nsoftware.com/.
 *
 */

class IPWorksZip_Bzip2 {
  
  var $handle;

  public function __construct() {
    $this->handle = ipworkszip_bzip2_open(IPWORKSZIP_OEMKEY_36);
    ipworkszip_bzip2_register_callback($this->handle, 1, array($this, 'fireBeginFile'));
    ipworkszip_bzip2_register_callback($this->handle, 2, array($this, 'fireEndFile'));
    ipworkszip_bzip2_register_callback($this->handle, 3, array($this, 'fireError'));
    ipworkszip_bzip2_register_callback($this->handle, 4, array($this, 'fireOverwrite'));
    ipworkszip_bzip2_register_callback($this->handle, 5, array($this, 'fireProgress'));
  }
  
  public function __destruct() {
    ipworkszip_bzip2_close($this->handle);
  }

 /**
  * Returns the last error code.
  *
  * @access   public
  */
  public function lastError() {
    return ipworkszip_bzip2_get_last_error($this->handle);
  }
  
 /**
  * Returns the last error message.
  *
  * @access   public
  */
  public function lastErrorCode() {
    return ipworkszip_bzip2_get_last_error_code($this->handle);
  }

 /**
  * Aborts the current operation.
  *
  * @access   public
  */
  public function doAbort() {
    $ret = ipworkszip_bzip2_do_abort($this->handle);
		$err = $ret;

    if ($err != 0) {
      throw new Exception($ret . ": " . ipworkszip_bzip2_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Adds specified file to an existing archive.
  *
  * @access   public
  */
  public function doAppend() {
    $ret = ipworkszip_bzip2_do_append($this->handle);
		$err = $ret;

    if ($err != 0) {
      throw new Exception($ret . ": " . ipworkszip_bzip2_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Creates the compressed bzip2 archive.
  *
  * @access   public
  */
  public function doCompress() {
    $ret = ipworkszip_bzip2_do_compress($this->handle);
		$err = $ret;

    if ($err != 0) {
      throw new Exception($ret . ": " . ipworkszip_bzip2_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Sets or retrieves a configuration setting.
  *
  * @access   public
  * @param    string    configurationstring
  */
  public function doConfig($configurationstring) {
    $ret = ipworkszip_bzip2_do_config($this->handle, $configurationstring);
		$err = ipworkszip_bzip2_get_last_error_code($this->handle);
    if ($err != 0) {
      throw new Exception($ret . ": " . ipworkszip_bzip2_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Extracts the compressed file from the bzip2 archive.
  *
  * @access   public
  */
  public function doExtract() {
    $ret = ipworkszip_bzip2_do_extract($this->handle);
		$err = $ret;

    if ($err != 0) {
      throw new Exception($ret . ": " . ipworkszip_bzip2_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Extracts all files from the compressed archive.
  *
  * @access   public
  */
  public function doExtractAll() {
    $ret = ipworkszip_bzip2_do_extractall($this->handle);
		$err = $ret;

    if ($err != 0) {
      throw new Exception($ret . ": " . ipworkszip_bzip2_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Resets the class.
  *
  * @access   public
  */
  public function doReset() {
    $ret = ipworkszip_bzip2_do_reset($this->handle);
		$err = $ret;

    if ($err != 0) {
      throw new Exception($ret . ": " . ipworkszip_bzip2_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Scans the compressed archive.
  *
  * @access   public
  */
  public function doScan() {
    $ret = ipworkszip_bzip2_do_scan($this->handle);
		$err = $ret;

    if ($err != 0) {
      throw new Exception($ret . ": " . ipworkszip_bzip2_get_last_error($this->handle));
    }
    return $ret;
  }

   

public function VERSION() {
    return ipworkszip_bzip2_get($this->handle, 0);
  }
 /**
  * The name of the zip, gzip, tar, or jar archive.
  *
  * @access   public
  */
  public function getArchiveFile() {
    return ipworkszip_bzip2_get($this->handle, 1 );
  }
 /**
  * The name of the zip, gzip, tar, or jar archive.
  *
  * @access   public
  * @param    string   value
  */
  public function setArchiveFile($value) {
    $ret = ipworkszip_bzip2_set($this->handle, 1, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . ipworkszip_bzip2_get_last_error($this->handle));
    }
    return $ret;
  }


 /**
  * (Decompression only) The bzip2 file contents as a byte array.
  *
  * @access   public
  * @param    string   value
  */
  public function setBzip2Data($value) {
    $ret = ipworkszip_bzip2_set($this->handle, 2, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . ipworkszip_bzip2_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * A base path to decompress to.
  *
  * @access   public
  */
  public function getExtractToPath() {
    return ipworkszip_bzip2_get($this->handle, 3 );
  }
 /**
  * A base path to decompress to.
  *
  * @access   public
  * @param    string   value
  */
  public function setExtractToPath($value) {
    $ret = ipworkszip_bzip2_set($this->handle, 3, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . ipworkszip_bzip2_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * File name to decompress to, or compress from.
  *
  * @access   public
  */
  public function getFileDecompressedName() {
    return ipworkszip_bzip2_get($this->handle, 4 );
  }
 /**
  * File name to decompress to, or compress from.
  *
  * @access   public
  * @param    string   value
  */
  public function setFileDecompressedName($value) {
    $ret = ipworkszip_bzip2_set($this->handle, 4, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . ipworkszip_bzip2_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * The data of the file to be compressed.
  *
  * @access   public
  */
  public function getFileInputData() {
    return ipworkszip_bzip2_get($this->handle, 5 );
  }
 /**
  * The data of the file to be compressed.
  *
  * @access   public
  * @param    string   value
  */
  public function setFileInputData($value) {
    $ret = ipworkszip_bzip2_set($this->handle, 5, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . ipworkszip_bzip2_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Shows whether or not there is more data in the bzip2 archive.
  *
  * @access   public
  */
  public function getHasMoreData() {
    return ipworkszip_bzip2_get($this->handle, 6 );
  }




  public function getRuntimeLicense() {
    return ipworkszip_bzip2_get($this->handle, 2011 );
  }

  public function setRuntimeLicense($value) {
    $ret = ipworkszip_bzip2_set($this->handle, 2011, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . ipworkszip_bzip2_get_last_error($this->handle));
    }
    return $ret;
  }
  
 /**
  * Fired before a file is processed.
  *
  * @access   public
  * @param    array   Array of event parameters: index, skip    
  */
  public function fireBeginFile($param) {
    return $param;
  }

 /**
  * Fired after a file is processed.
  *
  * @access   public
  * @param    array   Array of event parameters: index    
  */
  public function fireEndFile($param) {
    return $param;
  }

 /**
  * Information about non-fatal errors.
  *
  * @access   public
  * @param    array   Array of event parameters: description, errorcode, index, filename, ignore    
  */
  public function fireError($param) {
    return $param;
  }

 /**
  * Fired whenever a file exists and may be overwritten.
  *
  * @access   public
  * @param    array   Array of event parameters: filename, overwrite    
  */
  public function fireOverwrite($param) {
    return $param;
  }

 /**
  * Fired as progress is made.
  *
  * @access   public
  * @param    array   Array of event parameters: data, filename, bytesprocessed, percentprocessed    
  */
  public function fireProgress($param) {
    return $param;
  }


}

?>
