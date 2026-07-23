.. include:: /Includes.rst.txt

.. _editor:

======
Editor
======

This section describes how editors can use the **Page Summary** content
element in the TYPO3 backend.

.. _editor-add-element:

Add the content element
=======================

#.  Open the **Page** module and navigate to the page where you want to
    add a summary.
#.  Click :guilabel:`+ Content` to open the content element wizard.
#.  Select the **Page Summary** element from the **AI3** group.
#.  In the :guilabel:`Summary generator` field, select the desired
    **language** from the language selector (e.g. English or Deutsch).
#.  Click the :guilabel:`Generate Page Summary` button.
#.  Wait while the summary is being generated
    (:guilabel:`Generating summary...` is shown during processing).
#.  The generated bullet-point summary is automatically inserted into
    the :guilabel:`Text` (bodytext) field.
#.  Review and edit the generated text if needed, then **save** the
    content element.

.. note::

   The summary is generated from all content elements currently saved on
   the page. Make sure all relevant content is saved before generating
   the summary.

.. _editor-frontend:

Frontend output
===============

Once saved, the Page Summary content element renders the stored bodytext
as HTML on the frontend inside a ``<div class="ce-bodytext rich-text">``
wrapper, identical to standard RichText content elements.
