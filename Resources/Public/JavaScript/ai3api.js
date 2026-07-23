import AjaxRequest from "@typo3/core/ajax/ajax-request.js";

class Ai3Api {
    getArticlesummary(pageId, language) {
        return new AjaxRequest(TYPO3.settings.ajaxUrls['ai3_articlesummary'])
            .post({
                page_id: pageId,
                language: language
            });
    }

}

export {Ai3Api as default};
