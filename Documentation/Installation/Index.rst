.. include:: /Includes.rst.txt

.. _installation:

============
Installation
============

.. _installation-requirements:

Requirements
============

*   TYPO3 CMS **13.4** or **14.x**
*   :composer:`wegewerk/ai3_core` (installed automatically as a dependency)
*   :composer:`typo3/cms-fluid-styled-content` **13.4** or **14.x**
*   A valid **ZAK-AI API key** (see :ref:`configuration`)

.. _installation-composer:

Installation via Composer
=========================

Ai3 Summary is installed exclusively via Composer. Run the following command
in your TYPO3 project root:

.. code-block:: bash
   :caption: Install the extension

   composer require wegewerk/ai3_summary

.. _installation-activate:

Activate the extension
======================

After installation, activate the extension using the TYPO3 CLI:

.. code-block:: bash
   :caption: Activate via CLI

   vendor/bin/typo3 extension:activate ai3_summary

Alternatively, activate it in the TYPO3 backend under
:guilabel:`Admin Tools > Extensions`.
