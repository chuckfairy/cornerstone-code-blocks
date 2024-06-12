/**
 * Code block integration to rivet
 */
import hljs from 'highlight.js/lib/common';

const util = window.csGlobal.rivet.util;
const attach = window.csGlobal.rivet.attach;

// Window loads
// we wait because other languages are enqueued individually
util.onLoad(function() {
  // Attach to data attribute data-cs-code-block
  attach('[data-cs-code-block]', function(el, params) {
    // Highlight this element
    hljs.highlightElement(el);
  });
});

window.hljs = hljs;
