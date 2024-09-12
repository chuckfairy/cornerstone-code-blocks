/**
 * Code block integration to rivet
 */
import hljs from 'highlight.js/lib/core';

// Cornerstone util aliases
const util = window.csGlobal.rivet.util;
const attach = window.csGlobal.rivet.attach;

// Window loads
// we wait because other languages are enqueued individually
util.onLoad(function() {
  // Attach to data attribute data-cs-code-block
  attach('[data-cs-code-block]', function(el, params) {
    let innerText = el.innerText;

    innerText = innerText.replace(/&#91;/g, '[');
    innerText = innerText.replace(/&#93;/g, ']');

    el.innerText = innerText;

    // Highlight this element
    hljs.highlightElement(el);
  });

  // Copy Text of another element to the clipboard
  // based on the data-copy-element data attribute as the selector
  attach('[data-copy-element]', function(el, elementSelector) {
    // Element to change the message when it is copied
    const textDisplayElement = el.querySelector(el.getAttribute('data-copy-text-selector'));
    const copiedText = el.getAttribute('data-copied-text');


    // Return listener of click and copy to clipboard on copy
    // util.listener returns a teardown
    // so when the element is removed or changed the event is also removed and readded
    // This doesnt matter too much unless you are attaching an event to the body
    // or another element that is outside of the element we are attaching to
    return util.listener(el, 'click', function() {
      // Find element to copy the area from
      const copyElement = document.querySelector(elementSelector);

      // Could not find element to copy
      if (!copyElement) {
        console.error('Could not find element with selector : ', elementSelector);
        return;
      }

      // Browser does not support clipboard
      // or not https
      // or not localhost
      if (!navigator?.clipboard?.writeText) {
        alert('This browser does not support copying to the clipboard, this site is not running https, or you are not running your development site on localhost');
      }

      // Copy text to clipboard
      navigator.clipboard.writeText(copyElement.innerText).then(function() {
        // No Copied text display
        if (!textDisplayElement || !copiedText) {
          return;
        }

        // Save original text to display after we've shown the message
        const originalHTML = textDisplayElement.innerHTML;

        // Set text display to the copied message
        textDisplayElement.innerHTML = copiedText;

        // Wait a bit, and then return the copy display to the original text
        setTimeout(function() {
          textDisplayElement.innerHTML = originalHTML;
        }, 5000)
      }, function(err) {
        // Could not copy, possibly a browser setting
        console.error('Could not copy text: ', err);
      });

    });
  });
});

// Exported so the langauges we build can use it
window.hljs = hljs;
