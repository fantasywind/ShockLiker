<!DOCUTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Shock Liker</title>
    <style>
      iframe {
        min-width: 250px;
        overflow: hidden;
        border: 0;
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
        FB.api('fql?q=SELECT%20post_id%2C%20type%20FROM%20stream%20WHERE%20source_id%20%3D%20105647582858237%20AND%20like_info.user_likes%20%3D%200', function (resp) {
          var i = 0,
              l = resp.data.length;

          document.getElementById('status').innerHTML = '正在按讚...'
          today = new Date();
          for (; i < l; i += 1) {
            if (resp.data[i].type == null)
              continue;
            FB.api(resp.data[i].post_id + '/likes', 'post', function (resp) {
              if (resp == true) {
                document.getElementById('countContainer').style.color = '#222'
                document.getElementById('count').innerHTML = parseInt(document.getElementById('count').innerHTML, 10) + 1
              }
            })
          }
          document.getElementById('status').innerHTML = '程序結束。'

          parent.done();
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