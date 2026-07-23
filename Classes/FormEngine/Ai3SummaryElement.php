<?php

declare(strict_types=1);

namespace Wegewerk\Ai3Summary\FormEngine;

use TYPO3\CMS\Backend\Form\Element\AbstractFormElement;
use TYPO3\CMS\Core\Page\JavaScriptModuleInstruction;

class Ai3SummaryElement extends AbstractFormElement
{
    public function render(): array
    {
        $result = $this->initializeResultArray();
        $result['javaScriptModules'][] = JavaScriptModuleInstruction::create('@wegewerk/Ai3Summary/summary.js');

        $html = [
            '<div data-ai3="ai3-summary-container"',
            ' data-page-id="' . (int)$this->data['parentPageRow']['uid'] . '"',
            ' data-record-uid="' . $this->data['databaseRow']['uid'] . '"',
            '>',
            '  <div data-ai3="ai3-summary-app">',
            '  </div>',
            '</div>'
        ];

        $result['html'] = implode('', $html);
        return $result;
    }
}
