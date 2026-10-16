import AjaxRequest from "@typo3/core/ajax/ajax-request.js";
import Ai3ApiBase from "@wegewerk/ai3core/ai3api.js";

class Ai3Api extends Ai3ApiBase {
    getArticlesummary(pageId, options) {
        return new AjaxRequest(TYPO3.settings.ajaxUrls['ai3_articlesummary'])
            .post({
                page_id: pageId,
                ...options
            });
    }

}

export {Ai3Api as default};
