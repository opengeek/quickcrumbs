<?php
/**
 * QuickCrumbs
 *
 * Copyright 2010, 2011 by MODx, LLC
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
$parentTitles = array();
$resourceId = (integer) $modx->resource->get('id');
$fields = empty($fields) ? 'pagetitle,menutitle,description' : $fields;
$fields = explode(',', $fields);
foreach ($fields as $fieldKey => $field) $fields[$fieldKey] = trim($field);
array_unshift($fields, 'id', 'class_key', 'context_key');
$tvs = empty($tvs) ? '' : $tvs;
$tvs = explode(',', $tvs);
foreach ($tvs as $tvKey => $tv) $tvs[$tvKey] = trim($tv);
$parents = $modx->getParentIds($resourceId);
array_pop($parents);
$parents = array_reverse($parents);
$siteStartShown = false;
$siteStart = (integer) $modx->getOption('site_start', null, 1);
if (empty($siteStartTpl)) {
    $siteStartTpl = $tpl;
}
if (empty($selfTpl)) {
    $selfTpl = $tpl;
}
if ($siteStart == $resourceId && !empty($showSelf)) {
    $siteStartTpl = $selfTpl;
}
if (!empty($parents)) {
    $query = $modx->newQuery('modResource', array('id:IN' => $parents, 'published' => 1, 'deleted' => 0));
    if (!empty($hideEmptyContainers)) {
        $query->where(array(
            'content:!=' => '',
            'class_key:NOT IN' => array('modWebLink', 'modSymLink')
        ));
    }
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
            foreach ($tvs as $tvKey => $tv) {
                $properties = array_merge($properties, array('tv.'.$tv => $object->getTVValue($tv)));
            }
            if ((integer) $parent == $siteStart) {
                if (!empty($showSiteStart)) {
                    if (!empty($siteStartTpl)) {
                        $output[] = $modx->getChunk($siteStartTpl, $properties);
                    } else {
                        $output[] = "<pre>" . print_r($properties, true) . "</pre>";
                    }
                    $siteStartShown = true;
                }
            }
            else {
                $parentTitles[] = $properties['pagetitle'];
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
if (!empty($showSelf) && !($resourceId == $siteStart && !empty($showSiteStart))) {
    $properties = array_merge($scriptProperties, $modx->resource->get($fields));
    foreach ($tvs as $tvKey => $tv) {
        $properties = array_merge($properties, array('tv.'.$tv => $modx->resource->getTVValue($tv)));
    }
    if (!empty($selfTpl)) {
        $output[] = $modx->getChunk($selfTpl, $properties);
    } else {
        $output[] = "<pre>" . print_r($properties, true) . "</pre>";
    }
}
if (!empty($showSiteStart) && !$siteStartShown) {
    $query = $modx->newQuery('modResource', $siteStart);
    $query->select($modx->getSelectColumns('modResource', '', '', $fields));
    $siteStartResource = $modx->getObject('modResource', $query);
    $properties = array_merge($scriptProperties, $siteStartResource->get($fields));
    foreach ($tvs as $tvKey => $tv) {
        $properties = array_merge($properties, array('tv.'.$tv => $siteStartResource->getTVValue($tv)));
    }
    if (!empty($siteStartTpl)) {
        $siteStartOutput = $modx->getChunk($siteStartTpl, $properties);
    } else {
        $siteStartOutput = "<pre>" . print_r($properties, true) . "</pre>";
    }
    array_unshift($output, $siteStartOutput);
}
$separator = isset($separator) ? "{$separator}" : "&nbsp;&raquo;&nbsp;";
$output = implode($separator, $output);
if (!empty($outerTpl)) {
    $output = $modx->getChunk($outerTpl, array('crumbs' => $output));
}
if (!empty($parentTitlesPlaceholder) && !empty($parentTitles)) {
    if (empty($titleSeparator)) {
        $titleSeparator = ' - ';
    }
    if (!empty($parentTitlesReversed)) {
        $parentTitles = array_reverse($parentTitles);
    }
    $parentTitles = implode($titleSeparator, $parentTitles);
    $modx->setPlaceholder($parentTitlesPlaceholder, $titleSeparator . $parentTitles);
}
if (!empty($toPlaceholder)) {
    $modx->setPlaceholder($toPlaceholder, $output);
    return '';
}
else {
    return $output;
}