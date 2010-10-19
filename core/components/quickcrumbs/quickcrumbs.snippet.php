<?php
/**
 * QuickCrumbs
 *
 * Copyright 2010 by MODx, LLC
 *
 * QuickCrumbs is free software; you can redistribute it and/or modify it under the
 * terms of the GNU General Public License as published by the Free Software
 * Foundation; either version 2 of the License, or (at your option) any later
 * version.
 *
 * QuickCrumbs is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * QuickCrumbs; if not, write to the Free Software Foundation, Inc., 59 Temple
 * Place, Suite 330, Boston, MA 02111-1307 USA
 *
 * @package quickcrumbs
 */
/**
 * A quick and efficient bread crumbs Snippet for MODx Revolution.
 * 
 * @package quickcrumbs
 */
$output = array();
$resourceId = $modx->resource->get('id');
$fields = empty($fields) ? 'pagetitle,menutitle,description' : $fields;
$fields = explode(',', $fields);
foreach ($fields as $fieldKey => $field) $fields[$fieldKey] = trim($field);
array_unshift($fields, 'id', 'class_key', 'context_key');
$parents = $modx->getParentIds($resourceId);
array_pop($parents);
$parents = array_reverse($parents);
$siteStartShown = false;
if (!empty($parents)) {
    $query = $modx->newQuery('modResource', array('id:IN' => $parents));
    $query->select($modx->getSelectColumns('modResource', '', '', $fields));
    $collection = $modx->getCollection('modResource', $query);
    $parent = reset($parents);
    while ($parent) {
        $object = reset($collection);
        while ($object && (integer) $object->get('id') !== (integer) $parent) {
            $object = next($collection);
        }
        if ($object) {
            $properties = array_merge($scriptProperties, $object->get($fields));
            if (!empty($showSiteStart) && (integer) $parent === (integer) $modx->getOption('site_start', null, 1)) {
                $siteStartTpl = !empty($siteStartTpl) ? $siteStartTpl : $tpl;
                if (!empty($siteStartTpl)) {
                    $output[] = $modx->getChunk($siteStartTpl, $properties);
                } else {
                    $output[] = "<pre>" . print_r($properties, true) . "</pre>";
                }
                $siteStartShown = true;
            }
            else {
                if (!empty($tpl)) {
                    $output[] = $modx->getChunk($tpl, $properties);
                } else {
                    $output[] = "<pre>" . print_r($properties, true) . "</pre>";
                }
            }
        }
        $parent = next($parents);
    }
}
if (!empty($showSelf)) {
    $selfTpl = !empty($selfTpl) ? $selfTpl : $tpl;
    if (!empty($selfTpl)) {
        $output[] = $modx->getChunk($selfTpl, array_merge($scriptProperties, $modx->resource->get($fields)));
    } else {
        $output[] = "<pre>" . print_r($properties, true) . "</pre>";
    }
}
if (!empty($showSiteStart) && !$siteStartShown) {
    $siteStart = (integer) $modx->getOption('site_start', null, 1);
    $query = $modx->newQuery('modResource', $siteStart);
    $query->select($modx->getSelectColumns('modResource', '', '', $fields));
    $siteStartResource = $modx->getObject('modResource', $query);
    $siteStartTpl = !empty($siteStartTpl) ? $siteStartTpl : $tpl;
    if (!empty($siteStartTpl)) {
        $siteStartOutput = $modx->getChunk($siteStartTpl, array_merge($scriptProperties, $siteStartResource->get($fields)));
    } else {
        $siteStartOutput = "<pre>" . print_r($properties, true) . "</pre>";
    }
    array_unshift($output, $siteStartOutput);
}
$separator = !empty($separator) ? "\n{$separator}\n" : "&nbsp;&raquo;&nbsp;";
return implode($separator, $output);