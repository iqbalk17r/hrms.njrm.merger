<?php

require_once('ipworkszip_keys.php');

/**
 * IPWorks ZIP 2020 PHP Edition - Jar Component
 *
 * Copyright (c) 2021 /n software inc. - All rights reserved.
 *
 * For more information, please visit http://www.nsoftware.com/.
 *
 */

class IPWorksZip_Jar {
  
  var $handle;

  public function __construct() {
    $this->handle = ipworkszip_jar_open(IPWORKSZIP_OEMKEY_33);
    ipworkszip_jar_register_callback($this->handle, 1, array($this, 'fireBeginFile'));
    ipworkszip_jar_register_callback($this->handle, 2, array($this, 'fireEndFile'));
    ipworkszip_jar_register_callback($this->handle, 3, array($this, 'fireError'));
    ipworkszip_jar_register_callback($this->handle, 4, array($this, 'fireOverwrite'));
    ipworkszip_jar_register_callback($this->handle, 5, array($this, 'fireProgress'));
  }
  
  public function __destruct() {
    ipworkszip_jar_close($this->handle);
  }

 /**
  * Returns the last error code.
  *
  * @access   public
  */
  public function lastError() {
    return ipworkszip_jar_get_last_error($this->handle);
  }
  
 /**
  * Returns the last error message.
  *
  * @access   public
  */
  public function lastErrorCode() {
    return ipworkszip_jar_get_last_error_code($this->handle);
  }

