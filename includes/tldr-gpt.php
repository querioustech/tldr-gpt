<?php

function tldrgpt_summarize($post_id, $post){
    $base_url = "https://api.openai.com/v1";
    $url = "$base_url/chat/completions";
  
    $post_content = wp_strip_all_tags($post->post_content);
  
    $token = get_option('tldrgpt-openai-apikey', '');
  
    $headers = [
        "Authorization" => "Bearer $token",
        'Content-Type' => 'application/json'
    ];
  
    $payload = [
      "model" => "gpt-3.5-turbo-16k", // TODO: Make this an option
      "messages" => [
          [
              "role" => "user",
              "content"=> "$post_content Tl;dr"
          ]
      ],
      "temperature" => 1,
      "max_tokens" => 10000, // TODO: Make this an option
      "presence_penalty" => 0,
      "frequency_penalty" => 0
    ];
  
    $res = wp_remote_post( $url, array(
        'headers' => $headers,
        'body' => wp_json_encode($payload)
      )
    );
  
    if ( !is_wp_error( $res )  && wp_remote_retrieve_response_code( $res ) == 200 )
    {
      $body = json_decode( wp_remote_retrieve_body( $res ) );
  
      if ( count($body->choices) > 0 )
      {
        return $body->choices[0]->message->content;
      }
    } else 
    {
      $error_message = $res->get_error_message();
  
      error_log($error_message);
    }
  
    return false;
  }