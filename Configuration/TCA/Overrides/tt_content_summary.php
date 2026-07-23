<?php

declare(strict_types=1);

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

defined('TYPO3') or die();

$key = 'ai3_summary';

ExtensionManagementUtility::addTcaSelectItem('tt_content',
    'CType',
    [
        'label'       => 'LLL:EXT:ai3_summary/Resources/Private/Language/locallang.xlf:tx_ai3.summary.label_ctype',
        'value'       => $key,
        'icon'        => 'ai3-summary-icon',
        'description' => 'LLL:EXT:ai3_summary/Resources/Private/Language/locallang.xlf:tx_ai3.summary.label_description',
        'group'       => 'AI3',
    ],
    'textmedia',
    'after',);


$GLOBALS['TCA']['tt_content']['columns']['tx_ai3_summary_generator'] = [
    'exclude' => true,
    'label'   => 'LLL:EXT:ai3_summary/Resources/Private/Language/locallang.xlf:tx_ai3.summary.generator',
    'config'  => [
        'type'       => 'user',
        'renderType' => 'ai3SummaryElement',
    ],
];
$GLOBALS['TCA']['tt_content']['types'][$key] = $GLOBALS['TCA']['tt_content']['types']['text'];
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('tt_content',
    'tx_ai3_summary_generator',
    $key,
    'before:bodytext');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('tt_content',
    '--div--;LLL:EXT:ai3_summary/Resources/Private/Language/locallang.xlf:tab.ai3,
        tx_ai3_type,
        tx_ai3_source,tx_ai3_raw
',
    $key);


$GLOBALS['TCA']['tt_content']['types'][$key]['columnsOverrides']['bodytext'] = [
    'config' => [
        'enableRichtext'        => true,
        'richtextConfiguration' => 'default',
    ],
];
