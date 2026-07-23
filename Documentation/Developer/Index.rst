.. include:: /Includes.rst.txt

.. _developer:

=========
Developer
=========

.. _developer-architecture:

Architecture
============

Ai3 Summary follows the *Ai3 Suite* capability pattern provided by
:composer:`wegewerk/ai3_core`:

*   A **Capability** class registers the feature under a unique key.
*   An **Endpoint** class implements the ZAK-AI API call.
*   A **FormEngine element** renders the backend widget.
*   A **backend AJAX controller** handles the generation request.

.. _developer-php-api:

PHP API
=======

.. _developer-articlesummary-capability:

ArticlesummaryCapability
------------------------

.. php:class:: Wegewerk\Ai3Summary\Domain\Capabilities\ArticlesummaryCapability

   Extends ``Wegewerk\Ai3Core\Domain\Capabilities\Capability``. Registered
   via ``Configuration/Services.yaml`` with the following wiring:

   *   ``$key``: ``articlesummary``
   *   ``$title``: ``Article Summary``
   *   ``$endpoint``: ``ZakAiSummary``
   *   Tagged as ``ai3.capability``

.. _developer-zakai-summary:

ZakAiSummary
------------

.. php:class:: Wegewerk\Ai3Summary\Api\ZakAiSummary

   Implements ``Wegewerk\Ai3Core\Api\ZakAiEndpointInterface``. Wraps
   ``ZakAiClient`` to call the ZAK-AI ``bulletpoints`` REST endpoint.

   .. php:method:: generate($imagePath, $description, $language)

      Sends page content to the ZAK-AI API and returns the generated
      bullet-point summary string.

      :param string $imagePath: Unused; reserved for future use.
      :param string $description: The page content text to summarise.
      :param string $language: The target language for the summary.
      :returntype: string

.. _developer-ajax-controller:

ArticlesummaryController
------------------------

.. php:class:: Wegewerk\Ai3Summary\Controller\Ajax\ArticlesummaryController

   Backend AJAX controller (``#[AsController]``), extends
   ``Wegewerk\Ai3Core\Controller\Ajax\AbstractAjaxController``.

   .. php:method:: getArticlesummary(ServerRequestInterface $request)

      Handles the AJAX generation request.

      #.  Reads ``page_id`` and ``language`` from the POST body.
      #.  Fetches all page content via ``PagesRepository::getPageContent()``.
      #.  Calls ``ArticlesummaryCapability`` endpoint to generate the summary.
      #.  Returns a JSON response with ``summary``, ``source``, and
          ``type: 'summary'`` on success, or an error JSON on failure.

      :returntype: ResponseInterface

.. _developer-form-engine:

FormEngine integration
======================

The custom FormEngine node ``ai3SummaryElement`` is registered in
``ext_localconf.php``:

.. code-block:: php
   :caption: ext_localconf.php -- FormEngine node registration

   $GLOBALS['TYPO3_CONF_VARS']['SYS']['formEngine']['nodeRegistry'][1759225980] = [
       'nodeName' => 'ai3SummaryElement',
       'priority' => 40,
       'class' => \Wegewerk\Ai3Summary\FormEngine\Ai3SummaryElement::class,
   ];

The element is added to the ``tt_content`` TCA via
``Configuration/TCA/Overrides/tt_content_summary.php`` as a column of
type ``user`` with ``renderType: ai3SummaryElement``.

.. php:class:: Wegewerk\Ai3Summary\FormEngine\Ai3SummaryElement

   Extends ``TYPO3\CMS\Backend\Form\Element\AbstractFormElement``. Renders
   a ``<div data-ai3="ai3-summary-container">`` with ``data-page-id`` and
   ``data-record-uid`` attributes. The Lit-HTML ``SummaryApp`` mounts into
   the inner ``<div data-ai3="ai3-summary-app">``.

.. _developer-ajax-route:

AJAX route
==========

The backend AJAX route is registered in
``Configuration/Backend/AjaxRoutes.php``:

.. list-table::
   :header-rows: 1
   :widths: 20 20 60

   *   - Route name
       - Path
       - Handler
   *   - ``ai3_articlesummary``
       - ``/ai3/articlesummary``
       - ``ArticlesummaryController::getArticlesummary``

**Request** (POST, JSON body):

.. code-block:: json
   :caption: AJAX request body

   {
       "page_id": 42,
       "language": "en"
   }

**Response** (success):

.. code-block:: json
   :caption: AJAX success response

   {
       "summary": "• Point one\n• Point two",
       "source": "articlesummary",
       "type": "summary"
   }

.. _developer-javascript:

JavaScript modules
==================

JavaScript modules are registered via ``Configuration/JavaScriptModules.php``
under the ``@wegewerk/Ai3Summary/`` import map prefix.

*   **``@wegewerk/Ai3Summary/ai3api``** -- ``Ai3Api`` class with
    ``getArticlesummary(pageId, language)`` that POSTs to the AJAX route
    via TYPO3's ``AjaxRequest``.
*   **``@wegewerk/Ai3Summary/summary``** -- Lit-HTML ``SummaryApp`` that
    renders the backend widget, handles the button click, calls ``Ai3Api``,
    and writes the result into the ``bodytext`` field (CKEditor 5 and
    CKEditor 4 fallback supported).

.. _developer-event-listener:

Event listener
==============

.. php:class:: Wegewerk\Ai3Summary\EventListener\AfterFormEnginePageInitializedEventListener

   Listens to ``AfterFormEnginePageInitializedEvent`` (``#[AsEventListener]``).
   Adds the extension's ``locallang.xlf`` as an inline language label file
   to the ``PageRenderer``, making all translation keys available to
   JavaScript.
