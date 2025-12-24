<?php

require_once('ipworkszip_keys.php');

/**
 * IPWorks ZIP 2020 PHP Edition - OfficeDoc Component
 *
 * Copyright (c) 2021 /n software inc. - All rights reserved.
 *
 * For more information, please visit http://www.nsoftware.com/.
 *
 */

class IPWorksZip_OfficeDoc {
  
  var $handle;

  public function __construct() {
    $this->handle = ipworkszip_officedoc_open(IPWORKSZIP_OEMKEY_41);
    ipworkszip_officedoc_register_callback($this->handle, 1, array($this, 'fireBeginFile'));
    ipworkszip_officedoc_register_callback($this->handle, 2, array($this, 'fireCharacters'));
    ipworkszip_officedoc_register_callback($this->handle, 3, array($this, 'fireComment'));
    ipworkszip_officedoc_register_callback($this->handle, 4, array($this, 'fireEndElement'));
    ipworkszip_officedoc_register_callback($this->handle, 5, array($this, 'fireEndFile'));
    ipworkszip_officedoc_register_callback($this->handle, 6, array($this, 'fireEndPrefixMapping'));
    ipworkszip_officedoc_register_callback($this->handle, 7, array($this, 'fireError'));
    ipworkszip_officedoc_register_callback($this->handle, 8, array($this, 'fireEvalEntity'));
    ipworkszip_officedoc_register_callback($this->handle, 9, array($this, 'fireIgnorableWhitespace'));
    ipworkszip_officedoc_register_callback($this->handle, 10, array($this, 'fireMeta'));
    ipworkszip_officedoc_register_callback($this->handle, 11, array($this, 'fireOverwrite'));
    ipworkszip_officedoc_register_callback($this->handle, 12, array($this, 'firePI'));
    ipworkszip_officedoc_register_callback($this->handle, 13, array($this, 'fireProgress'));
    ipworkszip_officedoc_register_callback($this->handle, 14, array($this, 'fireSpecialSection'));
    ipworkszip_officedoc_register_callback($this->handle, 15, array($this, 'fireStartElement'));
    ipworkszip_officedoc_register_callback($this->handle, 16, array($this, 'fireStartPrefixMapping'));
  }
  
  public function __destruct() {
    ipworkszip_officedoc_close($this->handle);
  }

 /**
  * Returns the last error code.
  *
  * @access   public
  */
  public function lastError() {
    return ipworkszip_officedoc_get_last_error($this->handle);
  }
  
 /**
  * Returns the last error message.
  *
  * @access   public
  */
  public function lastErrorCode() {
    return ipworkszip_officedoc_get_last_error_code($this->handle);
  }

