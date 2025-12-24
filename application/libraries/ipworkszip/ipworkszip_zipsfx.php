<?php

require_once('ipworkszip_keys.php');

/**
 * IPWorks ZIP 2020 PHP Edition - ZipSFX Component
 *
 * Copyright (c) 2021 /n software inc. - All rights reserved.
 *
 * For more information, please visit http://www.nsoftware.com/.
 *
 */

class IPWorksZip_ZipSFX {
  
  var $handle;

  public function __construct() {
    $this->handle = ipworkszip_zipsfx_open(IPWORKSZIP_OEMKEY_39);
    ipworkszip_zipsfx_register_callback($this->handle, 1, array($this, 'fireError'));
    ipworkszip_zipsfx_register_callback($this->handle, 2, array($this, 'fireProgress'));
  }
  
  public function __destruct() {
    ipworkszip_zipsfx_close($this->handle);
  }

 /**
  * Returns the last error code.
  *
  * @access   public
  */
  public function lastError() {
    return ipworkszip_zipsfx_get_last_error($this->handle);
  }
  
 /**
  * Returns the last error message.
  *
  * @access   public
  */
  public function lastErrorCode() {
    return ipworkszip_zipsfx_get_last_error_code($this->handle);
  }

 /**
  * Sets or retrieves a configuration setting.
  *
  * @access   public
  * @param    string    configurationstring
  */
  public function doConfig($configurationstring) {
    $ret = ipworkszip_zipsfx_do_config($this->handle, $configurationstring);
		$err = ipworkszip_zipsfx_get_last_error_code($this->handle);
    if ($err != 0) {
      throw new Exception($ret . ": " . ipworkszip_zipsfx_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Compresses the files and creates a self-extracting archive.
  *
  * @access   public
  */
  public function doCreateSFX() {
    $ret = ipworkszip_zipsfx_do_createsfx($this->handle);
		$err = $ret;

    if ($err != 0) {
      throw new Exception($ret . ": " . ipworkszip_zipsfx_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Resets the class.
  *
  * @access   public
  */
  public function doReset() {
    $ret = ipworkszip_zipsfx_do_reset($this->handle);
		$err = $ret;

    if ($err != 0) {
      throw new Exception($ret . ": " . ipworkszip_zipsfx_get_last_error($this->handle));
    }
    return $ret;
  }

   

public function VERSION() {
    return ipworkszip_zipsfx_get($this->handle, 0);
  }
 /**
  * The name of the self-extracting zip archive to create.
  *
  * @access   public
  */
  public function getArchiveFile() {
    return ipworkszip_zipsfx_get($this->handle, 1 );
  }
 /**
  * The name of the self-extracting zip archive to create.
  *
  * @access   public
  * @param    string   value
  */
  public function setArchiveFile($value) {
    $ret = ipworkszip_zipsfx_set($this->handle, 1, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . ipworkszip_zipsfx_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Optional banner text to show before the self-extraction starts.
  *
  * @access   public
  */
  public function getBannerText() {
    return ipworkszip_zipsfx_get($this->handle, 2 );
  }
 /**
  * Optional banner text to show before the self-extraction starts.
  *
  * @access   public
  * @param    string   value
  */
  public function setBannerText($value) {
    $ret = ipworkszip_zipsfx_set($this->handle, 2, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . ipworkszip_zipsfx_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Optional caption (title) text for the self-extractor dialogs.
  *
  * @access   public
  */
  public function getCaptionText() {
    return ipworkszip_zipsfx_get($this->handle, 3 );
  }
 /**
  * Optional caption (title) text for the self-extractor dialogs.
  *
  * @access   public
  * @param    string   value
  */
  public function setCaptionText($value) {
    $ret = ipworkszip_zipsfx_set($this->handle, 3, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . ipworkszip_zipsfx_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * The compression level to use.
  *
  * @access   public
  */
  public function getCompressionLevel() {
    return ipworkszip_zipsfx_get($this->handle, 4 );
  }
 /**
  * The compression level to use.
  *
  * @access   public
  * @param    int   value
  */
  public function setCompressionLevel($value) {
    $ret = ipworkszip_zipsfx_set($this->handle, 4, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . ipworkszip_zipsfx_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Optional target directory for the self-extractor.
  *
  * @access   public
  */
  public function getExtractToPath() {
    return ipworkszip_zipsfx_get($this->handle, 5 );
  }
 /**
  * Optional target directory for the self-extractor.
  *
  * @access   public
  * @param    string   value
  */
  public function setExtractToPath($value) {
    $ret = ipworkszip_zipsfx_set($this->handle, 5, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . ipworkszip_zipsfx_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Optional file to execute (open) after the archive is extracted.
  *
  * @access   public
  */
  public function getFileToExecute() {
    return ipworkszip_zipsfx_get($this->handle, 6 );
  }
 /**
  * Optional file to execute (open) after the archive is extracted.
  *
  * @access   public
  * @param    string   value
  */
  public function setFileToExecute($value) {
    $ret = ipworkszip_zipsfx_set($this->handle, 6, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . ipworkszip_zipsfx_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * An optional password for the self-extracting archive.
  *
  * @access   public
  */
  public function getPassword() {
    return ipworkszip_zipsfx_get($this->handle, 7 );
  }
 /**
  * An optional password for the self-extracting archive.
  *
  * @access   public
  * @param    string   value
  */
  public function setPassword($value) {
    $ret = ipworkszip_zipsfx_set($this->handle, 7, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . ipworkszip_zipsfx_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Whether or not to recurse into subdirectories during archive creation.
  *
  * @access   public
  */
  public function getRecurseSubdirectories() {
    return ipworkszip_zipsfx_get($this->handle, 8 );
  }
 /**
  * Whether or not to recurse into subdirectories during archive creation.
  *
  * @access   public
  * @param    boolean   value
  */
  public function setRecurseSubdirectories($value) {
    $ret = ipworkszip_zipsfx_set($this->handle, 8, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . ipworkszip_zipsfx_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Directory to be compressed into a self-extracting archive.
  *
  * @access   public
  */
  public function getSourceDirectory() {
    return ipworkszip_zipsfx_get($this->handle, 9 );
  }
 /**
  * Directory to be compressed into a self-extracting archive.
  *
  * @access   public
  * @param    string   value
  */
  public function setSourceDirectory($value) {
    $ret = ipworkszip_zipsfx_set($this->handle, 9, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . ipworkszip_zipsfx_get_last_error($this->handle));
    }
    return $ret;
  }



  public function getRuntimeLicense() {
    return ipworkszip_zipsfx_get($this->handle, 2011 );
  }

  public function setRuntimeLicense($value) {
    $ret = ipworkszip_zipsfx_set($this->handle, 2011, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . ipworkszip_zipsfx_get_last_error($this->handle));
    }
    return $ret;
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
  * Fired as progress is made.
  *
  * @access   public
  * @param    array   Array of event parameters: filename, bytesprocessed, percentprocessed    
  */
  public function fireProgress($param) {
    return $param;
  }


}

?>
