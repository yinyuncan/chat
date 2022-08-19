<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:90:"/data/wwwroot/dev/chat.profittravel.com/public/../application/mobile/view/index/index.html";i:1620185438;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="/favicon.ico"/>
    <title><?php echo $business_name; ?></title>
    <meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <script>        YMWL_ROOT_URL = '<?php echo $baseroot; ?>';

    </script>
    <link href="/assets/libs/layer/admin/layui.css?v=LK_DIY6.0.3" rel="stylesheet">
    <script src="/assets/libs/push/pusher.min.js?v=LK_DIY6.0.3" type="text/javascript"></script>
    <script type="text/javascript" src="/assets/libs/jquery/jquery.min.js?v=LK_DIY6.0.3"></script>
    <script src="/assets/libs/layui/layui.js?v=LK_DIY6.0.3" type="text/javascript"></script>
    <script src="/assets/libs/jquery/jquery.cookie.js?v=LK_DIY6.0.3" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="/assets/css/mobile/mobile.css?v=LK_DIY6.0.3">
    <script src="/assets/libs/jquery/jquery.form.min.js?v=LK_DIY6.0.3" type="text/javascript"></script>
    <link href="/assets/libs/layer/skin/layer.css?v=LK_DIY6.0.3" type="text/css" rel="stylesheet"/>
    <script src="/assets/libs/layer/layer.js?v=LK_DIY6.0.3" type="text/javascript"></script>
    <script type="text/javascript" src="/assets/libs/webrtc/recorder.js?v=LK_DIY6.0.3"></script>
    <script>        $.cookie('state','off');
        var visiter ='<?php echo $visiter; ?>';
        var business_id  ='<?php echo $business_id; ?>';
        var record='<?php echo $from_url; ?>';
        record.replace("%23","#");
        record.replace("%26","&");
        var pic ='<?php echo $avatar; ?>';
        var channel= '<?php echo $channel; ?>';
        var visiter_id= '<?php echo $visiter_id; ?>';
        var special = '<?php echo $special; ?>';

        var cid ='<?php echo $groupid; ?>';
        var url ='<?php echo $url; ?>';
        if (pic == "") {
            pic = "/assets/images/index/avatar-red2.png";
        }
         var service_id=0;
        function a() {
            var e = document.getElementById("chat-message-audio-source").src
                , b = document.getElementById("chat-message-audio");
            b.src = "";
            var p = b.play();
            p && p.then(function(){}).catch(function(e){});
            b.src = e;
            $(document).unbind("click", a);
        }
        $(document).on("click", a);
        var wolive_connect =function () {
            
                    var pusher = new Pusher('<?php echo $app_key; ?>', 
                        {encrypted: <?php echo $value; ?>,
                        enabledTransports: ['ws'],
                        wsHost: '<?php echo $whost; ?>',
                        <?php echo $port; ?>: <?php echo $wport; ?>,
                        authEndpoint: '/auth.php',
                        disableStats: true
                    });

                    var channels = pusher.subscribe("cu" + channel);

            channels.bind('my-chexiao', function (data) {
                $("#xiaox_"+data.message.cid).remove();
            });
            channels.bind('bind-wechat',function(data){
                $.ajax({
                    url: "/index/index/bind_user.html",
                    dataType: 'json',
                    data:{"visiter_id":"<?php echo $visiter_id; ?>
        ",'open_id':data.open_id,'business_id':'<?php echo $business_id; ?>','code':'<?php echo $code; ?>'},
                    type:"POST",   //请求方式
                    success: function (res) {
                        if(res.code>0){
                            layer.closeAll();
                            layer.open({
                                content: data.message
                                ,btn: ['确定']
                                ,yes: function(index, layero){
                                    window.location.href=res.url;
                                }
                                ,cancel: function(){
                                    return false;
                                }
                            });
                        }

                    }
                });

            });
                    channels.bind('my-event', function (data) {
                        if ($.cookie('state') != 'off') {
                            document.getElementById("chat-message-audio").play();
                        }
                        window.parent.postMessage({type:'sendNews',data:data.message},'*');
                        var msg = '';
                        msg += '<li class="chatmsg" id="xiaox_'+data.message.cid+'"><div style="position: absolute;top:0;left:0;">';
                        msg += '<img class="my-circle  se_pic" src="' + data.message.avatar + '" ></div>';
                        msg += "<div class='outer-left'><div class='service'>";
                        msg += "<pre>" + data.message.content + "</pre>";
                        msg += "</div></div>";
                        msg += "</li>";
                        $(".chatmsg_notice").remove();
                        $(".chatmsg_no").remove();
                        $(".conversation").append(msg);
                        var div = document.getElementById("wrap");
                        div.scrollTop = div.scrollHeight;
                        setTimeout(function(){
                            $('.chatmsg').css({
                                height: 'auto'
                            });
                        },0)
                    });

                    channels.bind('push-comment',function(data){

                        var html = '<div style="margin-bottom: 20px;">'+data.message.title+'</div>';
                        $.each(data.message.comments,function(index,value){
                            html += ' <div class=\'evaluate-item evaluate-score\' data-score="0">\n' +
                                '                <span class="evaluate-title">'+value+'</span>\n' +
                                '                <input type="hidden" name="'+value+'"/>\n' +
                                '                <img class="star" data-id="1" src="/assets/images/index/star.png" alt="">\n' +
                                '                <img class="star" data-id="2" src="/assets/images/index/star.png" alt="">\n' +
                                '                <img class="star" data-id="3" src="/assets/images/index/star.png" alt="">\n' +
                                '                <img class="star" data-id="4" src="/assets/images/index/star.png" alt="">\n' +
                                '                <img class="star" data-id="5" src="/assets/images/index/star.png" alt="">\n' +
                                '            </div>';
                        });

                        if (data.message.word_switch == 'open') {
                            html += '<div class=\'evaluate-item\' style="height: 80px;line-height: 1;margin-top: 10px;align-items: flex-start">\n' +
                                '                <span style="display: inline-block;margin-right: 12px;white-space: nowrap">'+ data.message.word_title +'</span>\n' +
                                '                <textarea class="about-text" name="" id="" cols="30" rows="4"></textarea>\n' +
                                '            </div>';
                        }

                        html += ' <div class="evaluate-btn">\n' +
                            '                <button class="reset">取消</button>\n' +
                            '                <button class="submit">提交</button>\n' +
                            '            </div>';
                        $('.bg .dialog-body').html(html);
                        $('.bg').show();

                    });

                    channels.bind('first_word',function(data){
                    var msg = '';
                        msg += '<li class="chatmsg_no"><div style="position: absolute;left:0;">';
                        msg += '<img class="my-circle  se_pic" src="' + data.message.avatar + '" ></div>';
                        msg += "<div class='outer-left'><div class='service'>";
                        msg += "<pre>" + data.message.content + "</pre>";
                        msg += "</div></div>";
                        msg += "</li>";

                        $(".conversation").append(msg);

                    });

                    channels.bind('cu_notice', function (data) {
                        $("#img_head").attr("src", data.message.avatar);
                        $("#services").text(data.message.nick_name);
                        $(".chatmsg_notice").remove();
                        $.cookie("services",data.message.service_id);
                        service_id =data.message.service_id;
                        getquestion(business_id);
                        getdata();
                    });

                    channels.bind('getswitch', function (data) {
                        $("#img_head").attr("src", data.message.avatar);
                        $("#services").text(data.message.nick_name);
                        $("#services").attr("data", data.message.service_id);
                        service_id = data.message.service_id;
                        $("#log").html('');
                        getdata();
                        layer.msg("已经将您转接到其他客服" + data.message.nick_name);
                    });

                   function getlisten(chas){
                        var channels = pusher.subscribe("se"+chas);

                        //通知游客 客服离线
                        channels.bind('logout', function (data) {
                            $("#status").text("[离线]");
                        });
                        //表示客服在线
                        channels.bind("geton", function (data) {
                            $("#status").text('');
                        });
                    }
                    if($.cookie("services")){
                        var id =$.cookie("services");
                        getlisten(id);
                    }

                     pusher.connection.bind('state_change', function(states) {
                        if(states.current == 'unavailable' || states.current == "disconnected" || states.current == "failed" ){
                            $.cookie("cid","");
                            var id =$.cookie("services");
                            if(id){
                              pusher.unsubscribe("se"+id);
                            }

                            pusher.unsubscribe("cu" + channel);
                             if (typeof pusher.isdisconnect == 'undefined') {
                                    pusher.isdisconnect = true;   
                                    pusher.disconnect();
                                    delete pusher; 
                                    window.setTimeout(function(){
                                            wolive_connect();
                                      },1000);
                             }                           
                         }
                    });

                    pusher.connection.bind('connected', function() {
                        $.cookie("cid","");
                    
                    });
                }



    </script>
    <style type="text/css">        #close_icon {
            position: absolute;
            right: 10px;
            top: 2px;
            cursor: pointer;
        }

        .input-but {
            position: relative;
            display: inline-block;
            vertical-align: middle;
            width: 30px;
            height: 30px;

        }

        .my-circle {
            border-radius: 30px;
        }

        .size {
            min-width: 30px;
            height: 25px;
            line-height: 30px;
            border: none;
        }

        .fileinput {
            width: 30px;
            height: 30px;
            position: absolute;
            top: 0px;
            right: 0px;
            opacity: 0;
            filter: alpha(opacity=0);
            cursor: pointer;
        }


        .chatmsg_question {
            position: relative;
            margin-bottom: 228px;
        }

        .my-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
        }

        .foot_msg {
            width: 100%;
            height: 100%;
            overflow: auto;
            position: relative;
        }


        #text_in {
            width: 100%;
            padding-right: 20%;
            height: 50px;
            float: left;
            border: 0;
            padding-left: 12px;
            color: #555555;
            font-size: 16px;
        }

        #text_in + .send-btn {
            position: absolute;
            right: 12px;
            top: 9px;
            width: 60px;
            height: 32px;
            line-height: 32px;
            border-radius: 6px;
            padding: 0;
            text-align: center;
        }

        .msg-toolbar {
            width: 100%;
            height: 44px;
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            top: 50px;
            background-color: #f7f7f7;
        }

        .msg-toolbar a {
            float: left;
            width: 25%;
            margin: 0;
            text-align: center;
        }

        .msg-toolbar a img {
            margin-top: 10.5px;
            height: 23px;
            width: 23px;
        }

        .tool_box {
            width: 100%;
            height: auto;
            position: absolute;
            bottom: 94px;
            top: -160px;
            display: none;
            background-color: #fff;
        }

        .wl_faces_main ul {
            margin: 5px 5px;
            overflow: hidden;
            width: 100%;
        }

        .wl_faces_main ul li {
            float: left;
            height: 30px;
            width: 26px;
            text-align: center;

        }

        .wl_faces_main ul li img {
            width: 22px;
            height: 22px;
            padding: 0;
        }

        .customer {
            background-color: #dddddd;
            display: inline-block;
            padding: 12px;
            float: right;
            word-break: break-all;
            word-wrap: break-word;
            color: #555555;
            border-radius: 8px;
            border-top-right-radius: 0;
            max-width: 80%;
            box-sizing: border-box;
        }

        .outer-left:before, .outer-left > i {
            height: 0;
            border: 0;
        }

        .outer-right:before, .outer-right > i {
            height: 0;
            border: 0;
        }

        .service {
            background-color: #fff;
            display: inline-block;
            margin-left: 10px;
            padding: 12px;
            float: left;
            word-break: break-all;
            word-wrap: break-word;
            color: #555555;
            border-radius: 8px;
            border-top-left-radius: 0;
            position: relative;
            left: 0;
            max-width: 80%;
            border: 1px solid #dddddd;
        }

        .content {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow-y: auto;
            margin: 0;
        }

        .bg, .offline {
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            background-color: rgba(0, 0, 0, .4);
            z-index: 998;
            display: none;
        }

        .dialog {
            width: 65%;
            padding: 20px 25px;
            border-radius: 5px;
            background-color: #fff;
            margin: 25% auto 0;
            position: relative;
            padding-bottom: 65px;
        }

        .bg .title {
            font-size: 15px;
            text-align: center;
            color: #555555;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .evaluate-item {
            height: 26px;
            display: flex;
            align-items: center;
        }

        .evaluate-item img {
            height: 16px;
            width: 16px;
            cursor: pointer;
            margin-left: 14px;
        }

        .evaluate-item img:first-of-type {
            margin-left: 14px;
        }

        .evaluate-text {
            display: none;
            border: 1px solid #4AACFF;
            color: #4AACFF;
            height: auto;
            font-size: 13px;
            border-radius: 5px;
            margin-left: 12px;
            padding: 0 5px;
        }

        .about-text {
            border: 1px solid #E5E3E9;
            border-radius: 10px;
            width: 68%;
            padding: 5px 10px;
        }

        .evaluate-btn {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .dialog .evaluate-btn {
            position: absolute;
            width: 100%;
            bottom: 0;
            left: 0;
            height: 45px;
            line-height: 45px;
            border-bottom-left-radius: 5px;
            border-bottom-right-radius: 5px;
        }

        .dialog .evaluate-btn button {
            width: 50%;
            border: 0;
            font-size: 15px;
        }

        .dialog .evaluate-btn button.reset {
            border-bottom-left-radius: 5px;
            background-color: #F5F5F5;
            color: #555555;
        }


        .dialog .evaluate-btn button.submit {
            border-bottom-right-radius: 5px;
            background-color: #25c16f;
            color: #fff;
        }

        .evaluate-title {
            min-width: 85px;
            text-align: left;
        }

        .offline-item {
            margin-bottom: 15px;
        }

        .offline-title {
            text-align: left;
            margin-bottom: 10px;
        }

        .offline-item input {
            height: 40px;
            border-radius: 20px;
            padding: 0 5%;
            border: 1px solid #E8E6EB;
            width: 90%;
        }

        .keyword {
            position: fixed;
            bottom: 94px;
            left: 0;
            max-width: 100%;
            height: 48px;
            white-space: nowrap;
            z-index: 90;
            display: none;
            overflow-y: auto;
            background-color: #f7f7f7;
        }

        .keyword #question_key_list {
            margin-top: 8px;
            margin-left: 20px;
        }

        .keyword .swiper-slide {
            display: inline-block;
            width: auto;
            height: 24px;
            line-height: 24px;
            padding: 0 10px;
            border-radius: 12px;
            border: 1px solid #E2E2E2;
            font-size: 12px;
            margin-right: 10px;
            background-color: #fff;
            cursor: pointer;
        }

        .fanhui {
            color: #fff !important;
            line-height: 45px;
        }

        .close {
            position: absolute;
            top: -23px;
            right: -23px;
            z-index: 999;
            height: 27px;
            width: 27px;
            cursor: pointer;
            border: 1px solid #fff;
            border-radius: 50%;
            overflow: hidden;
        }
    </style>
