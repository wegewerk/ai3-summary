.. include:: /Includes.rst.txt

.. _introduction:

============
Introduction
============

Ai3 Summary adds a **Page Summary** content element to TYPO3. When placed on
a page, it provides editors with a one-click button to generate a
bullet-point summary of all content on that page via the ZAK-AI REST API.
The generated summary is written directly into the element's RichText field
and rendered on the frontend as HTML.

.. _introduction-features:

Features
========

*   **AI-generated summaries** -- sends all page content to the ZAK-AI
    ``bulletpoints`` endpoint and returns a structured bullet-point list.
*   **CKEditor 5 integration** -- the generated text is inserted directly
    into the bodytext RichText field, including full CKEditor 5 support.
*   **Language-aware** -- the language selector in the backend widget passes
    the current page language to the API for language-appropriate output.
*   **Custom FormEngine element** -- a dedicated backend widget renders the
    "Generate Page Summary" button inside the content element form.
*   **Frontend rendering** -- the stored bodytext is rendered as HTML using
    a Fluid template, compatible with ``fluid_styled_content``.
*   **Part of the Ai3 Suite** -- integrates with :composer:`wegewerk/ai3_core`
    for API client and capability infrastructure.

.. _introduction-how-it-works:

How it works
============

#.  An editor adds the **Page Summary** content element (``CType: ai3_summary``)
    to a page.
#.  The custom FormEngine widget displays a language selector and a
    **"Generate Page Summary"** button.
#.  On click, a backend AJAX request fetches all content records on the
    current page and sends them to the ZAK-AI ``bulletpoints`` API.
#.  The API response is written into the ``bodytext`` field of the content
    element.
#.  On the frontend, the element renders the stored bodytext as HTML inside
    a ``<div class="ce-bodytext rich-text">`` wrapper.
