<html>
<head>
	<title></title>
<head>
<body>
<?php
$questdb = file_get_contents("QuestDatabase.json");
$json_a = json_decode($questdb, true);
$questprogress = file_get_contents("QuestProgress.json");
$json_b = json_decode($questprogress, true);
$userarray = file_get_contents("users.json");
$users = json_decode($userarray, true);
?>
<table class="table table-hover">
	<tr>
		<th>Questname</th>
		<th>Users complete</th>
		<th>Progress total</th>
	</tr>
<?php
foreach ($json_a['questLines'] as $questline) {
	echo "<tr><td colspan='3' align='center' class='info'><b>".$questline['name']."</b></td></tr>";
	foreach ($questline['quests'] as $questinline) {
		foreach ($json_a['questDatabase'] as $quest)  {
			if ($quest['questID'] == $questinline['id']){
				echo "<tr><td>".$quest['name']."</td>";
				foreach ($json_b['questProgress'] as $questpr) {
					if ($questpr['questID']==$quest['questID']) {
						echo "<td>";
						$i = 0;
						foreach ($questpr['completed'] as $complusr) {
							echo "<img src='skin.php?username=".$users[$complusr['uuid']]."' title='".$users[$complusr['uuid']]."'>";
							$i++;
						}
						echo "</td>";
					}
				}
				echo "<td><progress max='".count($users)."' value='".$i."'></progress></td></tr>";
			}
		}
	}
}
?>
</table>
<hr>
<body>