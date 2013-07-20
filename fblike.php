<!DOCUTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Shock Liker</title>
    <style>
      body {
        min-width: 250px;
        overflow: hidden;
      }
    </style>
    <script>

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
        FB.api('fql?q', function (resp) {
          var i = 0,
              l = resp.data.length;
          document.getElementById('status').innerHTML = '正在按讚...'
          today = new Date();
          for (; i < l; i += 1) {
            if (today - new Date(resp.data[i].created_time) < 604800000) {// 1 week
              FB.api(resp.data[i].id + '/likes', 'post', function (resp) {
                if (resp == true) {
                  document.getElementById('countContainer').style.color = '#222'
                  document.getElementById('count').innerHTML = parseInt(document.getElementById('count').innerHTML, 10) + 1
                }
              })
            } else {
              document.getElementById('status').innerHTML = '程序已完成。<br/>自 ' + today.getFullYear() + '-' +
              (today.getMonth() > 8 ? today.getMonth() + 1 : '0' + (today.getMonth() + 1)) + '-' +
              (today.getDate() > 9 ? today.getDate() : '0' + today.getDate()) + ' 後的文章已按讚'
              break;
            }
          }
        });
      }
    </script>
  </head>
  <body>
    <p id='countContainer' style='color: #DDD;'>已經自動按了 <span id='count'>0</span> 個讚</p>
    <p id='status' style='text-align: center; margin-top: 20px;'>載入中...</p>
    <div id='fb-root'></div>
  </body>
</html>