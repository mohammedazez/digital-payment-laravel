<?php

namespace Appnotif\Notif;

class Notif {
    
    protected $title;
    protected $body;
    protected $user_id;
    
    public function __construct()
	{
	    $this->url = 'https://fcm.googleapis.com/fcm/send';
	    $this->key = '';
	}
	
    public function alluser($title, $body)
    {
        $notification = array(
            'title' => $title,
            'body' => $body,
            'priority' => 'high',
            'sound' => 'default',
            'click_action' => 'MainActivity'
        );
            
        $data1 = array(
            'notif_type' => 0
        );
        
    
        $header = array(
        'Authorization:key='.$this->key,
        'Content-Type: application/json'
        );
    
        $data = array( 
            'to' => '/topics/larakostInfo',
            'notification' => $notification,
            'data' => $data1
        );
    
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        $result = curl_exec($ch);
        
        // if(curl_exec($ch) === false) 
        // { 
        //     echo 'Curl error: ' . curl_error($ch);
        // }
        
        curl_close($ch); 
        
        return json_decode($result);
    }
    
    public function user($title, $body, $user_id)
    {
        $notification = array(
            'title' => $title,
            'body' => $body,
            'priority' => 'high',
            'sound' => 'default',
            'click_action' => 'MainActivity'
        );
            
        $data1 = array(
            'notif_type' => 1
        );
        
    
        $header = array(
        'Authorization:key='.$this->key,
        'Content-Type: application/json'
        );
    
        $data = array( 
            'to' => '/topics/larakostId_'.$user_id,
            'notification' => $notification,
            'data' => $data1
        );
    
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        $result = curl_exec($ch);
        
        // if(curl_exec($ch) === false) 
        // { 
        //     echo 'Curl error: ' . curl_error($ch);
        // }
        
        curl_close($ch); 
        
        return json_decode($result);
    }
}