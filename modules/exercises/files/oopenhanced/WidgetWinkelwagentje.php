<?php

namespace Ullman\PHPGevorderden;

//new to implement interfaces
//class WidgetWinkelwagentje implements \Iterator
class WidgetWinkelwagentje
{

    protected $items = array();

    protected $position = 0; //new

    protected $ids = array(); //new

    public function getItem($pid)
    {
        return $this->items[$pid]['item'];
    }

    //new version is compacter
    public function is_leeg()
    {
        return (empty($this->items));
    }

    //public function item_toevoegen($id, $info) //original version
    public function item_toevoegen(Item $item) // Item, __construct($id, $naam, $prijs)
    {
        //start new piece of code
        $id = $item->getId();
        if (!$id) throw new \Exception("Error Processing Request", 1);
        //end new piece of code

        if (isset($this->items[$id])) {

            $this->item_bijwerken($id, $this->items[$id]['aantal'] + 1);

        } else {

            /* original
            $this->items[$id] = $info; //$info = array('naam'=> $naam, 'kleur'=> $kleur, 'maat'= $maat, 'prijs' => $prijs);
            $this->items[$id]['aantal'] = 1;
            */
            $this->items[$id] = array('item' => $item, 'aantal' => 1); //replacement for the above original
            
            /*print_r($this->items[$id]);

            Array
            (
                [item] => Ullman\PHPGevorderden\Item Object
                    (
                        [id] => 13
                        [naam] => Wiebel Widget 2
                        [kleur] => Steengrijs
                        [maat] => Gigantisch
                        [prijs] => 200.99
                    )

                [aantal] => 1
            )
            */
            echo "<p>De widget '{$item->getNaam()}' in de kleur {$item->getKleur()} en de maat {$item->getMaat()} is toegevoegd aan uw winkelwagentje.</p>\n";
            $this->ids[] = $id; //new, use new @var $ids
        }

    }

    //public function item_bijwerken($id, $aantal) //original version
    public function item_bijwerken(Item $item, $aantal)
    {

        $id = $item->getId(); //new, before we were passing $id directly, now we getting it this way

        //if ($aantal == 0) {
        if ($aantal === 0) {

            //$this->item_verwijderen($id);  //original
            $this->item_verwijderen($item);

        } elseif (($aantal > 0) && ($aantal != $this->items[$id]['aantal'])) {

            $this->items[$id]['aantal'] = $aantal;

            echo "<p>U hebt nu $aantal widget(s) '{$item->getNaam()}' in de kleur {$item->getKleur()} en de maat {$item->getMaat()} in uw winkelwagentje.</p>\n";

        }

    }

    //public function item_verwijderen($id) //original
    public function item_verwijderen(Item $item)
    {

        $id = $item->getId();  //new, see note at item_bijwerken

        if (isset($this->items[$id])) {

            echo "<p>De widget '{$item->getNaam()}' in de kleur {$item->getKleur()} en de maat {$item->getMaat()} is verwijderd uit uw winkelwagentje.</p>\n";

            unset($this->items[$id]);

            /*
            //New: after deleting the item from the items array, the ID value must be removed from $ids. This is a two-step process: find the corresponding index for that ID value, then unset that element
            $index = array_search($id, $this->ids);
            unset($this->ids[$index]);
            //Above act may leave a hole in the array, which would cause problems during iterations, as already mentioned. The solution is to recreate the array using the array’s remaining values:
            $this->ids = array_values($this->ids);
            //end New
            */

        }

    }

    // Methode die het winkelwagentje weergeeft.
    // Accepteert één argument: de waarde $actie voor een formulier.
    public function wagentje_weergeven($actie = FALSE)
    {

        // Geef een tabel weer:
        echo '<table border="0" width="90%" cellspacing="2" cellpadding="2" align="center">
                <tr>
                  <th align="left" width="20%">Widget</th>
                  <th align="left" width="15%">Maat</th>
                  <th align="left" width="15%">Kleur</th>
                  <th align="right" width="15%">Prijs</th>
                  <th align="center" width="10%">Aantal</th>
                  <th align="right" width="15%">Bedrag</th>
                </tr>
             ';

        // Toon de formuliercode, indien nodig.
        if ($actie) {
            echo '<form action="' . $actie . '" method="post">
                  <input type="hidden" name="actie" value="bijwerken" />
                 ';
        }

        // Initialiseer het totaal:
        $totaal = 0;

        // Maak een lus door alle items:
        echo '<pre>';
        print_r($this->items);
        echo '</pre>';
        /*
            (
                [13] => Array
                    (
                        [item] => Ullman\PHPGevorderden\Item Object
                            (
                                [id] => 13
                                [naam] => Wiebel Widget 2
                                [kleur] => Steengrijs
                                [maat] => Gigantisch
                                [prijs] => 200.99
                            )

                        [aantal] => 1
                    )

            )
        */
        foreach ($this->items as $arr) {

            $item = $arr['item'];
            echo '<pre>';
            print_r($item);
            echo '</pre>';
            /*
            Ullman\PHPGevorderden\Item Object
            (
                [id] => 13
                [naam] => Wiebel Widget 2
                [kleur] => Steengrijs
                [maat] => Gigantisch
                [prijs] => 200.99
            )
            */
            $komada = $arr['aantal'];
            //print_r($komada);
            // Bereken het totaal en de subtotalen:  
            //$subtotaal = $info['aantal'] * $info['prijs'];  //original
            $subtotaal = $komada * $item->getPrijs();
            $totaal += $subtotaal;
            $subtotaal = number_format($subtotaal, 2);

            // Bepaal hoe de hoeveelheid wordt weergegeven:
            //$aantal = ($actie) ? "<input type=\"text\" size=\"3\" name=\"aantal[$id]\" value=\"{$info['aantal']}\" />" : $info['aantal'];
            $aantal = ($actie) ? "<input type=\"text\" size=\"3\" name=\"aantal[{$item->getId()}]\" value=\"{$komada}\" />" : $komada;

            echo <<<EOT
<tr>
  <td align="left">{$item->getNaam()}</td>
  <td align="left">{$item->getMaat()}</td>
  <td align="left">{$item->getKleur()}</td>
  <td align="right">&euro;&nbsp;{$item->getPrijs()}</td>
  <td align="center">$aantal</td>
  <td align="right">&euro;&nbsp;$subtotaal</td>
</tr>\n
EOT;

        } // Einde van de lus FOREACH.

        // Voltooi de tabel:
        echo '<tr>
                <td colspan="5" align="right"><strong>Totaal:</strong></td>
                <td align="right">&euro;&nbsp;' . number_format($totaal, 2) . '</td>
              </tr>';

        // Voltooi het formulier, indien nodig:
        if ($actie) {
            echo '<tr>
                    <td colspan="6" align="center">Stel het aantal in op 0 als u een item wilt verwijderen uit het winkelwagentje.</td>
                  </tr>
                  <tr>
                    <td colspan="6" align="center"><input type="submit" name="submit" value="Winkelwagentje bijwerken" /></td>
                  </tr>
                  </form>';
        }

        echo '</table>';

    } // Einde van de methode wagentje_weergeven().

/*
    public function current() {
        $index = $this->ids[$this->position];
        return $this->items[$index];
    }
    public function key() {
        return $this->position;
    }
    public function next() {
        $this->position++;
    }
    public function rewind() {
        $this->position = 0;
    }
    public function valid() {
        return (isset($this->ids[$this->position]));
    }
*/
} // Einde van de klasse WidgetWinkelwagentje.

?>