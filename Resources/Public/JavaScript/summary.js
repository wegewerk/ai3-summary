import {lll} from "@typo3/core/lit-helper.js";
import {html, render} from 'lit-html';
import Ai3Api from './ai3api.js';
import Notification from "@typo3/backend/notification.js";

class SummaryApp {
    constructor(container) {
        this.container = container;
        this.pageId = container.dataset.pageId;
        this.recordUid = container.dataset.recordUid;
        this.api = new Ai3Api();
        this.loading = false;
        this.language = this.getSelectedLanguage();
    }

    init() {
        this.render();
    }

    async generateSummary() {
        this.loading = true;
        this.render();

        try {
            const response = await this.api.getArticlesummary(this.pageId, this.language);
            const result = await response.resolve();
            const data = JSON.parse(result);

            if (data.success && data.summary) {
                this.updateBodytext(data.summary);
                this.updateAi3Fields(data.type,data.source);
            } else {
                Notification.error( lll('tx_ai3.pageImprovement.summary.error'), data.error || 'Unknown error');
            }
        } catch (error) {
            let message= await error.response.json();
            Notification.error(lll('tx_ai3.pageImprovement.summary.error'), message.error);
        } finally {
            this.loading = false;
            this.render();
        }
    }

    /**
     * Update the bodytext field and ensure CKEditor 5 (or fallback CKEditor 4) reflects the new content.
     * The implementation mirrors the logic used in the summary helper for CKEditor 5 integration,
     * iterating over all editor instances and matching the source element name.
     *
     * @param {string} summary The generated summary text.
     */
    updateBodytext(summary) {
        // Find the bodytext field in the TYPO3 FormEngine. The field name follows the pattern
        // data[tt_content][uid][bodytext]
        const selector = `[name="data[tt_content][${this.recordUid}][bodytext]"]`;
        const field = document.querySelector(selector);

        if (!field) {
            console.warn('Bodytext field not found:', selector);
            return;
        }

        // Update the hidden textarea/input value and trigger change for TYPO3 FormEngine.
        field.value = summary;
        field.dispatchEvent(new Event('change', { bubbles: true }));

        // CKEditor 4 fallback (unlikely in v13)
        if (typeof CKEDITOR !== 'undefined' && CKEDITOR.instances && CKEDITOR.instances[field.id]) {
            CKEDITOR.instances[field.id].setData(summary);
            return; // CKEditor 4 handled, no need to proceed further.
        }

        // CKEditor 5 integration – locate the editor instance that corresponds to this field.
        // The helper module iterates over all '.ck-editor__editable' elements and checks the
        // attached instance's sourceElement.name property. We'll replicate that logic.
        const fieldName = field.getAttribute('name');
        document.querySelectorAll('.ck-editor__editable').forEach(editorElement => {
            const instance = editorElement.ckeditorInstance;
            if (instance && instance.sourceElement && instance.sourceElement.name === fieldName) {
                instance.setData(summary);
            }
        });
    }

    render() {
        const languageOptions = this.getLanguageOptions();
        const template = html`
            <div class="form-inline">
                    <button 
                        type="button" 
                        class="btn btn-default" 
                        @click="${() => this.generateSummary()}"
                        ?disabled="${this.loading}"
                    >
                        <typo3-backend-icon identifier="ai3-summary-icon" size="small"></typo3-backend-icon>
                        ${this.loading ? lll('tx_ai3.summary.summary.generating') : lll('tx_ai3.summary.summary.button')}
                    </button>
                    ${this.loading ? html`<typo3-backend-spinner size="small"></typo3-backend-spinner>` : ''}
                    <select class="form-select" @change="${(e) => this.language = e.target.value}">
                        ${languageOptions.map(option => html`
                        <option value="${option.value}" ?selected="${this.language == option.value}">${option.label}</option>
                    `)}
                    </select>
            </div>
        `;
        render(template, this.container.querySelector('[data-ai3="ai3-summary-app"]'));
    }

    getLanguageOptions() {
        return [
            {
                value: 'en',
                label: 'English'
            },
            {
                value: 'de',
                label: 'Deutsch'
            }
        ]
    }

    /**
     * Update the hidden AI3 fields (type and source) for the current record.
     *
     * @param {string} type   The AI3 type value to set.
     * @param {string} source The AI3 source value to set.
     */
    updateAi3Fields(type, source) {
        // Helper to set a field value and dispatch the change event.
        const setField = (fieldName, value) => {
            const selector = `[data-formengine-input-name="data[tt_content][${this.recordUid}][${fieldName}]"]`;
            const field = document.querySelector(selector);
            if (!field) {
                console.warn('AI3 field not found:', selector);
                return false;
            }
            field.value = value;
            // Trigger change event for TYPO3 to recognize the change
            field.dispatchEvent(new Event('change', { bubbles: true }));
            return true;
        };
    }

    getSelectedLanguage() {
        const selector = `[name="data[tt_content][${this.recordUid}][sys_language_uid]"]`;
        const field = document.querySelector(selector);
        if (!field) {
            return 0;
        } else  {
            return field.value;
        }

    }
}

document.querySelectorAll('[data-ai3="ai3-summary-container"]').forEach(container => {
    const app = new SummaryApp(container);
    app.init();
});
