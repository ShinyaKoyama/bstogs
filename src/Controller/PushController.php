<?php
namespace App\Controller;

use App\Controller\AppController;

class PushController extends AppController {
    function index() {
        $accessToken = '4l5TIJ5j0E9cltX+zF9WUDun6waNwwvu9oZd0Nh/UJ+TYwcgrDupmW8SQK6p0yUiiPbLlmt/umcb9qaZKpHJR/8eQcZe8PhHHtLa5IMpuaFkX6yoU8ZLFAQjJUE0ZCPKTXxjKlsxGy+Zd+DrZEDnFAdB04t89/1O/w1cDnyilFU=';
        $baseUrl = 'https://api.line.me/v2/bot/message/push';
        
        // Get message from user.
        $jsonString = file_get_contents('php://input');
        $jsonObj = json_decode($jsonString);
        
        // EventType(Message, Follow, Unfollow, Join, Leave, Postback, Beacon)
        $eventType = $jsonObj->{"events"}[0]->{"message"}->{"type"};
        // Get Message.
        $mesText = $jsonObj->{"events"}[0]->{"message"}->{"text"};
        // Get ReplyToken.
        $replyToken = $jsonObj->{"events"}[0]->{"replyToken"};
        
        // Get UserType of sending message.
        $sourceType = $jsonObj->{"events"}[0]->{"source"}->{"type"};
        $roomId = $jsonObj->{"events"}[0]->{"source"}->{"roomId"};
        $groupId = $jsonObj->{"events"}[0]->{"source"}->{"groupId"};
        
        
        if(isset($roomId)) {
            require_once("room.php");
            $postData = room($replyToken, $eventType, $mesText);
        } elseif(isset($groupId)) {
            require_once("group.php");
            $postData = group($replyToken, $eventType, $mesText);
        } else {
            // If it's not a message return without returning anything.
            if($eventType !== "text") {
                exit;
            }
            // Create "replry message".
            $responseFormatText = [
                "type" => "text",
                "text" => "「".$mesText."」じゃないよ..."
            ];
            $postData = [
                "replyToken" => $replyToken,
                "messages"   => [$responseFormatText]
            ];
        }
        
        $response = array(
            "to" => "",
            "messages" => array(
                "type" => "text",
                "text" => "Hello World"
            )
        );
        
        $curl = curl_init("https://api.line.me/v2/bot/message/push");
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($response));
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        			'Content-Type: application/json; charser=UTF-8',
        			'Authorization: Bearer '.$accessToken
        		)
        	);
        
        $result = curl_exec($curl);
        curl_close($curl);
        
        $this->set('result', $result);
    }
}