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
        'name' => 'outerTpl',
        'desc' => 'Name of an optional chunk serving as wrapper template for the snippet output; not used if empty. The placeholder for the output is set as crumbs, i.e. [[+crumbs]].',
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
        'name' => 'tvs',
        'desc' => 'The template variables to get from the resource as placeholders; Example: mytv; NOTE to use inside template use tv. as prefix, so for mytv the placeholder becomes tv.mytv',
        'type' => 'textfield',
        'options' => '',
        'value' => '',
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
        'options' => '',
        'value' => '&nbsp;&raquo;&nbsp;'
    ),
    array(
        'name' => 'toPlaceholder',
        'desc' => 'If set, a placeholder by the specified name with be set containing the output and no output will be returned by this snippet.',
        'type' => 'textfield',
        'options' => '',
        'value' => ''
    ),
    array(
        'name' => 'parentTitlesPlaceholder',
        'desc' => 'If set, pagetitles of all the parent breadcrumbs are compiled and set as a placeholder for use in the content of your Resource.',
        'type' => 'textfield',
        'options' => '',
        'value' => ''
    ),
    array(
        'name' => 'parentTitlesReversed',
        'desc' => 'If set, the parentTitlesPlaceholder output is returned with pagetitles in reverse-order.',
        'type' => 'combo-boolean',
        'options' => '',
        'value' => false
    ),
    array(
        'name' => 'titleSeparator',
        'desc' => 'A separator to use in between pagetitles used in the parentTitlesPlaceholder.',
        'type' => 'textfield',
        'options' => '',
        'value' => ' - ',
    ),
    array(
        'name' => 'debug',
        'desc' => 'If true, will send the SQL query to the MODx log. Defaults to false.',
        'type' => 'combo-boolean',
        'options' => '',
        'value' => false,
    ),
    array(
        'name' => 'hideEmptyContainers',
        'desc' => 'If true, will skip Resources that are empty containers (or are WebLink/SymLink) in the breadcrumbs.',
        'type' => 'combo-boolean',
        'options' => '',
        'value' => false
    ),
    array(
        'name' => 'hideIds',
        'desc' => 'A list of resource IDs you want to hide from the breadcrumbs.',
        'type' => 'textfield',
        'options' => '',
        'value' => '',
    ),
    array(
        'name' => 'excludeHidden',
        'desc' => 'If true, Resources that are hidden from menus will be skipped in the breadcrumbs.',
        'type' => 'combo-boolean',
        'options' => '',
        'value' => false,
    ),
    array(
        'name' => 'maxCrumbs',
        'desc' => 'The maximum number of crumbs to display between the top crumb and self. Additional crumbs are skipped (see skipTpl and skipFromTop properties). 0 (or an empty string) indicates no maximum limit: the default.',
        'type' => 'textfield',
        'options' => '',
        'value' => '0',
    ),
    array(
        'name' => 'skipTpl',
        'desc' => 'The name of a chunk to use for each crumb skipped when maxCrumbs is exceeded.',
        'type' => 'textfield',
        'options' => '',
        'value' => '0',
    ),
    array(
        'name' => 'skipFromTop',
        'desc' => 'If true (the default), crumbs will be be skipped from the top crumb when maxCrumbs is exceeded. Otherwise they will be skipped from self.',
        'type' => 'combo-boolean',
        'options' => '',
        'value' => true,
    ),
);

return $properties;
