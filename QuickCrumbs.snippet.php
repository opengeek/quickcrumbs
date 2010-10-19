<?php
$output = array();
$parentTitles = array();
$resourceId = (integer) $modx->resource->get('id');
$fields = empty($fields) ? 'pagetitle,menutitle,description' : $fields;
$fields = explode(',', $fields);
foreach ($fields as $fieldKey => $field) $fields[$fieldKey] = trim($field);
array_unshift($fields, 'id');
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
if (empty($urlScheme)) {
    $urlScheme = '-1';
}
if ($siteStart == $resourceId && !empty($showSelf)) {
    $siteStartTpl = $selfTpl;
}
if (!empty($parents)) {
    $query = $modx->newQuery('modResource',
        array('id:IN' => $parents, 'published' => 1, 'deleted' => 0));
    $query->select($modx->getSelectColumns('modResource', '', '', $fields));
    $collection = $modx->getCollection('modResource', $query);
    $parent = reset($parents);
    while ($parent) {
        $object = reset($collection);
        while ($object && (integer) $object->get('id') != (integer) $parent) {
            $object = next($collection);
        }
        if ($object) {
            $properties = array_merge($scriptProperties, $object->get($fields));
            $properties['href'] = $modx->makeUrl($properties['id'], '', '', $urlScheme);
            if ((integer) $parent == $siteStart) {
                if (!empty($showSiteStart)) {
                    $output[] = $modx->getChunk($siteStartTpl, $properties);
                    $siteStartShown = true;
                }
            }
            else {
                $parentTitles[] = $properties['pagetitle'];
                $output[] = $modx->getChunk($tpl, $properties);
            }
        }
        $parent = next($parents);
    }
}
if (!empty($showSelf) && !($resourceId == $siteStart && !empty($showSiteStart))) {
    $properties = array_merge($scriptProperties, $modx->resource->get($fields));
    $properties['href'] = $modx->makeUrl($properties['id'], '', '', $urlScheme);
    $output[] = $modx->getChunk($selfTpl, $properties);
}
if (!empty($showSiteStart) && !$siteStartShown) {
    $query = $modx->newQuery('modResource', $siteStart);
    $query->select($modx->getSelectColumns('modResource', '', '', $fields));
    $siteStartResource = $modx->getObject('modResource', $query);
    $properties = array_merge($scriptProperties, $siteStartResource->get($fields));
    $properties['href'] = $modx->makeUrl($properties['id'], '', '', $urlScheme);
    $siteStartOutput = $modx->getChunk($siteStartTpl, $properties);
    array_unshift($output, $siteStartOutput);
}
$separator = !empty($separator) ? "\n{$separator}\n" : "&nbsp;&raquo;&nbsp;";
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

// vim:set fo=anqrowcb tw=80 ts=4 sw=4 sts=4 sta et noai nocin fenc=utf-8 ff=unix:
