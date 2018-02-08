<?php
  $token = getenv('NOTIFY_TOKEN');

  $content = array('message' => 'Hello !');

  print_r($token);
  print_r(LineNotify::PushMessage($token,$content));

  class LineNotify
  {
    public function PushMessage($token, $body)
    {
      $result_ = "";
      $url = 'https://notify-api.line.me/api/notify';

      $ch = curl_init();
      curl_setopt( $ch, CURLOPT_URL, $url);
      // SSL USE
      curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 0);
      curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 0);
      //POST
      curl_setopt( $ch, CURLOPT_POST, 1);
      curl_setopt( $ch, CURLOPT_POSTFIELDS, $body);
      curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
      //ADD header array
      $headers = array( 'Content-type: multipart/form-data', 'Authorization: Bearer '.$token, );
      curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers);
      //RETURN
      curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);

      $result = curl_exec( $ch );

      //Check error
      if(curl_error( $ch )) {
        $error_ = array('status' => "Error",'massage' => curl_error( $ch ));
        $result_ = json_decode($error_, true);
      }
      else {
        $result_ = json_decode($result, true);
      }
      //Close connect
      curl_close( $ch );
      return  $result_;
  }
}
?>