<?php
ob_start();
define('API_KEY','282292401:AAE2ns2v0dHgEopS58BhllzKh1694mDGavs'); //bot api

function makeHTTPRequest($method,$datas=[]){
    $url = "https://api.telegram.org/bot".API_KEY."/".$method;
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_POSTFIELDS,http_build_query($datas));
    $res = curl_exec($ch);
    if(curl_error($ch)){
        var_dump(curl_error($ch));
    }else{
        return json_decode($res);
    }
}




// Fetching UPDATE
$update = json_decode(file_get_contents('php://input'));

if(isset($update->callback_query)){
    $callbackMessage = 'آپدیت شد';
    var_dump(makeHTTPRequest('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>$callbackMessage
    ]));
}elseif(isset($update->inline_query)) {
    echo 'QUERY ...';
    var_dump(makeHTTPRequest('answerInlineQuery',[
        'inline_query_id'=>$update->inline_query->id,
        'results'=>json_encode([[
            'type'=>'article',
            'id'=>base64_encode(1),
            'title'=>'لیست کانال های امشب',
            'input_message_content'=>['parse_mode'=>'HTML','message_text'=>"
            🍁🌿 🌸🌿
🌿🌿
🍁 با معرفی برترینهای فناوری و آموزشی تلگرام در خدمت شما هستیم🍁
〰〰〰〰〰〰〰〰〰〰
<em>برای عضویت روی دکمه مربوطه کلیک کنید</em>
            "],
            'reply_markup'=>[
                'inline_keyboard'=>[
                    [
                        ['text'=>"🍀   مفاهیم مهندسی وایرلس",'url'=>'https://telegram.me/joinchat/BZSb2Tuv7Kxk21OYT4TLKw']
                    ],
                    [
                        ['text'=>"🍀   صفر تا صد برنامه نویسی ربات تلگرام",'url'=>'https://telegram.me/joinchat/BdES-zwJKKGeFT8434LVsQ']
                    ],
                 
                   
                    [
                        ['text'=>"🍀   الکترونیک را کاربردی2222 بیاموزید",'url'=>'https://telegram.me']
                    ],



                ]
            ]
        ]])
    ]));
   
}
 else{


    $links = [
        'tbd'=>'https://telegram.me/joinchat/BdES-z-VdLwCVkbsFxggvg',
        'tbd_c'=>'https://telegram.me/joinchat/BdES-z-8OoIwyyLePo-_aw',
        'mhrdev'=>'https://telegram.me/joinchat/BdES-zwBMnQM1W88YwjSpg',
        'mhrdev_c'=>'https://telegram.me/joinchat/BdES-zwJKKGeFT8434LVsQ'
    ];
    var_dump(makeHTTPRequest('sendMessage',[
        'chat_id'=>$update->message->chat->id,
        'text'=>"ربات توسعه یافته برای تبادل های برترین کانال های ای تی تلگرام .",
        'reply_markup'=>json_encode([
            'inline_keyboard'=>[
                [['text'=>'گروه توسعه ربات تلگرام','url'=>$links['tbd']]],
                [['text'=>'کانال توسعه ربات تلگرام','url'=>$links['tbd_c']]],
                [['text'=>'گروه پرسش و پاسخ برنامه نویسی','url'=>$links['mhrdev']]],
                [['text'=>'کانال آموزش برنامه نویسی','url'=>$links['mhrdev_c']]],
                [['text'=>'کپی کردن لینک ها','url'=>'https://telegram.me/tbdinfo_bot?start=rec']],
                [['text'=>'تماس با توسعه دهنده','url'=>'https://telegram.me/pp2007ws']]
            ]
        ])
    ]));
}
file_put_contents('log',ob_get_clean());