 /**
  * Closes the Open XML package archive.
  *
  * @access   public
  */
  public function doClose() {
    $ret = ipworkszip_officedoc_do_close($this->handle);
		$err = $ret;

    if ($err != 0) {
      throw new Exception($ret . ": " . ipworkszip_officedoc_get_last_error($this->handle));
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
    $ret = ipworkszip_officedoc_do_config($this->handle, $configurationstring);
		$err = ipworkszip_officedoc_get_last_error_code($this->handle);
    if ($err != 0) {
      throw new Exception($ret . ": " . ipworkszip_officedoc_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Reads the contents of the currently selected part.
  *
  * @access   public
  */
  public function doExtractPart() {
    $ret = ipworkszip_officedoc_do_extractpart($this->handle);
		$err = $ret;

    if ($err != 0) {
      throw new Exception($ret . ": " . ipworkszip_officedoc_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Looks up a part in the current relationships file by it's type namespace URI.
  *
  * @access   public
  * @param    string    typeuri
  */
  public function doFindPartByType($typeuri) {
    $ret = ipworkszip_officedoc_do_findpartbytype($this->handle, $typeuri);
		$err = ipworkszip_officedoc_get_last_error_code($this->handle);
    if ($err != 0) {
      throw new Exception($ret . ": " . ipworkszip_officedoc_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Returns the value of the specified package property.
  *
  * @access   public
  * @param    string    propname
  * @param    string    propnamespace
  */
  public function doGetPropertyValue($propname, $propnamespace) {
    $ret = ipworkszip_officedoc_do_getpropertyvalue($this->handle, $propname, $propnamespace);
		$err = ipworkszip_officedoc_get_last_error_code($this->handle);
    if ($err != 0) {
      throw new Exception($ret . ": " . ipworkszip_officedoc_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * List all the parts contained in the document and their relationships.
  *
  * @access   public
  */
  public function doListParts() {
    $ret = ipworkszip_officedoc_do_listparts($this->handle);
		$err = $ret;

    if ($err != 0) {
      throw new Exception($ret . ": " . ipworkszip_officedoc_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Opens the Open XML package archive.
  *
  * @access   public
  */
  public function doOpen() {
    $ret = ipworkszip_officedoc_do_open($this->handle);
		$err = $ret;

    if ($err != 0) {
      throw new Exception($ret . ": " . ipworkszip_officedoc_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Parses the specified part as XML.
  *
  * @access   public
  */
  public function doParsePart() {
    $ret = ipworkszip_officedoc_do_parsepart($this->handle);
		$err = $ret;

    if ($err != 0) {
      throw new Exception($ret . ": " . ipworkszip_officedoc_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Reads the relationships file in the archive associated with the specified part.
  *
  * @access   public
  */
  public function doReadRelationships() {
    $ret = ipworkszip_officedoc_do_readrelationships($this->handle);
		$err = $ret;

    if ($err != 0) {
      throw new Exception($ret . ": " . ipworkszip_officedoc_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Replaces the contents of the specified part in the package.
  *
  * @access   public
  */
  public function doReplacePart() {
    $ret = ipworkszip_officedoc_do_replacepart($this->handle);
		$err = $ret;

    if ($err != 0) {
      throw new Exception($ret . ": " . ipworkszip_officedoc_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Resets the class.
  *
  * @access   public
  */
  public function doReset() {
    $ret = ipworkszip_officedoc_do_reset($this->handle);
		$err = $ret;

    if ($err != 0) {
      throw new Exception($ret . ": " . ipworkszip_officedoc_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Returns the content type of the specified part.
  *
  * @access   public
  */
  public function doResolveContentType() {
    $ret = ipworkszip_officedoc_do_resolvecontenttype($this->handle);
		$err = ipworkszip_officedoc_get_last_error_code($this->handle);
    if ($err != 0) {
      throw new Exception($ret . ": " . ipworkszip_officedoc_get_last_error($this->handle));
    }
    return $ret;
  }

   

public function VERSION() {
    return ipworkszip_officedoc_get($this->handle, 0);
  }
 /**
  * The number of records in the ContentType arrays.
  *
  * @access   public
  */
  public function getContentTypeCount() {
    return ipworkszip_officedoc_get($this->handle, 1 );
  }


 /**
  * Specifies if this is a default content type or an override.
  *
  * @access   public
  */
  public function getContentTypeIsOverride($contenttypeindex) {
    return ipworkszip_officedoc_get($this->handle, 2 , $contenttypeindex);
  }


 /**
  * The media type for this entry, as defined by RFC2616.
  *
  * @access   public
  */
  public function getContentTypeMediaType($contenttypeindex) {
    return ipworkszip_officedoc_get($this->handle, 3 , $contenttypeindex);
  }


 /**
  * If it's a default content type, this will be the file extension it applies to.
  *
  * @access   public
  */
  public function getContentTypeTarget($contenttypeindex) {
    return ipworkszip_officedoc_get($this->handle, 4 , $contenttypeindex);
  }


 /**
  * The number of records in the Namespace arrays.
  *
  * @access   public
  */
  public function getNamespaceCount() {
    return ipworkszip_officedoc_get($this->handle, 5 );
  }


 /**
  * The Prefix for the Namespace .
  *
  * @access   public
  */
  public function getNamespacePrefix($namespaceindex) {
    return ipworkszip_officedoc_get($this->handle, 6 , $namespaceindex);
  }


 /**
  * Namespace URI associated with the corresponding Prefix .
  *
  * @access   public
  */
  public function getNamespaceURI($namespaceindex) {
    return ipworkszip_officedoc_get($this->handle, 7 , $namespaceindex);
  }


 /**
  * The path to the Open XML package file.
  *
  * @access   public
  */
  public function getPackagePath() {
    return ipworkszip_officedoc_get($this->handle, 8 );
  }
 /**
  * The path to the Open XML package file.
  *
  * @access   public
  * @param    string   value
  */
  public function setPackagePath($value) {
    $ret = ipworkszip_officedoc_set($this->handle, 8, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . ipworkszip_officedoc_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * The number of records in the PackageProperty arrays.
  *
  * @access   public
  */
  public function getPackagePropertyCount() {
    return ipworkszip_officedoc_get($this->handle, 9 );
  }


 /**
  * The data type associated with this property, if the information is available.
  *
  * @access   public
  */
  public function getPackagePropertyDataType($packagepropertyindex) {
    return ipworkszip_officedoc_get($this->handle, 10 , $packagepropertyindex);
  }


 /**
  * The name of this property.
  *
  * @access   public
  */
  public function getPackagePropertyName($packagepropertyindex) {
    return ipworkszip_officedoc_get($this->handle, 11 , $packagepropertyindex);
  }


 /**
  * The XML Namespace URI associated with this property.
  *
  * @access   public
  */
  public function getPackagePropertyNamespace($packagepropertyindex) {
    return ipworkszip_officedoc_get($this->handle, 12 , $packagepropertyindex);
  }


 /**
  * If this is a custom property, this will be the pid assigned to it.
  *
  * @access   public
  */
  public function getPackagePropertyPropId($packagepropertyindex) {
    return ipworkszip_officedoc_get($this->handle, 13 , $packagepropertyindex);
  }


 /**
  * If this is a custom property, this will be the GUID of the property set it belongs to.
  *
  * @access   public
  */
  public function getPackagePropertyPropSet($packagepropertyindex) {
    return ipworkszip_officedoc_get($this->handle, 14 , $packagepropertyindex);
  }


 /**
  * The value of this property.
  *
  * @access   public
  */
  public function getPackagePropertyValue($packagepropertyindex) {
    return ipworkszip_officedoc_get($this->handle, 15 , $packagepropertyindex);
  }


 /**
  * The contents of the currently selected part.
  *
  * @access   public
  */
  public function getPartData() {
    return ipworkszip_officedoc_get($this->handle, 16 );
  }
 /**
  * The contents of the currently selected part.
  *
  * @access   public
  * @param    string   value
  */
  public function setPartData($value) {
    $ret = ipworkszip_officedoc_set($this->handle, 16, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . ipworkszip_officedoc_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * The name of the currently selected part.
  *
  * @access   public
  */
  public function getPartName() {
    return ipworkszip_officedoc_get($this->handle, 17 );
  }
 /**
  * The name of the currently selected part.
  *
  * @access   public
  * @param    string   value
  */
  public function setPartName($value) {
    $ret = ipworkszip_officedoc_set($this->handle, 17, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . ipworkszip_officedoc_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * The number of records in the Relationship arrays.
  *
  * @access   public
  */
  public function getRelationshipCount() {
    return ipworkszip_officedoc_get($this->handle, 18 );
  }


 /**
  * The content type for the part referenced by this relationship, resolved from [Content_Types].
  *
  * @access   public
  */
  public function getRelationshipContentType($relationshipindex) {
    return ipworkszip_officedoc_get($this->handle, 19 , $relationshipindex);
  }


 /**
  * The unique ID of this relationship within this .
  *
  * @access   public
  */
  public function getRelationshipId($relationshipindex) {
    return ipworkszip_officedoc_get($this->handle, 20 , $relationshipindex);
  }


 /**
  * The name of the part this relationship entry applies to.
  *
  * @access   public
  */
  public function getRelationshipPartName($relationshipindex) {
    return ipworkszip_officedoc_get($this->handle, 21 , $relationshipindex);
  }


 /**
  * The XML namespace URI that specifies the meaning of this relationship.
  *
  * @access   public
  */
  public function getRelationshipTypeURI($relationshipindex) {
    return ipworkszip_officedoc_get($this->handle, 22 , $relationshipindex);
  }


 /**
  * When True, the parser checks that the document consists of well-formed XML.
  *
  * @access   public
  */
  public function getValidate() {
    return ipworkszip_officedoc_get($this->handle, 23 );
  }
 /**
  * When True, the parser checks that the document consists of well-formed XML.
  *
  * @access   public
  * @param    boolean   value
  */
  public function setValidate($value) {
    $ret = ipworkszip_officedoc_set($this->handle, 23, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . ipworkszip_officedoc_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * The number of records in the Attr arrays.
  *
  * @access   public
  */
  public function getAttrCount() {
    return ipworkszip_officedoc_get($this->handle, 24 );
  }


 /**
  * The Name provides the local name (without prefix)  of the attribute.
  *
  * @access   public
  */
  public function getAttrName($attrindex) {
    return ipworkszip_officedoc_get($this->handle, 25 , $attrindex);
  }


 /**
  * Attribute namespace.
  *
  * @access   public
  */
  public function getAttrNamespace($attrindex) {
    return ipworkszip_officedoc_get($this->handle, 26 , $attrindex);
  }


 /**
  * Attribute prefix (if any).
  *
  * @access   public
  */
  public function getAttrPrefix($attrindex) {
    return ipworkszip_officedoc_get($this->handle, 27 , $attrindex);
  }


 /**
  * Attribute value.
  *
  * @access   public
  */
  public function getAttrValue($attrindex) {
    return ipworkszip_officedoc_get($this->handle, 28 , $attrindex);
  }


 /**
  * The number of records in the XChild arrays.
  *
  * @access   public
  */
  public function getXChildCount() {
    return ipworkszip_officedoc_get($this->handle, 29 );
  }


 /**
  * The Name property provides the local name (without prefix) of the element.
  *
  * @access   public
  */
  public function getXChildName($xchildindex) {
    return ipworkszip_officedoc_get($this->handle, 30 , $xchildindex);
  }


 /**
  * Namespace of the element.
  *
  * @access   public
  */
  public function getXChildNamespace($xchildindex) {
    return ipworkszip_officedoc_get($this->handle, 31 , $xchildindex);
  }


 /**
  * Prefix of the element (if any).
  *
  * @access   public
  */
  public function getXChildPrefix($xchildindex) {
    return ipworkszip_officedoc_get($this->handle, 32 , $xchildindex);
  }


 /**
  * The inner text of the element.
  *
  * @access   public
  */
  public function getXChildXText($xchildindex) {
    return ipworkszip_officedoc_get($this->handle, 33 , $xchildindex);
  }


 /**
  * The name of the current element.
  *
  * @access   public
  */
  public function getXElement() {
    return ipworkszip_officedoc_get($this->handle, 34 );
  }


 /**
  * The namespace of the current element.
  *
  * @access   public
  */
  public function getXNamespace() {
    return ipworkszip_officedoc_get($this->handle, 35 );
  }


 /**
  * The parent of the current element.
  *
  * @access   public
  */
  public function getXParent() {
    return ipworkszip_officedoc_get($this->handle, 36 );
  }


 /**
  * Provides a way to point to a specific element in the document.
  *
  * @access   public
  */
  public function getXPath() {
    return ipworkszip_officedoc_get($this->handle, 37 );
  }
 /**
  * Provides a way to point to a specific element in the document.
  *
  * @access   public
  * @param    string   value
  */
  public function setXPath($value) {
    $ret = ipworkszip_officedoc_set($this->handle, 37, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . ipworkszip_officedoc_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * The prefix of the current element.
  *
  * @access   public
  */
  public function getXPrefix() {
    return ipworkszip_officedoc_get($this->handle, 38 );
  }


 /**
  * A snapshot of the current element in the document.
  *
  * @access   public
  */
  public function getXSubTree() {
    return ipworkszip_officedoc_get($this->handle, 39 );
  }


 /**
  * The text of the current element.
  *
  * @access   public
  */
  public function getXText() {
    return ipworkszip_officedoc_get($this->handle, 40 );
  }




  public function getRuntimeLicense() {
    return ipworkszip_officedoc_get($this->handle, 2011 );
  }

  public function setRuntimeLicense($value) {
    $ret = ipworkszip_officedoc_set($this->handle, 2011, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . ipworkszip_officedoc_get_last_error($this->handle));
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
  * Fired for plain text segments of the input stream.
  *
  * @access   public
  * @param    array   Array of event parameters: text    
  */
  public function fireCharacters($param) {
    return $param;
  }

 /**
  * Fired when a comment section is encountered.
  *
  * @access   public
  * @param    array   Array of event parameters: text    
  */
  public function fireComment($param) {
    return $param;
  }

 /**
  * Fired when an end-element tag is encountered.
  *
  * @access   public
  * @param    array   Array of event parameters: namespace, element, qname, isempty    
  */
  public function fireEndElement($param) {
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
  * Fired when leaving the scope of a namespace declaration.
  *
  * @access   public
  * @param    array   Array of event parameters: prefix    
  */
  public function fireEndPrefixMapping($param) {
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

 /**
  * Fired every time an entity needs to be evaluated.
  *
  * @access   public
  * @param    array   Array of event parameters: entity, value    
  */
  public function fireEvalEntity($param) {
    return $param;
  }

 /**
  * Fired when a section of ignorable whitespace is encountered.
  *
  * @access   public
  * @param    array   Array of event parameters: text    
  */
  public function fireIgnorableWhitespace($param) {
    return $param;
  }

 /**
  * Fired when a meta section is encountered.
  *
  * @access   public
  * @param    array   Array of event parameters: text    
  */
  public function fireMeta($param) {
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
  * Fired when a processing instruction section is encountered.
  *
  * @access   public
  * @param    array   Array of event parameters: text    
  */
  public function firePI($param) {
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

 /**
  * Fired when a special section is encountered.
  *
  * @access   public
  * @param    array   Array of event parameters: sectionid, text    
  */
  public function fireSpecialSection($param) {
    return $param;
  }

 /**
  * Fired when a begin-element tag is encountered in the document.
  *
  * @access   public
  * @param    array   Array of event parameters: namespace, element, qname, isempty    
  */
  public function fireStartElement($param) {
    return $param;
  }

 /**
  * Fired when entering the scope of a namespace declaration.
  *
  * @access   public
  * @param    array   Array of event parameters: prefix, uri    
  */
  public function fireStartPrefixMapping($param) {
    return $param;
  }


}

?>
