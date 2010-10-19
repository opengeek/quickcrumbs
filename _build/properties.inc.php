<?php
/**
 * Default properties for QuickCrumbs snippet
 *
 * @package quickcrumbs
 * @subpackage build
 */
$properties = array(
    array(
        'name' => 'tpl',
        'desc' => 'Name of a chunk serving as a resource template. NOTE: if not provided, properties are dumped to output for each resource.',
        'type' => 'textfield',
        'options' => '',
        'value' => '',
    ),
    array(
        'name' => 'siteStartTpl',
        'desc' => 'Name of a chunk serving as resource template for the site_start.',
        'type' => 'textfield',
        'options' => '',
        'value' => '',
    ),
    array(
        'name' => 'selfTpl',
        'desc' => 'Name of a chunk serving as resource template for the current resource.',
        'type' => 'textfield',
        'options' => '',
        'value' => '',
    ),
    array(
        'name' => 'fields',
        'desc' => 'The fields to get from the resource as placeholders; NOTE that id, class_key, and context_key are always selected. (DEFAULT: pagetitle,menutitle,description)',
        'type' => 'textfield',
        'options' => '',
        'value' => 'pagetitle,menutitle,description',
    ),
    array(
        'name' => 'showSiteStart',
        'desc' => 'If true, will render the site_start resource as a crumb. (DEFAULT: true)',
        'type' => 'combo-boolean',
        'options' => '',
        'value' => true,
    ),
    array(
        'name' => 'showSelf',
        'desc' => 'If true, will show the current resource as the final crumb. (DEFAULT: true)',
        'type' => 'combo-boolean',
        'options' => '',
        'value' => true,
    ),
		array(
				'name' => 'separator',
				'desc' => 'Separator to use (default is &raquo;)',
				'type' => 'textfield',
				'options' => '&raquo;'),
    array(
        'name' => 'debug',
        'desc' => 'If true, will send the SQL query to the MODx log. Defaults to false.',
        'type' => 'combo-boolean',
        'options' => '',
        'value' => false,
    ),
);

return $properties;