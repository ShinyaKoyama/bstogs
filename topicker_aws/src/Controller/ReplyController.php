<?php
namespace App\Controller;

use App\Controller\AppController;

class ReplyController extends AppController {
    function index() {
        $accessToken = 'gIaXcBjVSAiACT1C8+4Zd3RXN3LJQGUvMEn4SPQSxB3PoSaIjz0H/Fu+IAKGvVGfE/g/ZKxq60d0AUZFF3o4FLIrBmDBvyqvBlW8CTFZ0hy8YXUN3CTsFWF0OhTFdlHQR1cZ+S6tsaB43RTrDjXy9wdB04t89/1O/w1cDnyilFU=';

        // Get message from user.
        $jsonString = file_get_contents('php://input');
        $jsonObj = json_decode($jsonString);
        
        // EventType(Message, Follow, Unfollow, Join, Leave, Postback, Beacon)
        $type = $jsonObj->{"events"}[0]->{"message"}->{"type"};
        // Get Message.
        $mesText = $jsonObj->{"events"}[0]->{"message"}->{"text"};
        // Get ReplyToken.
        $replyToken = $jsonObj->{"events"}[0]->{"replyToken"};

        // Get UserType of sending message.
        $sourceType = $jsonObj->{"events"}[0]->{"source"}->{"type"};
        $roomId = $jsonObj->{"events"}[0]->{"source"}->{"roomId"};
        $groupId = $jsonObj->{"events"}[0]->{"source"}->{"groupId"};


        if(isset($roomId)) {
            require("room.php");
            $postData = room($replyToken, $type, $mesText);
        } elseif(isset($groupId)) {
            require("group.php");
            $postData = group($replyToken, $type, $mesText);
        } else {
            // If it's not a message return without returning anything.
            if($type !== "text") {
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

        $curl = curl_init("https://api.line.me/v2/bot/message/reply");
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($postData));
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