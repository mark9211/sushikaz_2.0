<?php
/**
 * Created by PhpStorm.
 * User: satoudai
 * Date: 18/03/13
 * Time: 18:36
 */
class NotificationComponent extends Component {

    # Slack通知
    public function slack_notify($text, $channel, $token){
        # エンコード
        $text = urlencode($text);
        $channel = urlencode($channel);
        $url = "https://slack.com/api/chat.postMessage?token=$token&channel=$channel&text=$text";
        file_get_contents($url);
    }

}