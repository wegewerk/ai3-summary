.. include:: /Includes.rst.txt

.. _configuration:

=============
Configuration
=============

.. _configuration-ai3-core:

Ai3 Core
========

Ai3 Summary relies on the configuration of **Ai3 Core**. Ensure that
:composer:`wegewerk/ai3_core` is properly installed and configured with
valid API credentials for the ZAK-AI service.

.. _configuration-api-credentials:

API Credentials
===============

The API credentials for the ZAK-AI service are provided via environment
variables consumed by ``Wegewerk\Ai3Core\Api\ZakAiClient``:

*   ``ZAKAI_API_KEY`` -- your ZAK-AI API key.
*   ``ZAKAI_SECRET`` -- your ZAK-AI secret.

.. _configuration-typoscript:

TypoScript
==========

The extension automatically registers its TypoScript setup via
``ext_localconf.php``. No manual TypoScript inclusion is required.

The setup adds the extension's template root path and maps the
``ai3_summary`` content element to the ``Ai3Summary`` Fluid template:

.. code-block:: typoscript
   :caption: Registered TypoScript setup (ext_localconf.php)

   lib.contentElement {
       templateRootPaths.1784806551592 = EXT:ai3_summary/Resources/Private/Templates/ContentElements/
   }

   tt_content.ai3_summary =< lib.contentElement
   tt_content.ai3_summary {
       templateName = Ai3Summary
   }
