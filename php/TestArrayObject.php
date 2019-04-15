<?php
class TestArrayObject extends ArrayObject {
    public function displayAsTable() {
        $iterator = $this->getIterator();
        // Table
        echo '<table border="1">';
        echo '<tr>';
        echo '<th>Keys</th><th>Values</th>';
        echo '</tr>';
        while ($iterator->valid()) {
            echo '<tr>';
            echo '<td>'.$iterator->key().'</td><td>'.$iterator->current().'</td>';
            echo '</tr>';
            $iterator->next();
        }
        echo '</table>';
    }
}

$arrFruits = array('Apple','Banana', 'Mango','Breadfruit');
$objArr = new TestArrayObject($arrFruits);
$objArr->append('Papaya');
$objArr->displayAsTable();