 /**
  * Aborts the current operation.
  *
  * @access   public
  */
  public function doAbort() {
    $ret = ipworkszip_jar_do_abort($this->handle);
		$err = $ret;

    if ($err != 0) {
      throw new Exception($ret . ": " . ipworkszip_jar_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Adds specified files to an existing archive.
  *
  * @access   public
  */
  public function doAppendFiles() {
    $ret = ipworkszip_jar_do_appendfiles($this->handle);
		$err = $ret;

    if ($err != 0) {
      throw new Exception($ret . ": " . ipworkszip_jar_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Creates the compressed archive.
  *
  * @access   public
  */
  public function doCompress() {
    $ret = ipworkszip_jar_do_compress($this->handle);
		$err = $ret;

    if ($err != 0) {
      throw new Exception($ret . ": " . ipworkszip_jar_get_last_error($this->handle));
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
    $ret = ipworkszip_jar_do_config($this->handle, $configurationstring);
		$err = ipworkszip_jar_get_last_error_code($this->handle);
    if ($err != 0) {
      throw new Exception($ret . ": " . ipworkszip_jar_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Deletes one or more files from an existing archive.
  *
  * @access   public
  * @param    string    filenames
  */
  public function doDelete($filenames) {
    $ret = ipworkszip_jar_do_delete($this->handle, $filenames);
		$err = $ret;

    if ($err != 0) {
      throw new Exception($ret . ": " . ipworkszip_jar_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Extracts a single file, directory, or group of files, from the archive.
  *
  * @access   public
  * @param    string    filenames
  */
  public function doExtract($filenames) {
    $ret = ipworkszip_jar_do_extract($this->handle, $filenames);
		$err = $ret;

    if ($err != 0) {
      throw new Exception($ret . ": " . ipworkszip_jar_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Extracts all files from the compressed archive.
  *
  * @access   public
  */
  public function doExtractAll() {
    $ret = ipworkszip_jar_do_extractall($this->handle);
		$err = $ret;

    if ($err != 0) {
      throw new Exception($ret . ": " . ipworkszip_jar_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Specifies that the indicated files should be added to the archive.
  *
  * @access   public
  * @param    string    filenames
  */
  public function doIncludeFiles($filenames) {
    $ret = ipworkszip_jar_do_includefiles($this->handle, $filenames);
		$err = $ret;

    if ($err != 0) {
      throw new Exception($ret . ": " . ipworkszip_jar_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Resets the class.
  *
  * @access   public
  */
  public function doReset() {
    $ret = ipworkszip_jar_do_reset($this->handle);
		$err = $ret;

    if ($err != 0) {
      throw new Exception($ret . ": " . ipworkszip_jar_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Scans the compressed archive.
  *
  * @access   public
  */
  public function doScan() {
    $ret = ipworkszip_jar_do_scan($this->handle);
		$err = $ret;

    if ($err != 0) {
      throw new Exception($ret . ": " . ipworkszip_jar_get_last_error($this->handle));
    }
    return $ret;
  }

   

public function VERSION() {
    return ipworkszip_jar_get($this->handle, 0);
  }
 /**
  * The name of the zip, gzip, tar, or jar archive.
  *
  * @access   public
  */
  public function getArchiveFile() {
    return ipworkszip_jar_get($this->handle, 1 );
  }
 /**
  * The name of the zip, gzip, tar, or jar archive.
  *
  * @access   public
  * @param    string   value
  */
  public function setArchiveFile($value) {
    $ret = ipworkszip_jar_set($this->handle, 1, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . ipworkszip_jar_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * The compression level to use.
  *
  * @access   public
  */
  public function getCompressionLevel() {
    return ipworkszip_jar_get($this->handle, 2 );
  }
 /**
  * The compression level to use.
  *
  * @access   public
  * @param    int   value
  */
  public function setCompressionLevel($value) {
    $ret = ipworkszip_jar_set($this->handle, 2, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . ipworkszip_jar_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * A list of files to exclude.
  *
  * @access   public
  */
  public function getExcludedFiles() {
    return ipworkszip_jar_get($this->handle, 3 );
  }
 /**
  * A list of files to exclude.
  *
  * @access   public
  * @param    string   value
  */
  public function setExcludedFiles($value) {
    $ret = ipworkszip_jar_set($this->handle, 3, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . ipworkszip_jar_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * A base path to decompress to.
  *
  * @access   public
  */
  public function getExtractToPath() {
    return ipworkszip_jar_get($this->handle, 4 );
  }
 /**
  * A base path to decompress to.
  *
  * @access   public
  * @param    string   value
  */
  public function setExtractToPath($value) {
    $ret = ipworkszip_jar_set($this->handle, 4, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . ipworkszip_jar_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * The number of records in the File arrays.
  *
  * @access   public
  */
  public function getFileCount() {
    return ipworkszip_jar_get($this->handle, 5 );
  }
 /**
  * The number of records in the File arrays.
  *
  * @access   public
  * @param    int   value
  */
  public function setFileCount($value) {
    $ret = ipworkszip_jar_set($this->handle, 5, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . ipworkszip_jar_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * The date and time of the entry, as stored within the archive.
  *
  * @access   public
  */
  public function getFileCompressedDate($fileindex) {
    return ipworkszip_jar_get($this->handle, 6 , $fileindex);
  }
 /**
  * The date and time of the entry, as stored within the archive.
  *
  * @access   public
  * @param    int64   value
  */
  public function setFileCompressedDate($fileindex, $value) {
    $ret = ipworkszip_jar_set($this->handle, 6, $value , $fileindex);
    if ($ret != 0) {
      throw new Exception($ret . ": " . ipworkszip_jar_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * The file name of the current file, as stored inside of the archive.
  *
  * @access   public
  */
  public function getFileCompressedName($fileindex) {
    return ipworkszip_jar_get($this->handle, 7 , $fileindex);
  }
 /**
  * The file name of the current file, as stored inside of the archive.
  *
  * @access   public
  * @param    string   value
  */
  public function setFileCompressedName($fileindex, $value) {
    $ret = ipworkszip_jar_set($this->handle, 7, $value , $fileindex);
    if ($ret != 0) {
      throw new Exception($ret . ": " . ipworkszip_jar_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * The size of the compressed data, as compressed within  the archive.
  *
  * @access   public
  */
  public function getFileCompressedSize($fileindex) {
    return ipworkszip_jar_get($this->handle, 8 , $fileindex);
  }


 /**
  * The name of the file in the archive, as stored on the file system, outside the archive.
  *
  * @access   public
  */
  public function getFileDecompressedName($fileindex) {
    return ipworkszip_jar_get($this->handle, 9 , $fileindex);
  }
 /**
  * The name of the file in the archive, as stored on the file system, outside the archive.
  *
  * @access   public
  * @param    string   value
  */
  public function setFileDecompressedName($fileindex, $value) {
    $ret = ipworkszip_jar_set($this->handle, 9, $value , $fileindex);
    if ($ret != 0) {
      throw new Exception($ret . ": " . ipworkszip_jar_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * The size of the file, as decompressed outside the archive.
  *
  * @access   public
  */
  public function getFileDecompressedSize($fileindex) {
    return ipworkszip_jar_get($this->handle, 10 , $fileindex);
  }


 /**
  * When This property is set, the class will read in the data  from This property instead of reading from the file contained  in the DecompressedName property.
  *
  * @access   public
  */
  public function getFileInputData($fileindex) {
    return ipworkszip_jar_get($this->handle, 11 , $fileindex);
  }
 /**
  * When This property is set, the class will read in the data  from This property instead of reading from the file contained  in the DecompressedName property.
  *
  * @access   public
  * @param    string   value
  */
  public function setFileInputData($fileindex, $value) {
    $ret = ipworkszip_jar_set($this->handle, 11, $value , $fileindex);
    if ($ret != 0) {
      throw new Exception($ret . ": " . ipworkszip_jar_get_last_error($this->handle));
    }
    return $ret;
  }


 /**
  * (Decompression only) The jar file contents as a byte array.
  *
  * @access   public
  * @param    string   value
  */
  public function setJarData($value) {
    $ret = ipworkszip_jar_set($this->handle, 13, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . ipworkszip_jar_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * The name of the manifest file.
  *
  * @access   public
  */
  public function getManifestFile() {
    return ipworkszip_jar_get($this->handle, 14 );
  }
 /**
  * The name of the manifest file.
  *
  * @access   public
  * @param    string   value
  */
  public function setManifestFile($value) {
    $ret = ipworkszip_jar_set($this->handle, 14, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . ipworkszip_jar_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Whether or not to overwrite files.
  *
  * @access   public
  */
  public function getOverwriteFiles() {
    return ipworkszip_jar_get($this->handle, 15 );
  }
 /**
  * Whether or not to overwrite files.
  *
  * @access   public
  * @param    boolean   value
  */
  public function setOverwriteFiles($value) {
    $ret = ipworkszip_jar_set($this->handle, 15, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . ipworkszip_jar_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Whether or not to recurse into subdirectories.
  *
  * @access   public
  */
  public function getRecurseSubdirectories() {
    return ipworkszip_jar_get($this->handle, 16 );
  }
 /**
  * Whether or not to recurse into subdirectories.
  *
  * @access   public
  * @param    boolean   value
  */
  public function setRecurseSubdirectories($value) {
    $ret = ipworkszip_jar_set($this->handle, 16, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . ipworkszip_jar_get_last_error($this->handle));
    }
    return $ret;
  }



  public function getRuntimeLicense() {
    return ipworkszip_jar_get($this->handle, 2011 );
  }

  public function setRuntimeLicense($value) {
    $ret = ipworkszip_jar_set($this->handle, 2011, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . ipworkszip_jar_get_last_error($this->handle));
    }
    return $ret;
  }
  
 /**
  * Fired before each file is processed.
  *
  * @access   public
  * @param    array   Array of event parameters: index, skip    
  */
  public function fireBeginFile($param) {
    return $param;
  }

 /**
  * Fired after each file is processed.
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
