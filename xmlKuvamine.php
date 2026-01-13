<?php
$opilased=simplexml_load_file("opilased.xml");

function erialaOtsing($paring){
    global $opilased;
    $tulemus=array();
    foreach($opilased->opilane as $opilane){
        if(substr(strtolower($opilane->eriala), 0, strlen($paring))==strtolower($paring)){
            array_push($tulemus, $opilane);
        }
    }
    return $tulemus;
}
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

<form action="?" method="post">
    <label for="otsing">Eriala:</label>
    <input type="text" name="otsing" id="otsing">
    <input type="submit" value="Otsi">
</form>
<?php
//otsingu tulemus
if(!empty($_POST["otsing"])){
    $tulemus = erialaOtsing($_POST["otsing"]);
    foreach($tulemus as $opilane){
        echo $opilane->nimi." - ";
        echo $opilane->eriala."<br>";
    }
}
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