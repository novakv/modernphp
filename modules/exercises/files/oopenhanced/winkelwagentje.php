<?php

$dbc = mysqli_connect('localhost', 'winkel', 'brobbeltje', 'ecommerce') OR die("Cannot connect to database.");

// Voeg het header-bestand in:
$paginatitel = 'Winkelwagentje';
include_once('./includes/header.html');

echo '<h1>Overzicht van uw winkelwagentje</h1>';

// Maak het winkelwagentje:
//require_once('WidgetWinkelwagentje.php');
require 'vendor/autoload.php';

//use Ullman\PHPGevorderden;

if (isset($_SESSION['winkelwagentje'])) {
    $winkelwagentje = unserialize($_SESSION['winkelwagentje']);
} else {
    //$winkelwagentje = new WidgetWinkelwagentje();
    $winkelwagentje = new \Ullman\PHPGevorderden\WidgetWinkelwagentje();
}

// Deze pagina voegt items toe of werkt het winkelwagentje bij
// op basis van de waarde van $_REQUEST['actie']:
if (isset($_REQUEST['actie']) && ($_REQUEST['actie'] == 'toevoegen')) { // Nieuw item toevoegen.

    // Controleer op een product-ID:
    if (isset($_GET['specifieke_widgets_id'])) {

        // Typecast naar een integer:
        $specifieke_widgets_id = (int)$_GET['specifieke_widgets_id'];

        // Haal de iteminformatie op
        // als de integer positief is:
        if ($specifieke_widgets_id > 0) {

            // Definieer de query en voer hem uit:
            $q = "SELECT naam, kleur, maat, standaardprijs, prijs FROM algemene_widgets LEFT JOIN specifieke_widgets USING (algemene_widgets_id) LEFT JOIN kleuren USING (kleur_id) LEFT JOIN maten USING (maat_id) WHERE specifieke_widgets_id=$specifieke_widgets_id";
            $r = mysqli_query($dbc, $q);

            if (mysqli_num_rows($r) == 1) {

                // Haal de informatie op:
                $rij = mysqli_fetch_array($r, MYSQLI_ASSOC);

                // Bepaal de prijs:
                $prijs = (empty($rij['prijs'])) ? $rij['standaardprijs'] : $rij['prijs'];

                // Origineel Voeg toe aan het winkelwagentje:
                //$winkelwagentje->item_toevoegen($specifieke_widgets_id, array('naam' => $rij['naam'], 'kleur' => $rij['kleur'], 'maat' => $rij['maat'], 'prijs' => $prijs));

                // Verbeterd Voeg toe aan het winkelwagentje:
                $widget = new \Ullman\PHPGevorderden\Item($specifieke_widgets_id, $rij['naam'], $rij['kleur'], $rij['maat'], $prijs);
                
                $winkelwagentje->item_toevoegen($widget);

            } // Einde van IF met mysqli_num_rows().

        } // Einde van IF met ($specifieke_widgets_id > 0).

    } // Einde van IF met isset($_GET['specifieke_widgets_id']).

} elseif (isset($_REQUEST['actie']) && ($_REQUEST['actie'] == 'bijwerken')) {

    // Verander alle aantallen.
    // $sleutel is de product-ID.
    // $waarde is de nieuwe hoeveelheid.
    foreach ($_POST['aantal'] as $sleutel => $waarde) {

        // Moeten integers zijn!
        $pid    = (int) $sleutel;
        $aantal = (int) $waarde;

        echo '<pre>Bla';
        print_r($winkelwagentje->getItem($pid));
        echo '</pre>';

        $winkelwagentje->item_bijwerken($winkelwagentje->getItem($pid), $aantal);

        /*
        $q = "SELECT naam, kleur, maat, standaardprijs, prijs FROM algemene_widgets LEFT JOIN specifieke_widgets USING (algemene_widgets_id) LEFT JOIN kleuren USING (kleur_id) LEFT JOIN maten USING (maat_id) WHERE specifieke_widgets_id=$pid";
        $r = mysqli_query($dbc, $q);

        if (mysqli_num_rows($r) == 1) {

            $rij = mysqli_fetch_array($r, MYSQLI_ASSOC);

                $prijs = (empty($rij['prijs'])) ? $rij['standaardprijs'] : $rij['prijs'];

                $widget = new \Ullman\PHPGevorderden\Item($pid, $rij['naam'], $rij['kleur'], $rij['maat'], $prijs);
    
                //$winkelwagentje->item_bijwerken($pid, $aantal); //original
                $winkelwagentje->item_bijwerken($widget, $aantal);
        }
        */

    } // Einde van FOREACH.

    // Geef een bericht weer:
    echo '<p>Uw winkelwagentje is bijgewerkt.</p>';

} // Einde van IF-ELSEIF voor $_REQUEST.

// Toon het winkelwagentje als het niet leeg is:
if (!$winkelwagentje->is_leeg()) {
    $winkelwagentje->wagentje_weergeven('winkelwagentje.php');
} else {
    echo '<p>Uw winkelwagentje is nu leeg.</p>';
}

// Sla het winkelwagentje op in de sessie:
$_SESSION['winkelwagentje'] = serialize($winkelwagentje);

// Voeg het footer-bestand in om de sjabloon te voltooien:
include_once('./includes/footer.html');

?>