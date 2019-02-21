<?php
/**
 * Fusion Framework
 *
 * Flexible Framework for ThemeFusion Wordpress Themes
 *
 * This file includes and loads all objects and functions necessary for the fusion framework.
 *
 * @author		ThemeFusion
 * @copyright	(c) Copyright by ThemeFusion
 * @link		http://theme-fusion.com
 * @package 	FusionFramework
 * @since		Version 1.0
 */

define( 'FUSION_FRAMEWORK_VERSION', '1');

/**
 * Load all needed framework functions that don't belong to a separate class
 */
require( 'fusion-functions.php' );

/**
 * Ajax Functions
 *
 * @since 3.8.0
 */
require_once ( 'ajax-functions.php' );

// Omit closing PHP tag to avoid "Headers already sent" issues.
