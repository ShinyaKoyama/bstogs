<?php
namespace App\Controller;

use App\Controller\AppController;

class WpConnectionController extends AppController {
    function index() {
        $result = '';
        if($this->request->isPost()) {
            foreach($this->request->data['WpConnectionForm'] as $key => $value) {
                if($key === 'title') {
                    $title = $value;
                } elseif($key === 'content') {
                    $content = $value;
                } elseif($key === 'status') {
                    $status = $value;
                } else {
                    // ERROR process scheduled to be described
                }
            }
            
            // WordPress on localhost
            // $accessToken = 'dXNlcjpWSno1IHBpUVMgRnlmViBSQjFGIGtIQUwgTllVaA==';
            // $baseUrl = 'http://bbc.localhost/wp-json/wp/v2/posts/';
            
            // WordPress on EC2(13.58.56.245)
            $accessToken = 'dXNlcjpIeU11IGIyWVggc1diOSBuemd1IGRKVEIgSThSUg==';
            $baseUrl = 'http://ec2-13-58-56-245.us-east-2.compute.amazonaws.com/wp-json/wp/v2/posts/';
            
            $transmissionData = array(
                'title'   => $title,
                'content' => $content,
                'status'  => $status
            );
            
            $header = array(
                'Authorization: Basic '. $accessToken,
                'Content-Type: application/json',
            );
            
            // curl execution
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $baseUrl);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($transmissionData));
            curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HEADER, true);
            
            $response = curl_exec($curl);
            $headerSize = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
            $header = substr($response, 0, $headerSize);
            $body = substr($response, $headerSize);
            $result = json_decode($body, true);
            curl_close($curl);
            
        } else {
            $result = '※投稿内容を入力し、「送信」ボタンを押して下さい。';
        }
        $this->set('result', $result);
    }
}