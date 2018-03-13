<?php
/**
 * Created by PhpStorm.
 * User: satoudai
 * Date: 18/03/13
 * Time: 18:36
 */
class NotificationComponent extends Component {

    # Slack通知
    public function slack_notify($text){
        $channel = '#notification';
        $token = 'xoxp-146567905312-147341900148-329012369781-7346deae97f08dd86eef27c06fa3036f';
        # エンコード
        $text = urlencode($text);
        $channel = urlencode($channel);
        $url = "https://slack.com/api/chat.postMessage?token=$token&channel=$channel&text=$text&as_user=true";
        file_get_contents($url);
    }

}