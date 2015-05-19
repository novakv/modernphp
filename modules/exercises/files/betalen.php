<?php # Script 5.8 - betalen.php

/**
 * Dit is een afgeslankte pagina voor betalingen.
 * Dit voorbeeld accepteert en valideert alleen creditcardinformatie.
 * Er wordt aangenomen dat informatie (naam, adres, enzovoort)
 * na het inloggen wordt opgehaald uit de database
 * en ook wordt bevestigd op deze pagina.
 */

$dbc = mysqli_connect('localhost', 'winkel', 'brobbeltje', 'ecommerce') OR die("Cannot connect to database.");


// Voeg het header-bestand in:
$paginatitel = 'Betalen';
include_once('./includes/header.html');

echo '<h1>Betalen</h1>';

// Stel de tijdzone in:
date_default_timezone_set('GMT');

// Controleer of het formulier is verzonden:
if (isset($_POST['verzonden'])) {

    // Valideer de creditcard...

    // Controleer de vervaldatum:
    $jaar  = (int) $_POST['cc_vervaljaar'];
    $maand = (int) $_POST['cc_vervalmaand'];

    // Haal de huidige datum op:
    $vandaag = getdate();

    // Valideer de vervaldatum:
    if (($jaar > $vandaag['year']) OR (($jaar == $vandaag['year']) AND ($maand >= $vandaag['mon']))) {

        // Voeg de klassendefinitie in:
        require('Validate/Finance/CreditCard.php');

        // Maak het object:
        $cc = new Validate_Finance_CreditCard();

        // Valideer het kaartnummer en kaarttype:
        if ($cc->number($_POST['cc_nummer'], $_POST['cc_type'])) {

            // Gebruik XXX om de order te verwerken!!!
            // Voltooi de order als de betaling slaagt!
            echo '<p>Uw order en betaling zijn geaccepteerd (maar niet heus).</p>';
            include_once('./includes/footer.html');
            exit();

        } else { // Ongeldig kaartnummer of kaarttype.
            echo '<p class="fout">Controleer het creditcardnummer en kaarttype.</p>';
        }

    } else { // Ongeldige datum.
        echo '<p class="fout">Voer een geldige vervaldatum in.</p>';
    }

}

// Toon het formulier.
?>
<form action="betalen.php" method="post">
  <input type="hidden" name="verzonden" value="true" />
  <table border="0" width="90%" cellspacing="2" cellpadding="2" align="center">

    <tr>
      <td align="right">Type creditcard:</td>
      <td align="left"><select name="cc_type">
        <option value="amex">American Express</option>
        <option value="visa">Visa</option>
        <option value="mastercard">MasterCard</option>
        <option value="diners club">Diners Club</option>
        <option value="enroute">enRoute</option>
      </select></td>
    </tr>

    <tr>
      <td align="right">Creditcardnummer:</td>
      <td align="left"><input type="text" name="cc_nummer" maxlength="20" /></td>
    </tr>

    <tr> 
      <td align="right">Vervaldatum:</td>
      <td align="left"><select name="cc_vervalmaand">
        <option value="">Maand</option>
        <option value="1">Januari</option>
        <option value="2">Februari</option>
        <option value="3">Maart</option>
        <option value="4">April</option>
        <option value="5">Mei</option>
        <option value="6">Juni</option>
        <option value="7">Juli</option>
        <option value="8">Augustus</option>
        <option value="9">September</option>
        <option value="10">Oktober</option>
        <option value="11">November</option>
        <option value="12">December</option>
        </select> <select name="cc_vervaljaar">
        <option value="">Jaar</option>
        <?php
        for ($begin = date('Y'), $eind = date('Y') + 10; $begin < $eind; $begin++) {
            echo "<option value=\"$begin\">$begin</option>\n";
        }
        ?>
      </select></td>
    </tr>

    <tr>
      <td align="center" colspan="2"><button type="submit" name="submit" value="update">Betalen</button></td>
    </tr>

  </table>
</form>

<?php
// Voeg het footer-bestand in om de sjabloon te voltooien:
include_once('./includes/footer.html');

?>