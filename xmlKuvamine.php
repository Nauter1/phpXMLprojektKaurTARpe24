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
</body>
</html>