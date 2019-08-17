<?php
$content = file_get_contents("php://input");
$update = json_decode($content, true);

if(!$update)
{
  exit;
}

$message = isset($update['message']) ? $update['message'] : "";
$messageId = isset($message['message_id']) ? $message['message_id'] : "";
$chatId = isset($message['chat']['id']) ? $message['chat']['id'] : "";
$firstname = isset($message['chat']['first_name']) ? $message['chat']['first_name'] : "";
$lastname = isset($message['chat']['last_name']) ? $message['chat']['last_name'] : "";
$username = isset($message['chat']['username']) ? $message['chat']['username'] : "";
$date = isset($message['date']) ? $message['date'] : "";
$text = isset($message['text']) ? $message['text'] : "";

$text = trim($text);
$text = strtolower($text);
$output = $text;

if (strpos($text, "corvø") >= 0)
{
  $output = "dioporco";
}

else if (strpos($text, "cata") || $text == "cata")
{
  $output = "Cata sei un giullare macrogenitalico";
}

/*else
{
  exit;
}*/

header("Content-Type: application/json");
$parameters = array('chat_id' => $chatId, "text" => $output);
$parameters["method"] = "sendMessage";
echo json_encode($parameters);
