<?php
/**
 * Theme storage manipulations
 *
 * @package WordPress
 * @subpackage HOGWORDS
 * @since HOGWORDS 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Get theme variable
if (!function_exists('hogwords_storage_get')) {
	function hogwords_storage_get($var_name, $default='') {
		global $HOGWORDS_STORAGE;
		return isset($HOGWORDS_STORAGE[$var_name]) ? $HOGWORDS_STORAGE[$var_name] : $default;
	}
}

// Set theme variable
if (!function_exists('hogwords_storage_set')) {
	function hogwords_storage_set($var_name, $value) {
		global $HOGWORDS_STORAGE;
		$HOGWORDS_STORAGE[$var_name] = $value;
	}
}

// Check if theme variable is empty
if (!function_exists('hogwords_storage_empty')) {
	function hogwords_storage_empty($var_name, $key='', $key2='') {
		global $HOGWORDS_STORAGE;
		if (!empty($key) && !empty($key2))
			return empty($HOGWORDS_STORAGE[$var_name][$key][$key2]);
		else if (!empty($key))
			return empty($HOGWORDS_STORAGE[$var_name][$key]);
		else
			return empty($HOGWORDS_STORAGE[$var_name]);
	}
}

// Check if theme variable is set
if (!function_exists('hogwords_storage_isset')) {
	function hogwords_storage_isset($var_name, $key='', $key2='') {
		global $HOGWORDS_STORAGE;
		if (!empty($key) && !empty($key2))
			return isset($HOGWORDS_STORAGE[$var_name][$key][$key2]);
		else if (!empty($key))
			return isset($HOGWORDS_STORAGE[$var_name][$key]);
		else
			return isset($HOGWORDS_STORAGE[$var_name]);
	}
}

// Inc/Dec theme variable with specified value
if (!function_exists('hogwords_storage_inc')) {
	function hogwords_storage_inc($var_name, $value=1) {
		global $HOGWORDS_STORAGE;
		if (empty($HOGWORDS_STORAGE[$var_name])) $HOGWORDS_STORAGE[$var_name] = 0;
		$HOGWORDS_STORAGE[$var_name] += $value;
	}
}

// Concatenate theme variable with specified value
if (!function_exists('hogwords_storage_concat')) {
	function hogwords_storage_concat($var_name, $value) {
		global $HOGWORDS_STORAGE;
		if (empty($HOGWORDS_STORAGE[$var_name])) $HOGWORDS_STORAGE[$var_name] = '';
		$HOGWORDS_STORAGE[$var_name] .= $value;
	}
}

// Get array (one or two dim) element
if (!function_exists('hogwords_storage_get_array')) {
	function hogwords_storage_get_array($var_name, $key, $key2='', $default='') {
		global $HOGWORDS_STORAGE;
		if (empty($key2))
			return !empty($var_name) && !empty($key) && isset($HOGWORDS_STORAGE[$var_name][$key]) ? $HOGWORDS_STORAGE[$var_name][$key] : $default;
		else
			return !empty($var_name) && !empty($key) && isset($HOGWORDS_STORAGE[$var_name][$key][$key2]) ? $HOGWORDS_STORAGE[$var_name][$key][$key2] : $default;
	}
}

// Set array element
if (!function_exists('hogwords_storage_set_array')) {
	function hogwords_storage_set_array($var_name, $key, $value) {
		global $HOGWORDS_STORAGE;
		if (!isset($HOGWORDS_STORAGE[$var_name])) $HOGWORDS_STORAGE[$var_name] = array();
		if ($key==='')
			$HOGWORDS_STORAGE[$var_name][] = $value;
		else
			$HOGWORDS_STORAGE[$var_name][$key] = $value;
	}
}

// Set two-dim array element
if (!function_exists('hogwords_storage_set_array2')) {
	function hogwords_storage_set_array2($var_name, $key, $key2, $value) {
		global $HOGWORDS_STORAGE;
		if (!isset($HOGWORDS_STORAGE[$var_name])) $HOGWORDS_STORAGE[$var_name] = array();
		if (!isset($HOGWORDS_STORAGE[$var_name][$key])) $HOGWORDS_STORAGE[$var_name][$key] = array();
		if ($key2==='')
			$HOGWORDS_STORAGE[$var_name][$key][] = $value;
		else
			$HOGWORDS_STORAGE[$var_name][$key][$key2] = $value;
	}
}

// Merge array elements
if (!function_exists('hogwords_storage_merge_array')) {
	function hogwords_storage_merge_array($var_name, $key, $value) {
		global $HOGWORDS_STORAGE;
		if (!isset($HOGWORDS_STORAGE[$var_name])) $HOGWORDS_STORAGE[$var_name] = array();
		if ($key==='')
			$HOGWORDS_STORAGE[$var_name] = array_merge($HOGWORDS_STORAGE[$var_name], $value);
		else
			$HOGWORDS_STORAGE[$var_name][$key] = array_merge($HOGWORDS_STORAGE[$var_name][$key], $value);
	}
}

// Add array element after the key
if (!function_exists('hogwords_storage_set_array_after')) {
	function hogwords_storage_set_array_after($var_name, $after, $key, $value='') {
		global $HOGWORDS_STORAGE;
		if (!isset($HOGWORDS_STORAGE[$var_name])) $HOGWORDS_STORAGE[$var_name] = array();
		if (is_array($key))
			hogwords_array_insert_after($HOGWORDS_STORAGE[$var_name], $after, $key);
		else
			hogwords_array_insert_after($HOGWORDS_STORAGE[$var_name], $after, array($key=>$value));
	}
}

// Add array element before the key
if (!function_exists('hogwords_storage_set_array_before')) {
	function hogwords_storage_set_array_before($var_name, $before, $key, $value='') {
		global $HOGWORDS_STORAGE;
		if (!isset($HOGWORDS_STORAGE[$var_name])) $HOGWORDS_STORAGE[$var_name] = array();
		if (is_array($key))
			hogwords_array_insert_before($HOGWORDS_STORAGE[$var_name], $before, $key);
		else
			hogwords_array_insert_before($HOGWORDS_STORAGE[$var_name], $before, array($key=>$value));
	}
}

// Push element into array
if (!function_exists('hogwords_storage_push_array')) {
	function hogwords_storage_push_array($var_name, $key, $value) {
		global $HOGWORDS_STORAGE;
		if (!isset($HOGWORDS_STORAGE[$var_name])) $HOGWORDS_STORAGE[$var_name] = array();
		if ($key==='')
			array_push($HOGWORDS_STORAGE[$var_name], $value);
		else {
			if (!isset($HOGWORDS_STORAGE[$var_name][$key])) $HOGWORDS_STORAGE[$var_name][$key] = array();
			array_push($HOGWORDS_STORAGE[$var_name][$key], $value);
		}
	}
}

// Pop element from array
if (!function_exists('hogwords_storage_pop_array')) {
	function hogwords_storage_pop_array($var_name, $key='', $defa='') {
		global $HOGWORDS_STORAGE;
		$rez = $defa;
		if ($key==='') {
			if (isset($HOGWORDS_STORAGE[$var_name]) && is_array($HOGWORDS_STORAGE[$var_name]) && count($HOGWORDS_STORAGE[$var_name]) > 0) 
				$rez = array_pop($HOGWORDS_STORAGE[$var_name]);
		} else {
			if (isset($HOGWORDS_STORAGE[$var_name][$key]) && is_array($HOGWORDS_STORAGE[$var_name][$key]) && count($HOGWORDS_STORAGE[$var_name][$key]) > 0) 
				$rez = array_pop($HOGWORDS_STORAGE[$var_name][$key]);
		}
		return $rez;
	}
}

// Inc/Dec array element with specified value
if (!function_exists('hogwords_storage_inc_array')) {
	function hogwords_storage_inc_array($var_name, $key, $value=1) {
		global $HOGWORDS_STORAGE;
		if (!isset($HOGWORDS_STORAGE[$var_name])) $HOGWORDS_STORAGE[$var_name] = array();
		if (empty($HOGWORDS_STORAGE[$var_name][$key])) $HOGWORDS_STORAGE[$var_name][$key] = 0;
		$HOGWORDS_STORAGE[$var_name][$key] += $value;
	}
}

// Concatenate array element with specified value
if (!function_exists('hogwords_storage_concat_array')) {
	function hogwords_storage_concat_array($var_name, $key, $value) {
		global $HOGWORDS_STORAGE;
		if (!isset($HOGWORDS_STORAGE[$var_name])) $HOGWORDS_STORAGE[$var_name] = array();
		if (empty($HOGWORDS_STORAGE[$var_name][$key])) $HOGWORDS_STORAGE[$var_name][$key] = '';
		$HOGWORDS_STORAGE[$var_name][$key] .= $value;
	}
}

// Call object's method
if (!function_exists('hogwords_storage_call_obj_method')) {
	function hogwords_storage_call_obj_method($var_name, $method, $param=null) {
		global $HOGWORDS_STORAGE;
		if ($param===null)
			return !empty($var_name) && !empty($method) && isset($HOGWORDS_STORAGE[$var_name]) ? $HOGWORDS_STORAGE[$var_name]->$method(): '';
		else
			return !empty($var_name) && !empty($method) && isset($HOGWORDS_STORAGE[$var_name]) ? $HOGWORDS_STORAGE[$var_name]->$method($param): '';
	}
}

// Get object's property
if (!function_exists('hogwords_storage_get_obj_property')) {
	function hogwords_storage_get_obj_property($var_name, $prop, $default='') {
		global $HOGWORDS_STORAGE;
		return !empty($var_name) && !empty($prop) && isset($HOGWORDS_STORAGE[$var_name]->$prop) ? $HOGWORDS_STORAGE[$var_name]->$prop : $default;
	}
}
?>