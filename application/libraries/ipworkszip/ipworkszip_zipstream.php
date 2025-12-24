<?php

require_once('ipworkszip_keys.php');

/**
 * IPWorks ZIP 2020 PHP Edition - ZipStream Component
 *
 * Copyright (c) 2021 /n software inc. - All rights reserved.
 *
 * For more information, please visit http://www.nsoftware.com/.
 *
 */

class IPWorksZip_ZipStream {
  
  var $handle;

  public function __construct() {
    $this->handle = ipworkszip_zipstream_open(IPWORKSZIP_OEMKEY_38);
    ipworkszip_zipstream_register_callback($this->handle, 1, array($this, 'fireCompressedData'));
    ipworkszip_zipstream_register_callback($this->handle, 2, array($this, 'fireDecompressedData'));
    ipworkszip_zipstream_register_callback($this->handle, 3, array($this, 'fireError'));
  }
  
  public function __destruct() {
    ipworkszip_zipstream_close($this->handle);
  }

 /**
  * Returns the last error code.
  *
  * @access   public
  */
  public function lastError() {
    return ipworkszip_zipstream_get_last_error($this->handle);
  }
  
 /**
  * Returns the last error message.
  *
  * @access   public
  */
  public function lastErrorCode() {
    return ipworkszip_zipstream_get_last_error_code($this->handle);
  }

 /**
  * Compresses a block of data.
  *
  * @access   public
  * @param    boolean    lastblock
  */
  public function doCompressBlock($lastblock) {
    $ret = ipworkszip_zipstream_do_compressblock($this->handle, $lastblock);
		$err = $ret;

    if ($err != 0) {
      throw new Exception($ret . ": " . ipworkszip_zipstream_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Compresses the specified data.
  *
  * @access   public
  */
  public function doCompressData() {
    $ret = ipworkszip_zipstream_do_compressdata($this->handle);
		$err = $ret;

    if ($err != 0) {
      throw new Exception($ret . ": " . ipworkszip_zipstream_get_last_error($this->handle));
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
    $ret = ipworkszip_zipstream_do_config($this->handle, $configurationstring);
		$err = ipworkszip_zipstream_get_last_error_code($this->handle);
    if ($err != 0) {
      throw new Exception($ret . ": " . ipworkszip_zipstream_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Decompresses a block of data.
  *
  * @access   public
  */
  public function doDecompressBlock() {
    $ret = ipworkszip_zipstream_do_decompressblock($this->handle);
		$err = $ret;

    if ($err != 0) {
      throw new Exception($ret . ": " . ipworkszip_zipstream_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Decompresses the specified data.
  *
  * @access   public
  */
  public function doDecompressData() {
    $ret = ipworkszip_zipstream_do_decompressdata($this->handle);
		$err = $ret;

    if ($err != 0) {
      throw new Exception($ret . ": " . ipworkszip_zipstream_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Resets the class.
  *
  * @access   public
  */
  public function doReset() {
    $ret = ipworkszip_zipstream_do_reset($this->handle);
		$err = $ret;

    if ($err != 0) {
      throw new Exception($ret . ": " . ipworkszip_zipstream_get_last_error($this->handle));
    }
    return $ret;
  }

   

public function VERSION() {
    return ipworkszip_zipstream_get($this->handle, 0);
  }
 /**
  * The compression level to use.
  *
  * @access   public
  */
  public function getCompressionLevel() {
    return ipworkszip_zipstream_get($this->handle, 1 );
  }
 /**
  * The compression level to use.
  *
  * @access   public
  * @param    int   value
  */
  public function setCompressionLevel($value) {
    $ret = ipworkszip_zipstream_set($this->handle, 1, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . ipworkszip_zipstream_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Specifies the data to compress or decompress.
  *
  * @access   public
  */
  public function getInputData() {
    return ipworkszip_zipstream_get($this->handle, 2 );
  }
 /**
  * Specifies the data to compress or decompress.
  *
  * @access   public
  * @param    string   value
  */
  public function setInputData($value) {
    $ret = ipworkszip_zipstream_set($this->handle, 2, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . ipworkszip_zipstream_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * The output data after compression or decompression.
  *
  * @access   public
  */
  public function getOutputData() {
    return ipworkszip_zipstream_get($this->handle, 3 );
  }


 /**
  * The stream format to use.
  *
  * @access   public
  */
  public function getStreamFormat() {
    return ipworkszip_zipstream_get($this->handle, 4 );
  }
 /**
  * The stream format to use.
  *
  * @access   public
  * @param    int   value
  */
  public function setStreamFormat($value) {
    $ret = ipworkszip_zipstream_set($this->handle, 4, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . ipworkszip_zipstream_get_last_error($this->handle));
    }
    return $ret;
  }



  public function getRuntimeLicense() {
    return ipworkszip_zipstream_get($this->handle, 2011 );
  }

  public function setRuntimeLicense($value) {
    $ret = ipworkszip_zipstream_set($this->handle, 2011, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . ipworkszip_zipstream_get_last_error($this->handle));
    }
    return $ret;
  }
  
 /**
  * This event fires with compressed data.
  *
  * @access   public
  * @param    array   Array of event parameters: data    
  */
  public function fireCompressedData($param) {
    return $param;
  }

 /**
  * This event fires with decompressed data.
  *
  * @access   public
  * @param    array   Array of event parameters: data    
  */
  public function fireDecompressedData($param) {
    return $param;
  }

 /**
  * Information about errors during data delivery.
  *
  * @access   public
  * @param    array   Array of event parameters: errorcode, description    
  */
  public function fireError($param) {
    return $param;
  }


}

?>
