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
$newchatId = isset($message['new_chat_member']['id']) ? $message['new_chat_member']['id'] : "";

$text = trim($text);
$text = strtolower($text);

$statusfile = fopen($chatId, "r");
$status = fread($statusfile, filesize($chatId));
fclose($statusfile);

if (strpos($status, "off") !== false)
{
  if ($text == "corvø svegliati")
  {    
    $statusfile = fopen($chatId, "w");
    fwrite($statusfile, "on");
    fclose($statusfile);
    
    $output = "Ecchime!";
  }
  
  else
    exit;
}

else
{
  $citazioni = array(
                    "Queste persone mi fanno salire un disgusto misto a disprezzo e violenza", 
                    "Penso che se dipendesse da me, li avrei eliminati pubblicamente dopo averli processati e condannati per stupidità",
                    "Spero che un giorno la giustizia universale cancelli tutte queste persone dalla faccia dell'universo",
                    "Cazzo in culo non fa figli, ma fa male se lo pigli!",
                    "Meglio 'n culo gelato che 'n gelato ar culo!",
                    "Ho pure visto le mutande di una tizia che stava là ad aspettare",
                    //"Te dó un pugno in culo che te scoppia la testa",
                    "Ma vieni a prendere sto giovane cazzone rampante!",
                    //"Kusokurae!",
                    "A me non dispiace schizzare dopo un po' di pausa, me la godo di più. Il punto è che sono avido di piacere e non ho la pazienza di aspettare",
                    //"Tu invece Cata hai le orecchie di Topolino, potresti lavorare a Disneyland",
                    "Meglio morto che col culo rotto",
                    "C'ha l'età che me se deve scopà",
                    "Ho un ficaio di sorca asiatica relativamente vicino",
                    "E io ci aggiungo anche che sembra esattamente quella che dovrebbe succhiarmelo fino a svuotarmi le palle, facendole diventare due sacche flosce",
                    "Se me metto sdraiato me fanno direttamente generale",
                    //"Oggi Cip e Ciop stanno facendo faville nella tua vuotissima scatola cranica",
                    "La mia fedeltà va solo all'impero",
                    "Io potrei usare il rostro sagomato con la testa di cazzo",
                    //"Cata ha sempre avuto un tipo di intelligenza piuttosto casuale, nel senso che a seconda del caso le sinapsi fanno contatto",
                    "Comunque sarei contento anche solo di avere il mio posto nell'Impero, senza esserne l'imperatore",
                    //"Per il giullare ci sei tu Cata, con quei coglioni enormi ti possiamo travestire da Topolino, basta che fai la verticale e il gioco è fatto",
                    "Io l'avrei fottuta selvaggiamente, anche perché ho le palle piene e la cappella rovente",
                    "Ma ora come ora, fotterei QUASI tutto",
                    "Avoja, sarebbe da colpirla sulle labbra con la cappella fino a che non schizzi",
                    "E poi ricorda sempre che non c'è persona che si merita il mio voto",
                    "Se mi metto sulla punta del cazzo, invece, posso toccarle lo scalpo con la punta del naso",
                    "Frappetta va posseduta come una cavalla",
                    "Quella per me con la figa te lo sbuccia come una banana",
                    "La abbordo a colpi di cazzo",
                    "È ora che scenda l'apocalisse per mondare la terra da questo schifo",
                    "Una donna del genere è come un oggetto vintage, piccole perle per intenditori",
                    "A Benny farei proprio piangere il culo",
                    "A me me piacerebbe proprio avé una bella cicatrice in faccia, proprio da bastardo!",
                    "Gli do un'accettata sulle gambe e poi gli piscio in testa a Filacchione",
                    "Sbuccia sta banana!",
                    "Scarta sto regalo!",
                    "C'è stato un momento che c'avevo proprio voglia de purgalla a Tersigni",
                    "Benny mi si avvicina, mi annusa il collo e mi fa: 'Che buon odore..'.\nLo vuoi sentì 'n odore? Eh? Lo vuoi sentì 'n odore? Mh? Lo vuoi sentì? Il merluzzo!",
                    "Sono una persona seria, mi fa schifo sta roba da drogati. Hai capito? Io sta merda non la fumo, porco dio. Sono una persona integra: non bevo, non fumo e non trombo neanche!",
                    //"Allo spaccio hanno le fettuccine alla crema di sorca e i bastoncini di merluzzo non sciacquato per la gente come Cata",
                    "Mi vado a lavare, che altrimenti esco con il merluzzo salato",
                    "C'era una che durante la giornata mi ha lanciato qualche occhiata: «Tiè, beccate sta carpa!»",
                    "Wassup nigga? Whatcha doin'? Whatcha gonna do with the cops nigga?",
                    //"Lo vedi questo dito? Ti sta dando un consiglio: vaffanculo prima che ti rompa il culo",
                    //"A Cata, c'hai 'no stuzzicadenti al posto del cazzo",
                    "Pesa è come quando scorreggi e ti caghi addosso, quando stai in giro e ti senti il pallocco nelle mutande ma non puoi levarlo",
                    "La trainer aveva i capezzoli che si intravedevano, questo mi ha privato di concentrazione e sangue",
                    "Fa du' sarti co' sto sofficino...du' sarti 'n padella...daje 'n morso che dentro c'ha pure il ripieno. Che voi de piú?",
                    "Lo sai con cosa sono fatte le cruschette?\nCon la merda di vacca, vedi come crusca quando si secca",
                    "C'ho 'na fame!",
                    "La vita senza fregna è come uno scarico intasato: inutile e piena di merda",
                    //"Cata, mi fai scopà Carlotta?",
                    "Quant'è bella la figa!",
                    //"Cagaratto",
                    "Un culo di quelli così belli che ci passeresti la fava nella fessura tipo carta di credito",
                    "La fica...DEVI CAPIRE!",
                    "Le farei una frittata nel culo",
                    //"Cata, te sei Reek",
                    "Se siamo arrivati al punto che la gente viene aggredita per strada a colpi di roncola, mi sa che è ora di armarsi",
                    //"Te sei cacato il cervello stamattina?",
                    //"Corvo 1 | Cata 0",
                    //"Ma sta' zitto Cata!",
                    "Cosa esce da un incrocio tra un negro e una piovra?\nNon lo so, ma sai quanto cazzo di cotone raccoglie?",
                    "Quanto la spaccherei!",
                    "Ma questo è un coglione!",
                    "Le frollerei l'utero",
                    "Ho smesso di giocare a Dark Souls perché ero talmente forte che i mostri dovevano andare a salvare la partita al falò",
                    //"Cata sei una pippa",
                    "Le romperei il culo a vergate",
                    "Il mio cazzo è come il successo, tutti lo desiderano, ma pochi lo ottengono",
                    //"Cata hai i piedi da clown",
                    "Le rimesterei l'intestino a cazzate",
                    "Quella mignotta di Flavia",
                    "Quella scabbiosa di Tersigni",
                    //"Cata non ti meriti di essere iscritto con quei piedi da clown",
                    //"A occhio de farco, alla prossima stronzata me te scopo Martina e j'arivorto er culo come 'n pedalino",
                    "È una bella fica che avrebbe bisogno di un po' di cazzo di Corvo",
                    //"Mo me arzo e te dò 'n cazzotto sui coglioni che te faccio diventà Topolino...te pijano a lavorà alla Disney",
                    "Quel cotechino di merda di Zappia",
                    "Quella balena di merda di Zappia te la tieni te",
                    "Guarda che bell'infuso di radici",
                    "È come partecipare ad un banchetto ma avere la bocca cucita",
                    "Io le preferisco basse, si impalano meglio",
                    //"Cata, non capisci proprio un cazzo!",
                    //"Cata, ma te stai a fa cresce la barba?",
                    "1 a 0 pe' la NASA!",
                    "Ma se trovo una rumena strafica e non zozza me la trombo uguale, perchè io, per la fica, vado al di là di queste cose",
                    "Trump è solo un cazzone",
                    //"Cata, io defeco sul tuo status di giullare macrogenitalico",
                    //"A Cata ma sto riso è scotto",
                    "In compenso ho attaccato bottone con una tizia a inizio lezione, ma poi si è spostata, dato che stavamo in piedi perché non c'era posto. Probabilmente si è resa conto che se avesse continuato, saremmo finiti a scopare e non sarebbe riuscita a seguire"
                    );
  
  $insulti_cata = array(
                       "Tu invece Cata hai le orecchie di Topolino, potresti lavorare a Disneyland",
                       "Cata ha sempre avuto un tipo di intelligenza piuttosto casuale, nel senso che a seconda del caso le sinapsi fanno contatto",
                       "Per il giullare ci sei tu Cata, con quei coglioni enormi ti possiamo travestire da Topolino, basta che fai la verticale e il gioco è fatto",
                       "Allo spaccio hanno le fettuccine alla crema di sorca e i bastoncini di merluzzo non sciacquato per la gente come Cata",
                       "A occhio de farco, alla prossima stronzata me te scopo Martina e j'arivorto er culo come 'n pedalino",
                       "A Cata, c'hai 'no stuzzicadenti al posto del cazzo",
                       "Cata, mi fai scopà Carlotta?",
                       "Cata, te sei Reek",
                       "Corvo 1 | Cata 0",
                       "Ma sta' zitto Cata!",
                       "Cata sei una pippa",
                       "Cata hai i piedi da clown",
                       "Cata non ti meriti di essere iscritto con quei piedi da clown",
                       "Cata, non capisci proprio un cazzo!",
                       "Cata, ma te stai a fa cresce la barba?",
                       "Cata, io defeco sul tuo status di giullare macrogenitalico",
                       "A Cata ma sto riso è scotto",
                       "Cagaratto"
                       );
  
  $insulti = array(
                  " te dó un pugno in culo che te scoppia la testa",
                  " kusokurae!",
                  " oggi Cip e Ciop stanno facendo faville nella tua vuotissima scatola cranica",
                  " lo vedi questo dito? Ti sta dando un consiglio: vaffanculo prima che ti rompa il culo",
                  " te sei cacato il cervello stamattina?",
                  " mo me arzo e te dò 'n cazzotto sui coglioni che te faccio diventà Topolino...te pijano a lavorà alla Disney"
                  );

  $index = array_rand($citazioni);
  $indc = array_rand($insulti_cata);
  $indi = array_rand($insulti);

  if (strpos($text, "corvø") !== false)
  {
    if (strpos($text, "citazione") !== false)
      $output = $citazioni[$index];

    else if (strpos($text, "dormi") !== false)
    {
      $statusfile = fopen($chatId, "w");
      fwrite($statusfile, "off");
      fclose($statusfile);
      
      $output = "Ve sallustio";
    }
    
    else if (strpos($text, "esegui") !== false)
      $output = scandir("/app");
    
    else if (strpos($text, "insulta cata") !== false)
      $output = $insulti_cata[$indc];
    
    else if (strpos($text, "insulta") !== false)
    {
      $nome = substr($text, 15);
      $nome = ucfirst($nome);
      $output = $nome.$insulti[$indi];
    }
    
    else if (strpos($text, "leggi") !== false)
    {
      $str = substr($text, 12);
      $str = trim($str);
      $statusfile = fopen($str, "r");
      $output = fread($statusfile, filesize($str));
      fclose($statusfile);
    }
    
    else
      $output = "Ma che cazzo stai a dì?";
  }

  else if (strpos($text, "cata") !== false)
  {
    $output = "Cata sei un giullare macrogenitalico";
  }

  /*else
  {
    exit;
  }*/
  
  if ($newchatId == "940235200")
    $output = "Dio bestia";
  else
    $output = $newchatId;
}

header("Content-Type: application/json");
$parameters = array('chat_id' => $chatId, "text" => $output);
$parameters["method"] = "sendMessage";
echo json_encode($parameters);
