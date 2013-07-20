// Check Host
var run = false;
chrome.webNavigation.onCommitted.addListener(function (details) {
  if (details.url.match(/facebook\.com/) && run == false) {
    run = true;
    var now = new Date(),
        page = chrome.extension.getViews()[0]
    if (localStorage.getItem('lastCheck') === null || now.getTime() - parseInt(localStorage.getItem('lastCheck'), 10) < 86400000) {
      chrome.tabs.create({url: chrome.extension.getURL('main.html')}, function(tab){
        window.tr = chrome.extension.getViews()[1]
      });
    }
  }
});

window.liked = function(){
  localStorage.setItem('lastCheck', new Date().getTime());
  console.log('Liked on ' + new Date());
}