<?php
define("BOT_TOKEN", "940235200:AAGw5gzS4B_EpzzLlw58CSyJtqvZr1vcCRg");
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
$user_name = isset($message['chat']['username']) ? $message['chat']['username'] : "";
$title = isset($message['chat']['title']) ? $message['chat']['title'] : "";
$date = isset($message['date']) ? $message['date'] : "";
$text = isset($message['text']) ? $message['text'] : "";
$newchatId = isset($message['new_chat_member']['id']) ? $message['new_chat_member']['id'] : "";
$newchatFn = isset($message['new_chat_member']['first_name']) ? $message['new_chat_member']['first_name'] : "";
$leftchatId = isset($message['left_chat_member']['id']) ? $message['left_chat_member']['id'] : "";
$leftchatFn = isset($message['left_chat_member']['first_name']) ? $message['left_chat_member']['first_name'] : "";

$text = trim($text);
$text = strtolower($text);

$servername = "remotemysql.com:3306";
$username = "oDY1bXLIza";
$password = "2FiaQKJzNz";

$conn = new PDO("mysql:host=$servername;dbname=$username", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

foreach ($conn->query("SELECT val FROM accessi WHERE pk = ".$chatId) as $row)
{
  $status = $row['val'];
}

foreach ($conn->query("SELECT user FROM utenti WHERE pk = ".$chatId) as $row)
{
  $user = $row['user'];
}

if ($user == null)
{
  if ($chatId < 0)
    $insert = $conn->exec("INSERT INTO utenti (pk, user) VALUES ($chatId, '".$title."')");
  
  else
    $insert = $conn->exec("INSERT INTO utenti (pk, user) VALUES ($chatId, '".$user_name."')");
}

$conn = null;

if (strpos($status, "off") !== false)
{
  if ($text == "corvø svegliati")
  {    
    $conn = new PDO("mysql:host=$servername;dbname=$username", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $update = $conn->exec("UPDATE accessi SET val = 'on' WHERE pk = ".$chatId);
    
    $conn = null;
    
    $output = "Ecchime!";
  }
  
  else
    exit;
}

else
{
  if ($newchatId == "940235200")
    $output = "A chicchi, ecchime qua!";
  
  else if ($newchatId != null && $newchatId != "940235200")
    $output = "Benvenuto ".$newchatFn." vedi di comportarti bene o ti caco nelle scarpe";
  
  else if ($leftchatId != null)
    $output = "A ".$leftchatFn." ma 'ndo cazzo stai a annà?";
    
  else
  {
    $citazioni = array(
                      "Queste persone mi fanno salire un disgusto misto a disprezzo e violenza", 
                      "Penso che se dipendesse da me, li avrei eliminati pubblicamente dopo averli processati e condannati per stupidità",
                      "Spero che un giorno la giustizia universale cancelli tutte queste persone dalla faccia dell'universo",
                      "Cazzo in culo non fa figli, ma fa male se lo pigli!",
                      "Meglio 'n culo gelato che 'n gelato ar culo!",
                      "Ho pure visto le mutande di una tizia che stava là ad aspettare",
                      "Ma vieni a prendere sto giovane cazzone rampante!",
                      "A me non dispiace schizzare dopo un po' di pausa, me la godo di più. Il punto è che sono avido di piacere e non ho la pazienza di aspettare",
                      "Meglio morto che col culo rotto",
                      "C'ha l'età che me se deve scopà",
                      "Ho un ficaio di sorca asiatica relativamente vicino",
                      "So un po' di giorni che le palle mi girano come le pale di un elicottero",
                      "E io ci aggiungo anche che sembra esattamente quella che dovrebbe succhiarmelo fino a svuotarmi le palle, facendole diventare due sacche flosce",
                      "Se me metto sdraiato me fanno direttamente generale",
                      "La mia fedeltà va solo all'impero",
                      "Dio è lesso",
                      "Io potrei usare il rostro sagomato con la testa di cazzo",
                      "Comunque sarei contento anche solo di avere il mio posto nell'Impero, senza esserne l'imperatore",
                      "Io l'avrei fottuta selvaggiamente, anche perché ho le palle piene e la cappella rovente",
                      "Ma ora come ora, fotterei QUASI tutto",
                      "Avoja, sarebbe da colpirla sulle labbra con la cappella fino a che non schizzi",
                      "Te do il cazzo, altro che una mano. Una bella iniezione di conoscenza dell'italiano, un clistere o una sorta di lavanda gastrica",
                      "La polvere gliela levo dall'intestino quando la inculo con la forza di mille soli",
                      "Mi sa che è la volta buona che cerco di bucarla",
                      "Ma io sono carico di testosterone h24",
                      "Io provo pietà per quella che capiterà sotto il torchio dopo tutto questo calvario",
                      "Non c'ho na lira e non mi va di pagà per svuotarmi le palle, però mo mi cerco da scopare",
                      "Venerdì c'è un mio amico che suona in un locale, vediamo se riesco a rimediare qualche zozza che vuole chiavare",
                      "Mi sa che mi attacco al cazzo come Tarzan alla liana",
                      "Solo che mi viene voglia di scopare dopo l'allenamento, che sto carico e sfonderei pure un muro",
                      "Vabbè, io sturo un tubo dopo ogni allenamento",
                      "Porcoddio che voglia di sborrare",
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
                      "Mi vado a lavare, che altrimenti esco con il merluzzo salato",
                      "C'era una che durante la giornata mi ha lanciato qualche occhiata: «Tiè, beccate sta carpa!»",
                      "Wassup nigga? Whatcha doin'? Whatcha gonna do with the cops nigga?",
                      "Pesa è come quando scorreggi e ti caghi addosso, quando stai in giro e ti senti il pallocco nelle mutande ma non puoi levarlo",
                      "La trainer aveva i capezzoli che si intravedevano, questo mi ha privato di concentrazione e sangue",
                      "Fa du' sarti co' sto sofficino...du' sarti 'n padella...daje 'n morso che dentro c'ha pure il ripieno. Che voi de piú?",
                      "Lo sai con cosa sono fatte le cruschette?\nCon la merda di vacca, vedi come crusca quando si secca",
                      "C'ho 'na fame!",
                      "La vita senza fregna è come uno scarico intasato: inutile e piena di merda",
                      "Quant'è bella la figa!",
                      "Un culo di quelli così belli che ci passeresti la fava nella fessura tipo carta di credito",
                      "La fica...DEVI CAPIRE!",
                      "Le farei una frittata nel culo",
                      "Se siamo arrivati al punto che la gente viene aggredita per strada a colpi di roncola, mi sa che è ora di armarsi",
                      "Cosa esce da un incrocio tra un negro e una piovra?\nNon lo so, ma sai quanto cazzo di cotone raccoglie?",
                      "Quanto la spaccherei!",
                      "Ma questo è un coglione!",
                      "Le frollerei l'utero",
                      "Ho smesso di giocare a Dark Souls perché ero talmente forte che i mostri dovevano andare a salvare la partita al falò",
                      "Le romperei il culo a vergate",
                      "Il mio cazzo è come il successo, tutti lo desiderano, ma pochi lo ottengono",
                      "Le rimesterei l'intestino a cazzate",
                      "Quella mignotta di Flavia",
                      "Quella scabbiosa di Tersigni",
                      "È una bella fica che avrebbe bisogno di un po' di cazzo di Corvo",
                      "Quel cotechino di merda di Zappia",
                      "Quella balena di merda di Zappia te la tieni te",
                      "Guarda che bell'infuso di radici",
                      "È come partecipare ad un banchetto ma avere la bocca cucita",
                      "Io le preferisco basse, si impalano meglio",
                      "1 a 0 pe' la NASA!",
                      "Ma se trovo una rumena strafica e non zozza me la trombo uguale, perchè io, per la fica, vado al di là di queste cose",
                      "Trump è solo un cazzone",
                      "In compenso ho attaccato bottone con una tizia a inizio lezione, ma poi si è spostata, dato che stavamo in piedi perché non c'era posto. Probabilmente si è resa conto che se avesse continuato, saremmo finiti a scopare e non sarebbe riuscita a seguire",
                      "È anche una di quelle con la faccia un po' scazzata, che glielo infileresti in gola solo per rieducarla",
                      "Ma sì, sta lì che sembra che qualcuno le abbia cacato nella borsa. Aò, fallo un sorriso",
                      "Se, glielo faccio fare io un esercizio per la circolazione periferica. Del mio seme nel suo utero però",
                      "L'avrei proprio sbattuta al muro e scopata fino a farla svenire",
                      "Ma non tutte le scoperei con brutalità.\nAlcune in modo dolce, sussurrando loro all'orecchio come non si riusciranno a sedere quando avrò finito.\nAltre invece con la stessa delicatezza di un grizzly uscito dal letargo che trova una preda"
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
      if (strpos($text, "dormi") !== false)
      {
        if ($status == null)
        {
          $conn = new PDO("mysql:host=$servername;dbname=$username", $username, $password);
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          
          $insert = $conn->exec("INSERT INTO accessi (pk, val) VALUES ($chatId, 'off')");
          
          $conn = null;
        }
        
        else
        {
          $conn = new PDO("mysql:host=$servername;dbname=$username", $username, $password);
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          $update = $conn->exec("UPDATE accessi SET val = 'off' WHERE pk = ".$chatId);

          $conn = null;
        }
        
        $output = "Ve sallustio";
      }
      
      else if(strpos($text, "foto") !== false)
      {
        $images = glob('/app/foto/*');
        $path = $images[rand(0, count($images) - 1)];
        
        $botUrl = "https://api.telegram.org/bot" . BOT_TOKEN . "/sendPhoto";
        $postFields = array('chat_id' => $chatId, 'photo' => new CURLFile(realpath($path)));
        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type:multipart/form-data"));
        curl_setopt($ch, CURLOPT_URL, $botUrl); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
        
        curl_exec($ch);
        exit;
      }
      
      else if (strpos($text, "citazione") !== false)
        $output = $citazioni[$index];

      else if (strpos($text, "insulta cata") !== false)
        $output = $insulti_cata[$indc];

      else if (strpos($text, "insulta") !== false)
      {
        $nome = substr($text, 15);
        $nome = ucfirst($nome);
        $output = $nome.$insulti[$indi];
      }
      
      else if(strpos($text, "connetti") !== false)
      {
        try 
        {
          $conn = new PDO("mysql:host=$servername;dbname=$username", $username, $password);
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          
          $output = "Connessione eseguita";
        }
        
        catch(PDOException $e)
        {
          $output = "Connection failed: ".$e->getMessage();
        }
          
        $conn = null;
      }
      
      else
        $output = "Ma che cazzo stai a dì?";
    }

    else if (strpos($text, "cata") !== false)
    {
      $output = "Cata sei un giullare macrogenitalico";
    }

    else
      exit;
  }
}

header("Content-Type: application/json");
$parameters = array('chat_id' => $chatId, "text" => $output);
$parameters["method"] = "sendMessage";
echo json_encode($parameters);
