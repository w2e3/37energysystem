 $(document).on('click','.alert-text',function () {
      $.alert('你确定要退出吗？');
 });

 $(document).on('click','.confirm-ok', function () {
      $.confirm('你确定吗', function () {
          $.alert('你点击了确定');
      });
  });

  $(document).on('click','.prompt-ok', function () {
      $.prompt('请输入你的姓名', function (value) {
          $.alert('你的姓名"' + value + '"');
      });
  });



 $(document).on('click','.open-3-modal', function () {
    $.modal({
      title:  '请用手机号登录',
      text: '<div style="height:150px;overflow:auto">'+
        '<form action="">'+
        '<div class="weui-cell bordertop">'+
              '<div class="weui-cell__hd">'+
                  '<label class="weui-label" style="width:90px">手机号</label>'+
              '</div>'+
              '<div class="weui-cell__bd">'+
                  '<input class="weui-input" name="phone" type="tel" pattern="[0-9]*" placeholder="请输入手机号"/>'+
              '</div>'+
          '</div>'+
          '<div class="weui-cell weui-cell_vcode borderbom">'+
              '<div class="weui-cell__hd"><label class="weui-label" style="width:90px">年月日</label></div>'+
              '<div class="weui-cell__bd">'+
                  '<input class="weui-input" name="vcode" type="number" placeholder="年月日"/>'+
              '</div>'+
              // '<div class="weui-cell__ft">'+
              //     '<a class="weui-vcode-btn">获取验证码</a>'+
              // '</div>'+
          '</div>'+
          '<div class="weui-cell weui-cell_vcode borderbom">'+
              '<div class="weui-cell__hd"><label class="weui-label" style="width:90px">地址</label></div>'+
              '<div class="weui-cell__bd">'+
                  '<input class="weui-input" name="vcode" type="number" placeholder="地址"/>'+
              '</div>'+
              // '<div class="weui-cell__ft">'+
              //     '<a class="weui-vcode-btn">获取验证码</a>'+
              // '</div>'+
          '</div>'+
          '<div class="weui-cell weui-cell_vcode borderbom">'+
              '<div class="weui-cell__hd"><label class="weui-label" style="width:90px">密码</label></div>'+
              '<div class="weui-cell__bd">'+
                  '<input class="weui-input" name="vcode" type="number" placeholder="请输入密码"/>'+
              '</div>'+
              // '<div class="weui-cell__ft">'+
              //     '<a class="weui-vcode-btn">获取验证码</a>'+
              // '</div>'+
          '</div>'+
          '<div class="weui-cell weui-cell_vcode borderbom">'+
              '<div class="weui-cell__hd"><label class="weui-label" style="width:90px">密码</label></div>'+
              '<div class="weui-cell__bd">'+
                  '<input class="weui-input" name="vcode" type="number" placeholder="请输入密码"/>'+
              '</div>'+
              // '<div class="weui-cell__ft">'+
              //     '<a class="weui-vcode-btn">获取验证码</a>'+
              // '</div>'+
          '</div>'+
          '<div class="weui-cell weui-cell_vcode borderbom">'+
              '<div class="weui-cell__hd"><label class="weui-label" style="width:90px">密码</label></div>'+
              '<div class="weui-cell__bd">'+
                  '<input class="weui-input" name="vcode" type="number" placeholder="请输入密码"/>'+
              '</div>'+
              // '<div class="weui-cell__ft">'+
              //     '<a class="weui-vcode-btn">获取验证码</a>'+
              // '</div>'+
          '</div>'+
        '</form>'+
        '</div>',
      buttons: [
        {
          text: '取消',
          onClick: function() {
            $.alert('你点击了取消')
          }
        },
        {
          text: '确定',
          onClick: function() {
            $.alert('登录成功了')
          }
        }
      ]
    })
    });

    $(document).on('click','.open-tabs-modal', function () {
    $.modal({
      title:  '<div class="buttons-row">'+
                '<a href="#tab1" class="button active tab-link">Tab 1</a>'+
                '<a href="#tab2" class="button tab-link">Tab 2</a>'+
              '</div>',
      text: '<div class="tabs">'+
              '<div class="tab active" id="tab1" style="height:250px;overflow:auto">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam convallisLorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam convallisconvallis nunc non dolor consectetur adipiscing elit. Nullam convallis nunc non dolorconsectetur adipiscing elit. Nullam convallis nunc non dolor euismod feugiat. Sed at sapien nisl.  euismod feugiat. Sed at sapien nisl. euismod feugiat. Sed at sapien nisl. Ut et tincidunt metus. Suspendisse nec risus vel sapien placerat tincidunt. Nunc pulvinar urna tortor.</div>'+
              '<div class="tab" id="tab2" style="height:250px;overflow:auto">Vivamus feugiat diam velit. Maecenas aliquet egestas lacus, eget feugiat diam velit. Maecenas aliquet egestas lacus, eget pretium massafeugiat diam velit. Maecenas aliquet egestas lacus, eget pretium massa pretium massa mattis non. Donec volutpat euismod nisl in posuere. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae</div>'+
            '</div>',
      buttons: [
        {
          text: 'Ok, got it',
          bold: true
        },
      ]
    })
    });

    $(document).on('click','.open-vertical-modal', function () {
    $.modal({
      title:  'Vertical Buttons Layout',
      text: '这里是html',
      verticalButtons: true,
      buttons: [
        {
          text: 'Button 1',
          onClick: function() {
            $.alert('You clicked first button!')
          }
        },
        {
          text: 'Button 2',
          onClick: function() {
            $.alert('You clicked second button!')
          }
        },
        {
          text: 'Button 3',
          onClick: function() {
            $.alert('You clicked third button!')
          }
        },
      ]
    })
    });