</head>
<body>
<audio id="chat-message-audio">
    <source id="chat-message-audio-source" src="/upload/voice/default.mp3" type="audio/mpeg"/>
</audio>
<div id="container"><?php if ($is_bind_wechat) { ?>
        <div id="follow_topbar" class="clear">
        <div style="float: left"><i class="fa fa-bullhorn"></i> 欢迎进入<?php echo $business_name; ?>，<br/>关注公众号，享专属服务
        </div>
        <div style="float: right"><a class="layui-btn layui-btn-sm" id="followbtn">立即关注</a></div></div><?php } ?>
    <div class="bg">
        <div class="dialog">
            <div class="title">评价客服</div>
            <div class="dialog-body">
                <div style="margin-bottom: 20px;">请对我的服务进行评价，满意请打5星哦~</div>
                <div class='evaluate-item evaluate-score' data-score="0"><span class="evaluate-title">服务态度态度</span><img
                            class="star" data-id="1" src="/assets/images/index/star.png" alt=""><img class="star"
                                                                                                     data-id="2"
                                                                                                     src="/assets/images/index/star.png"
                                                                                                     alt=""><img
                            class="star" data-id="3" src="/assets/images/index/star.png" alt=""><img class="star"
                                                                                                     data-id="4"
                                                                                                     src="/assets/images/index/star.png"
                                                                                                     alt=""><img
                            class="star" data-id="5" src="/assets/images/index/star.png" alt=""></div>
                <div class='evaluate-item' style="height: 80px;line-height: 1;margin-top: 10px;align-items: flex-start">
                    <span style="display: inline-block;margin-right: 12px;white-space: nowrap">意见意见建议</span><textarea
                            class="about-text" name="" id="" cols="30" rows="4"></textarea></div>
                <div class="evaluate-btn">
                    <button class="reset">取消</button>
                    <button class="submit">提交</button>
                </div>
            </div>
        </div>
    </div>
    <div class="offline" <?php if ($reststate == true): ?>style="display: block;" <?php endif; ?>>
        <div class="dialog"><img class="close" src="/assets/images/index/close.png"
                                 onclick="$(this).parents('.offline').hide();">
            <div class="dialog-body">
                <div style="margin-bottom: 20px;"><?php echo nl2br($restsetting['reply']); ?></div><?php if ($restsetting['name_state'] == 'open'): ?>
                    <div class='offline-item'>
                        <div class="offline-title">姓名</div>
                        <input placeholder="请输入您的姓名" id="offline_name" type="text"></div><?php endif;
                if ($restsetting['tel_state'] == 'open'): ?>
                    <div class='offline-item'>
                        <div class="offline-title">联系方式</div>
                        <input placeholder="请输入您的联系方式" id="offline_mobile" type="number"
                               onkeypress='return( /[\d]/.test(String.fromCharCode(event.keyCode)))'></div><?php endif;
                if (($restsetting['name_state'] == 'open') || ($restsetting['tel_state'] == 'open')): ?>
                    <div class="evaluate-btn">
                        <button class="reset">取消</button>
                        <button class="submit">提交</button>
                    </div><?php endif; ?></div>
        </div>
    </div>
    <a href="javascript:history.back(-1)" class="fanhui"><i class="layui-icon"
                                                            style="position: absolute;left:10px;font-size: 20px;z-index: 999">&#xe603;</i></a>
    <div class="header" style="background-color: #<?php echo $theme; ?>"><span id="services"
                                                                               style="color: #FFF;"></span><span
                id="status"></span></div>
    <div class="content" id="wrap" style="background-color: rgb(247, 247, 247);"><a
                href="<?php echo url('index/report', ['business_id' => $business_id]); ?>"
                style="position: fixed;right: 6px;top:56px;width: 3em;height: 3em;background-color: rgba(0,0,0,0.3);border-radius: 50%;text-align: center;line-height: 3em;color: #ffffff;z-index: 99999999;">投诉</a>
        <div style="height: 55px;width: 100%;"></div>
        <ul id="log" class="conversation"></ul>
        <div style="height: 94px;width: 100%;"></div>
    </div>
    <div class="keyword">
        <div class="swiper-wrapper" id="question_key_list"></div>
    </div>
    <div class="foot_all" style="position:fixed;bottom:0;width: 100%;height: 94px;padding:0;z-index: 999">
        <div class="tool_box">
            <div class="wl_faces_content">
                <div class="wl_faces_main"></div>
            </div>
        </div>
        <div class="foot_msg">
            <div class="footer"><input type="text" id="text_in" placeholder="发消息..." class="layui-input"/>
                <button class="layui-btn layui-btn-normal send-btn" style="background-color: #<?php echo $theme; ?>"
                        onclick="send()">发送
                </button>
            </div>
            <div class="msg-toolbar"><a id="face_icon" href="javascript:" onclick="faceon()"><img
                            src="/assets/images/admin/B/smile.png" alt=""></a><?php if ($atype == 'open'): ?><a
                        onclick="getaudio()"><img src="/assets/images/admin/B/smile.png" alt=""></a><?php endif; ?><a
                        id="images" href="javascript:">
                    <form id="picture" enctype="multipart/form-data">
                        <div class="layui-box input-but  size"><img src="/assets/images/admin/B/photo.png" alt=""><input
                                    type="file" name="upload" class="fileinput" onchange="put()"/></div>
                    </form>
                </a><a id="files" href="javascript:">
                    <form id="file" enctype="multipart/form-data">
                        <div class="layui-box input-but  size"><img src="/assets/images/admin/B/file.png" alt=""><input
                                    type="file" name="folder" class="fileinput" onchange="putfile()"/></div>
                    </form>
                </a><a onclick="hint()" id="clickbf" style="margin-top: 7px;"><i class="layui-icon state-mp3"
                                                                                 style="font-size: 28px;cursor: pointer;color: #999999">&#xe685;</i></a>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="/assets/js/moblie/mochat.js?v=LK_DIY6.0.3"></script>
