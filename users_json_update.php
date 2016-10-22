<?php
//users_json_update
//Liest die UUID's aus der QuestProgress.json aus und erzeugt eine users.json 
//in der eine UUID mit ihrem Usernamen aufgelistet sind.
//M.Denzin
//04.10.2016

//function nickname()
//bekommt UUID in Langschreibweise XXXXXXXX-XXXX-XXXX-XXXX-XXXXXXXX
//sucht über Mojang API den akutellen Usernamen
//TODO: falsche UUID abfangen, Format der UUID prüfen
function nickname($uuid) {
	if (isset($uuid)) {
		$cuuid = str_replace("-","",$uuid);
		$json_response = file_get_contents("https://api.mojang.com/user/profiles/".$cuuid."/names");
		$data = json_decode($json_response, true);
		$nickname = $data[count($data)-1]['name'];
		return $nickname;
	}
	return FALSE;
}

//User UUID's aus QuestProgress.json auslesen
$questprogress = file_get_contents("QuestProgress.json");
$json_b = json_decode($questprogress, true);

//Leeres Array erstellen
$uuids = array();

foreach ($json_b['questProgress'] as $progress) {
	foreach ($progress['completed'] as $complusr) {
		//Prüfen ob UUID bereits als Key im Array $uuids vorhanden ist. Wenn nicht Array erweitern
		if (array_key_exists($complusr['uuid'], $uuids)) {
		}else{
			$uuids[$complusr['uuid']] = nickname($complusr['uuid']);
		}
}};

//Datei öffnen oder erstellen wenn nicht vorhanden
$file = fopen('users.json','c+') or die ("Kann Datei nicht öffnen $php_errormsg");
//Array im JSON Format in $file schreiben und Datei schließen
fwrite($file, json_encode($uuids));
fclose($file);

?>