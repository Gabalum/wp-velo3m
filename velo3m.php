<?php
/**
 * @package Velo3m
 */
/*
Plugin Name: Velo3m
Description: Exploitation des données vélos en OpenData sur la Métropole de Montpellier (Montpellier 3m)
Version: 0.0.1
Author: Aurélien Bonnal
Author URI:https://github.com/Gabalum
License: GPLv2 or later
Text Domain: arceaux3m
*/
if ( !function_exists( 'add_action' ) ) {
	echo 'Inutile de se connecter en direct :)';
	exit;
}
require_once(dirname(__FILE__).'/vendor/autoload.php');
Velo3m\Arceaux3m::init();
