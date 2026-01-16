<?php
$opilased=simplexml_load_file("opilased.xml");

function opilaseSisestamine(){
    $xmlDoc = new DOMDocument("1.0","UTF-8");
    $xmlDoc->preserveWhiteSpace = false;
    $xmlDoc->load('opilased.xml');
    $xmlDoc->formatOutput = true;
    $xml_opilane = $xmlDoc->createElement("opilane");
    $xmlDoc->appendChild($xml_opilane);
    $xmlRoot = $xmlDoc->documentElement;
    $xmlRoot->appendChild($xml_opilane);
    $elukoht = $xmlDoc->createElement("elukoht");
    $xml_opilane->appendChild($elukoht);
    $aineA = $xmlDoc->createElement("aineA");
    $xml_opilane->appendChild($aineA);
    $aineB = $xmlDoc->createElement("aineB");
    $xml_opilane->appendChild($aineB);
    unset($_POST['submit']);
    foreach($_POST as $voti=>$vaartus){
        $kirje = $xmlDoc->createElement($voti,$vaartus);
        if($voti == "linn" || $voti == "maakond")
        {
            $elukoht->appendChild($kirje);
        } else
            if($voti == "nimiA" || $voti == "hinneA")
            {
                $aineA->appendChild($kirje);
            } else
                if($voti == "nimiB" || $voti == "hinneB")
                {
                    $aineB->appendChild($kirje);
                } else
        $xml_opilane->appendChild($kirje);
    }
    $xmlDoc->save('opilased.xml');
    header('Refresh:0');
}

function erialaOtsing($paring){
    global $opilased;
    $tulemus=array();
    foreach($opilased->opilane as $opilane){
        if(substr(strtolower($opilane->eriala), 0, strlen($paring))==strtolower($paring)){
            array_push($tulemus, $opilane);
        } else
            if(substr(strtolower($opilane->nimi), 0, strlen($paring))==strtolower($paring)){
                array_push($tulemus, $opilane);
            }
            else
                if(substr(strtolower($opilane->isikukood), 0, strlen($paring))==strtolower($paring)){
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
    <link rel="stylesheet" href="tableStyle.css">
</head>
<body>
    <h1>XML faili kuvamine - Opilased.xml</h1>
    <?php
    //1. õpilase nimi
    echo "1. Õpilase nimi: ".$opilased->opilane[0]->nimi;
    ?>

<form action="?" method="post">
    <label for="otsing">Otsi:</label>
    <input type="text" name="otsing" id="otsing" placeholder="Eriala | Nimi | Isikukood">
    <input type="submit" value="Otsi">
</form>
<?php
//otsingu tulemus
if(!empty($_POST["otsing"])){
    $tulemus = erialaOtsing($_POST["otsing"]);
    echo "<table>
                <tr>
                    <th>Õpilase nimi</th>
                    <th>Isikukood</th>
                    <th>Eriala</th>
                    <th>Ained</th>
                    <th>Elukoht</th>
                </tr>";
    foreach ($tulemus as $opilane) {
        echo "<tr>";
        echo "<td>".$opilane->nimi."</td>";
        echo "<td>".$opilane->isikukood."</td>";
        echo "<td>".$opilane->eriala."</td>";
        echo "<td>";
            if($opilane->ained->count()>0){
                foreach ($opilane->ained->aine as $aine)
                {
                    echo $aine->nimi.", ".$aine->hinne."<br>";
                }
            }
        echo "</td>";
        echo "<td>".$opilane->elukoht->linn.", ".$opilane->elukoht->maakond."</td>";
        echo "<td><img src='".$opilane->pilt."' alt='Pilt'/></td>";
        echo "</tr>";
    }
    echo "</table>";
}
        else {

?>
<table>
    <tr>
        <th>Õpilase nimi</th>
        <th>Isikukood</th>
        <th>Eriala</th>
        <th>Ained</th>
        <th>Elukoht</th>
    </tr>
        <?php
        foreach ($opilased->opilane as $opilane) {
        echo "<tr>";
        echo "<td>".$opilane->nimi."</td>";
        echo "<td>".$opilane->isikukood."</td>";
        echo "<td>".$opilane->eriala."</td>";
        echo "<td>";
            if($opilane->ained->count()>0){
                foreach ($opilane->ained->aine as $aine)
                {
                    echo $aine->nimi.", ".$aine->hinne."<br>";
                }
            }
            echo "</td>";
        echo "<td>".$opilane->elukoht->linn.", ".$opilane->elukoht->maakond."</td>";
        echo "<td><img src='".$opilane->pilt."' alt='Pilt'/></td>";
        echo "</tr>";
        }
        }
        ?>

</table>
    <h2>Õpilase sisestamine</h2>
    <table id="sisesta">
        <form action="" method="post" name="vorm1">
            <tr>
                <td><label for="nimi">Nimi:</label></td>
                <td><input type="text" name="nimi" id="nimi" autofocus></td>
            </tr>
            <tr>
                <td><label for="isikukood">Isikukood:</label></td>
                <td><input type="text" name="isikukood" id="isikukood"></td>
            </tr>
            <tr>
                <td><label for="eriala">Eriala:</label></td>
                <td><input type="text" name="eriala" id="eriala"></td>
            </tr>
            <tr>
                <td><label for="linn">Linn:</label></td>
                <td><input type="text" name="linn" id="linn"></td>
            </tr>
            <tr>
                <td><label for="maakond">Maakond:</label></td>
                <td><input type="text" name="maakond" id="maakond"></td>
            </tr>
            <tr>
                <td><label for="nimiA">Aine A:</label></td>
                <td><input type="text" name="nimiA" id="nimiA"></td>
            </tr>
            <tr>
                <td><label for="hinneA">Hinne A:</label></td>
                <td><input type="text" name="hinneA" id="hinneA"></td>
            </tr>
            <tr>
                <td><label for="nimiB">Aine B:</label></td>
                <td><input type="text" name="nimiB" id="nimiB"></td>
            </tr>
            <tr>
                <td><label for="hinneB">Hinne B:</label></td>
                <td><input type="text" name="hinneB" id="hinneB"></td>
            </tr>
            <tr>
                <td><label for="pilt">Pilt:</label></td>
                <td><input type="text" name="pilt" id="pilt"></td>
            </tr>
            <tr>
                <td><input type="submit" name="submit" id="submit" value="Sisesta"></td>
                <td></td>
            </tr>
        </form>
    </table>
    <?php
    if(isset($_POST['submit'])){
        opilaseSisestamine();
        echo "Opilane lisatud!";
    }
    ?>
</body>
</html>