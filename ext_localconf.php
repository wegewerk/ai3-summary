<?php

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

defined('TYPO3') or die();

$GLOBALS['TYPO3_CONF_VARS']['SYS']['formEngine']['nodeRegistry'][1759225980] = [
    'nodeName' => 'ai3SummaryElement',
    'priority' => 40,
    'class' => \Wegewerk\Ai3Summary\FormEngine\Ai3SummaryElement::class
];

ExtensionManagementUtility::addTypoScriptSetup('
lib.contentElement {
    templateRootPaths.1784806551592 = EXT:ai3_summary/Resources/Private/Templates/ContentElements/
}

tt_content.ai3_summary =< lib.contentElement
tt_content.ai3_summary {
    templateName = Ai3Summary
}

');
