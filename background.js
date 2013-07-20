// Check Host
chrome.webNavigation.onCommitted.addListener(function (details) {
  console.dir(details)
});

document.querySelector("#status").innerHTML = 'wer'

var arr = chrome.extension.getViews()
console.dir(arr)