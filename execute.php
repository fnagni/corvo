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

$citazioni = array("Queste persone mi fanno salire un disgusto misto a disprezzo e violenza", 
                   "Penso che se dipendesse da me, li avrei eliminati pubblicamente dopo averli processati e condannati per stupidità",
                   "Spero che un giorno la giustizia universale cancelli tutte queste persone dalla faccia dell'universo",
                   "Cazzo in culo non fa figli, ma fa male se lo pigli!",
                   "Meglio 'n culo gelato che 'n gelato ar culo!");

$index = array_rand($citazioni);

$text = trim($text);
$text = strtolower($text);

if (strpos($text, "corvø") !== false)
{
  if (strpos($text, "citazione") !== false)
    $output = $citazioni[$index];
}

else if (strpos($text, "cata") !== false)
{
  $output = "Cata sei un giullare macrogenitalico";
}

else
{
  exit;
}

header("Content-Type: application/json");
$parameters = array('chat_id' => $chatId, "text" => $output);
$parameters["method"] = "sendMessage";
echo json_encode($parameters);
