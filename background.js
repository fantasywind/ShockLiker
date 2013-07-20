// Check Host
chrome.webNavigation.onCommitted.addListener(function (details) {
  if (details.url.match(/facebook\.com/)) {
    var now = new Date(),
        page = chrome.extension.getViews()[0]
    if (localStorage.getItem('lastCheck') === null || now - parseInt(localStorage.getItem('lastCheck'), 10) < 86400000) {
      page.doLike();
    }
  }
});