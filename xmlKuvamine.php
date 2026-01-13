<?php
$opilased=simplexml_load_file("opilased.xml");
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
</body>
</html>