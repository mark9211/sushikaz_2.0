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
        $username = 'sushikaz_system';
        # エンコード
        $text = urlencode($text);
        $channel = urlencode($channel);
        $username = urlencode($username);
        $url = "https://slack.com/api/chat.postMessage?token=$token&channel=$channel&text=$text&as_user=false&username=$username";
        file_get_contents($url);
    }

}