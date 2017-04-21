<?php

require "twitteroauth/autoload.php";
use Abraham\TwitterOAuth\TwitterOAuth;

define('CONSUMER_KEY', 'zgx2JKFtQe8OxiLNQgCxngawr');
define('CONSUMER_SECRET', 'SRdRdobvB909hUiPAWM16sVkP146VHyTjJ1TAHFwtycZEwXNCT');
define('ACCESS_TOKEN', '855621330-b8PonDQvpE10oPBk8jPKXOx9DIaKFwRQeoZGFoho');
define('ACCESS_TOKEN_SECRET', 'oPJ5DSpCTnFWFk4yeKqraC0xzfL7uG0KiacveRTn8HkLp');

$query = array(
  "q" => "%23" . $_POST['hashtag'] . " -RT",
  "count" => $_POST['num'],
  "result_type" => $_POST['searchBy']
);

$results = search($query);

$text = '';
foreach ($results->statuses as $result) {
    $text .= $result->text;
}

$key = "Authorization: Basic ";
$value = "Y2ZmN2IwODEtN2RjNS00YzMyLWJkYjctMjVmMDIxMGQ1OWZmOjBWMXlLaGZzWmRSMQ==";
$url = "https://watson-api-explorer.mybluemix.net/tone-analyzer/api/v3/tone?version=2016-05-19";
$data = array('text' => $text);
$ch = curl_init( $url );
$payload = json_encode( $data );
curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json', $key . $value));
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
$result = (array) json_decode( curl_exec($ch) , true);
foreach ($results->statuses as $tweet) {
    $result['document_tone']['tone_categories'][3]['tweets'][] = $tweet->text;
}
echo json_encode($result['document_tone']['tone_categories']);

function search(array $query)
{
    $toa = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);
    return $toa->get('search/tweets', $query);
}
?>