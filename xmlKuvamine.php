<?php
$opilased=simplexml_load_file("opilased.xml");
$feed=simplexml_load_file("https://www.err.ee/rss");
?>
<!DOCTYPE html>
<html>
<head>
	<title>XML faili kuvamine - Opilased.xml</title>
</head>
<body>
    <h1>XML faili kuvamine - Opilased.xml</h1>
    <?php
    //1. õpilase nimi
    echo "1. Õpilase nimi: ".$opilased->opilane[0]->nimi;
    ?>
<table>
    <tr>
        <th>Õpilase nimi</th>
        <th>Isikukood</th>
        <th>Eriala</th>
        <th>Elukoht</th>
        <?php
        foreach ($opilased->opilane as $opilane) {
        echo "<tr>";
        echo "<td>".$opilane->nimi."</td>";
        echo "<td>".$opilane->isikukood."</td>";
        echo "<td>".$opilane->eriala."</td>";
        echo "<td>".$opilane->elukoht->linn.", ".$opilane->elukoht->maakond."</td>";

        }
        ?>
    </tr>
</table>
<h1>RSS Uudiste lugemine</h1>
    <?php
    echo "<ul>";
    foreach ($feed->channel->item as $item) {
        echo "<li><a href='$item->link' target='_blank'>".$item->title."</a> ";
        echo $item->description;
        echo " Kuupäev:".$item->pubDate;
        echo "</li>";
    }
    echo "</ul>";
    ?>
</body>
</html>