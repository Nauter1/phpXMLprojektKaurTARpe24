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
    $ained = $xmlDoc->createElement("ained");
    $xml_opilane->appendChild($ained);
    unset($_POST['submit']);
    foreach($_POST as $voti=>$vaartus){
        $kirje = $xmlDoc->createElement($voti,$vaartus);
        if($voti == "linn" || $voti == "maakond")
        {
            $elukoht->appendChild($kirje);
        }
        else
            if($voti == "oppeaine1")
            {
                $aine = $xmlDoc->createElement("aine");
                $aine->appendChild($xmlDoc->createElement("nimi", $vaartus));
                $ained->appendChild($aine);
            }
            else
                if($voti == "oppeaine1hinne1")
                {
                    $aine->appendChild($xmlDoc->createElement("hinne", $vaartus));
                    $ained->appendChild($aine);
                }
                else
                    if($voti == "oppeaine2")
                    {
                        $aine = $xmlDoc->createElement("aine");
                        $aine->appendChild($xmlDoc->createElement("nimi", $vaartus));
                        $ained->appendChild($aine);
                    }
                    else
                        if($voti == "oppeaine2hinne2")
                        {
                            $aine->appendChild($xmlDoc->createElement("hinne", $vaartus));
                            $ained->appendChild($aine);
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
                foreach($opilane->ained->aine as $aine)
                    if(substr(strtolower($aine->nimi), 0, strlen($paring))==strtolower($paring)){
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
    <input type="text" name="otsing" id="otsing" placeholder="Eriala | Nimi | Isikukood | Aine">
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
                <td><label for="nimiA">Aine A:</label>
                <input type="text" name="oppeaine1" id="nimiA"></td>
                <td><label for="hinneA">Hinne A:</label>
                <input type="number" min="1" max="5" name="oppeaine1hinne1" id="hinneA"></td>
            </tr>
            <tr>

            </tr>
            <tr>
                <td><label for="nimiA">Aine B:</label>
                    <input type="text" name="oppeaine2" id="nimiA"></td>
                <td><label for="hinneA">Hinne B:</label>
                    <input type="number" min="1" max="5" name="oppeaine2hinne2" id="hinneA"></td>
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