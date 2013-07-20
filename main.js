

window.onload = function () {
   // Initial FB SDK
      (function (d, s, id){
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {return;}
        js = d.createElement(s); js.id = id;
        js.src = "https://connect.facebook.net/en_US/all.js";
        fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));

      window.fbAsyncInit = function () {
        FB.init({
          appId : '555206894540812',
          status: true 
        })
        FB.getLoginStatus(function(resp){
          if (resp.status === 'connected') {
            loadPosts();
          } else {
            document.getElementById('status').innerHTML = '請登入並給予 facebook 權限!'
            FB.login(function(resp){
              if (resp.authResponse) {
                loadPosts();
              }
            }, {scope: 'email,publish_stream'});
          }
        })
      }

      // 取的粉絲團文章
      loadPosts = function () {
        document.getElementById('status').innerHTML = '正在取得文章'
        FB.api('fql?q=SELECT post_id FROM stream WHERE source_id = 105647582858237 AND like_info.user_likes = 0', function (resp) {
          var i = 0,
              l = resp.data.length;
          document.getElementById('status').innerHTML = '正在按讚...'
          today = new Date();
          for (; i < l; i += 1) {
            
              FB.api(resp.data[i].post_id + '/likes', 'post', function (resp) {
                if (resp == true) {
                  document.getElementById('countContainer').style.color = '#222'
                  document.getElementById('count').innerHTML = parseInt(document.getElementById('count').innerHTML, 10) + 1
                }
              })
            } 
              document.getElementById('status').innerHTML = '程序已完成。<br/>自 ' + today.getFullYear() + '-' +
              (today.getMonth() > 8 ? today.getMonth() + 1 : '0' + (today.getMonth() + 1)) + '-' +
              (today.getDate() > 9 ? today.getDate() : '0' + today.getDate()) + ' 後的文章已按讚'
              break;

              chrome.extension.getBackgroundPage().liked();
            
          }
        });
      }
}