<script>    function isWeiXin(){
        var ua = window.navigator.userAgent.toLowerCase();
        if(ua.match(/MicroMessenger/i) == 'micromessenger'){
            return true;
        }else{
            return false;
        }
    }
    if(isWeiXin()){
        $('.fanhui').hide();
    }
    var hint=function(){
        var state=$.cookie('state');
        if(state == "on"){
            $('.state-mp3').html('&#xe685;');
            layer.msg('关闭提示音',{end:function(){
                    $.cookie('state',"off");
                }});
        }else{
            $('.state-mp3').html('&#xe645;');
            layer.msg('开启提示音',{end:function(){
                    $.cookie('state',"on");
                }});
        }
    }
    $(document).one('click',function () {
        var state=$.cookie('state');
        if(state == "off"){
            $('.state-mp3').html('&#xe645;');
            $.cookie('state',"on");
        }
    });
    $(document).on('click','.reset',function(){
        $('.bg').hide();
        $('.offline').hide();
    })

    $(document).on('click','.offline .submit',function(){
        let name = $('#offline_name').val();
        let mobile = $('#offline_mobile').val();
        $.ajax({
            url:YMWL_ROOT_URL+"/admin/event/info",
            type: "post",
            data: {visiter_id:visiter_id,business_id: business_id,name:name,tel:mobile},
            dataType:'json',
            success:function(res){
                if(res.code != 0){
                    layer.msg(res.msg,{icon:2});
                } else {
                    layer.msg(res.msg,{icon:1});
                    setTimeout(function(){
                        $('.offline').hide();
                    },2000)
                }
            }
        });
    });

    $(document).on('click','.bg .submit',function(){
        let comment = '';
        if($('.about-text').val()){
            comment = $('.about-text').val();
        }
        let scores = [];
        $(".evaluate-score").each(function(item){
            let title = $(this).find('.evaluate-title').text();
            let score = $(this).attr('data-score');
            scores[item] = {'title':title,'score':score}
        });

        $.ajax({
            url:YMWL_ROOT_URL+"/admin/event/comment",
            type: "post",
            data: {service_id:service_id, visiter_id:visiter_id,comment: comment,business_id: business_id,scores:JSON.stringify(scores)},
            dataType:'json',
            success:function(res){
                if(res.code != 0){
                    layer.msg(res.msg,{icon:2});
                } else {
                    layer.msg(res.msg,{icon:1});
                    setTimeout(function(){
                        $('.bg').hide();
                    },2000)
                }
            }
        });
    });

    $(document).on('click','.star',function(row){
        let light = '/assets/images/index/star-light.png';
        let dark = '/assets/images/index/star-dark.png';
        let star = '/assets/images/index/star.png';
        let index = row.target.dataset.id;
        $(this).parent().find('.star').attr('src',star);
        switch(index)
        {
            case '1':
                $(this).attr('src',dark);
                $(this).parent('.evaluate-item').attr('data-score',1)
                break;
            case '2':
                $(this).attr('src',dark);
                $(this).prev('.star').attr('src',dark)
                $(this).parent('.evaluate-item').attr('data-score',2)
                break;
            case '3':
                $(this).attr('src',light);
                $(this).prevAll('.star').attr('src',light);
                $(this).parent('.evaluate-item').attr('data-score',3)
                break;
            case '4':
                $(this).attr('src',light);
                $(this).prevAll('.star').attr('src',light)
                $(this).parent('.evaluate-item').attr('data-score',4)
                break;
            case '5':
                $(this).parent().find('.star').attr('src',light);
                $(this).parent('.evaluate-item').attr('data-score',5)
                break;
        }
    });

    $(document).on('touchend', '.content', function () {
        $("#text_in").blur();
        $('.tool_box').css({
            display: 'none'
        });
    });

    var getaudio =function(){

     var sid =$.cookie('services');
     if(sid == service_id){

         //音频先加载
                var audio_context;
                var recorder;
                var wavBlob;
                //创建音频
                try {
                    // webkit shim
                    window.AudioContext = window.AudioContext || window.webkitAudioContext;
                    navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia || navigator.mediaDevices.getUserMedia;
                    window.URL = window.URL || window.webkitURL;

                    audio_context = new AudioContext;

                    if (!navigator.getUserMedia) {
                        console.log('语音创建失败');
                    }
                    ;
                } catch (e) {
                    console.log(e);
                    return;
                }
                navigator.getUserMedia({audio: true}, function (stream) {
                    var input = audio_context.createMediaStreamSource(stream);
                    recorder = new Recorder(input);

                    var falg = window.location.protocol;
                    if (falg == 'https:') {
                        recorder && recorder.record();

                        //示范一个公告层
                        layui.use(['jquery', 'layer'], function () {
                            var layer = layui.layer;

                            layer.msg('录音中...', {
                                icon: 16
                                , shade: 0.01
                                , skin: 'layui-layer-lan'
                                , time: 0 //20s后自动关闭
                                , btn: ['发送', '取消']
                                , yes: function (index, layero) {
                                    //按钮【按钮一】的回调
                                    recorder && recorder.stop();
                                    recorder && recorder.exportWAV(function (blob) {
                                        wavBlob = blob;
                                        var fd = new FormData();
                                        var wavName = encodeURIComponent('audio_recording_' + new Date().getTime() + '.wav');
                                        fd.append('wavName', wavName);
                                        fd.append('file', wavBlob);

                                        var xhr = new XMLHttpRequest();
                                        xhr.onreadystatechange = function () {
                                            if (xhr.readyState == 4 && xhr.status == 200) {
                                                jsonObject = JSON.parse(xhr.responseText);

                                                voicemessage = '<div style="cursor:pointer;text-align:center;" onclick="getstate(this)" data="play"><audio src="'+jsonObject.data.src+'"></audio><i class="layui-icon" style="font-size:25px;">&#xe652;</i><p>音频消息</p></div>';

                                                    var sid = $('#channel').text();
                                    
                                                    var time;

                                                    var sdata = $.cookie('cu_com');

                                                    if (sdata) {
                                                        var json = $.parseJSON(sdata);
                                                        var img = json.avater;

                                                    }

                                                       if($.cookie("itime") == ""){
                                                            var myDate = new Date();
                                                                time = myDate.getHours()+":"+myDate.getMinutes();
                                                            var timestamp = Date.parse(new Date());
                                                            $.cookie("itime",timestamp/1000);
                                                        
                                                        }else{

                                                            var timestamp = Date.parse(new Date());
                                                            var lasttime =$.cookie("itime");
                                                            if((timestamp/1000 - lasttime) >30){
                                                                var myDate =new Date(timestamp);
                                                                time = myDate.getHours()+":"+myDate.getMinutes();
                                                            }else{
                                                                time ="";
                                                            }

                                                            $.cookie("itime",timestamp/1000);
                                                        }
                                               
                                                var str = '';
                                                    str += '<li class="chatmsg"><div class="showtime">' + time + '</div>';
                                                    str += '<div style="float: right;"><img  class="my-circle cu_pic" src="' + pic + '" ></div>';
                                                    str += "<div class='outer-right'><div class='customer'>";
                                                    str += "<pre>" +  voicemessage + "</pre>";
                                                    str += "</div></div>";
                                                    str += "</li>";

                                                    $(".conversation").append(str);
                                                    $("#text_in").empty();

                                                    var div = document.getElementById("wrap");
                                                    div.scrollTop = div.scrollHeight;
                                                    $("img[src*='upload/images']").parent().parent('.customer').css({
                                                        padding: '0',borderRadius: '0'
                                                    });
                                                    $("img[src*='upload/images']").parent().parent('.service').css({
                                                        padding: '0',borderRadius: '0'
                                                    });
                                                    setTimeout(function(){
                                                        $('.chatmsg').css({
                                                            height: 'auto'
                                                        });
                                                    },0)
                                                   $.ajax({
                                                    url:YMWL_ROOT_URL+"/admin/event/chat",
                                                    type: "post",
                                                    data: {visiter_id:visiter_id,content: voicemessage,business_id: business_id, avatar: pic,record: record,service_id:service_id},
                                                    dataType:'json',
                                                    success:function(res){
                                                        if(res.code != 0){
                                                            layer.msg(res.msg,{icon:2});
                                                        }
                                                    }
                                                });
                                            }
                                        };
                                        xhr.open('POST', '/admin/event/uploadVoice');
                                        xhr.send(fd);
                                    });
                                    recorder.clear();
                                    layer.close(index);
                                }
                                , btn2: function (index, layero) {
                                    //按钮【按钮二】的回调
                                    recorder && recorder.stop();
                                    recorder.clear();
                                    audio_context.close();
                                    layer.close(index);
                                }
                            });

                        });
                    } else {
                        
                            layer.msg('音频输入只支持https协议！');
                        
                    }


                }, function (e) {
                     layer.msg('音频输入只支持https协议！');
                });


        }
    }

  
   var getstate =function(obj){
       
       var c=obj.children[0];
 
       var state=$(obj).attr('data');
   
       if(state == 'play'){
         c.play();
         $(obj).attr('data','pause');
         $(obj).find('i').html("&#xe651;");
       
       }else if(state == 'pause'){
          c.pause();
         $(obj).attr('data','play');
          $(obj).find('i').html("&#xe652;");
       }

        c.addEventListener('ended', function () {  
         $(obj).attr('data','play');
         $(obj).find('i').html("&#xe652;");
        
       }, false);
    }

   


   document.getElementById("wrap").onscroll = function(){
        var t =  document.getElementById("wrap").scrollTop;
        if( t == 0 ) {
            if($.cookie("cid") != ""){
                getdata();
            }
        }
    }
    
    var text = document.getElementById('text_in');
    // 获取焦点，拉到底部
    text.onfocus  = function() {
        $(".tool_box").hide();
        let height = +document.documentElement.clientHeight;
        setTimeout(function(){
            $('html ,body').animate({scrollTop: height}, 0);
        },200)
    }
    // 失去焦点，拉到顶部
    text.onblur = function() {
        setTimeout(function() {
            $('html ,body').animate({scrollTop: 0}, 0);
        },0)
    }


</script>
</body>
</html>