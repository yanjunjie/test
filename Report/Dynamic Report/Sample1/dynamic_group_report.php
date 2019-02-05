<table>
    <thead>
    <tr>
        <th>#</th>
        <th>Fee Head</th>
        <th>Bill Amount</th>
        <th>Paid Amount</th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($pmt_head as $row) 
    {
        ?>
        <tr>
            <td colspan="4"><b><?php echo $row->YEAR_NAME; ?></b></td>
        </tr>
        <?php
        $slno = 0;
        foreach ($pmt_det as $row1) 
        {
            if ($row1->YEAR_MAP_ID == $row->YEAR_MAP_ID): ?>
                <tr>
                    <td><?php echo ++$slno; ?></td>
                    <td><?php echo $row1->ITEM_NAME; ?></td>
                    <td><?php echo $row1->BILL_AMT; ?></td>
                    <td><?php echo $row1->TOT_PRICE; ?></td>
                </tr>
            <?php endif;
        }
    }
    ?>
    </tbody>
</table>
