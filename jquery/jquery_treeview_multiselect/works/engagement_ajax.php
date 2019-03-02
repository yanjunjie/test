<style>
    #myUL, #myUL ul {
        list-style-type: none;
    }
    #myUL {
        margin: 0;
        padding: 0;
    }
    .carett {
        cursor: pointer;
        -webkit-user-select: none; /* Safari 3.1+ */
        -moz-user-select: none; /* Firefox 2+ */
        -ms-user-select: none; /* IE 10+ */
        user-select: none;
    }
    .carett::before {
        /*content: "\25B6";*/
        content:"\2b";
        color: #171616;
        display: inline-block;
        margin-right: 15px;
    }
    .carett-down::before {
        /*-ms-transform: rotate(90deg); !* IE 9 *!
        -webkit-transform: rotate(90deg); !* Safari *!
         transform: rotate(90deg);*/
        content:"\2212";
    }
    .nested {
        display: none;
    }
    .active {
        display: block;
    }
    </style>
    <!--    <ul id="myUL">
            <li><span class="carett"><input type="checkbox">Beverages</span>
                <ul class="nested">
                    <li>Water</li>
                    <li>Coffee</li>
                    <li><span class="carett"><input type="checkbox">Tea</span>
                        <ul class="nested">
                            <li>Black Tea</li>
                            <li>White Tea</li>
                            <li><span class="carett"><input type="checkbox">Green Tea</span>
                                <ul class="nested">
                                    <li>Sencha</li>
                                    <li>Gyokuro</li>
                                    <li>Matcha</li>
                                    <li>Pi Lo Chun</li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
        </ul>-->
    <ul id="myUL">
        <?php
        foreach ($zone as $key => $value1) {
            $area = $this->db->query("select ADMIN_ID, CODE, NAME from bn_navyadminhierarchy where ADMIN_TYPE = 2 and PARENT_ID = $value1->ADMIN_ID")->result();
            ?>
            <li><span class="carett glyphicon"></span><input class="chkAll" style="margin-right: 5px;" type="checkbox"><?php echo '[' . $value1->CODE . ']' . $value1->NAME ?>
                <ul class="nested">
                    <?php
                    foreach ($area as $key => $value2) {
                        $ship = $this->db->query("select SHIP_ESTABLISHMENTID, CODE, NAME from bn_ship_establishment where AREA_ID = $value2->ADMIN_ID")->result();
                        ?>
                        <li><span class="carett glyphicon"></span><input class="chkAll" style="margin-right: 5px;" type="checkbox"><?php echo '[' . $value2->CODE . ']' . $value2->NAME ?>
                            <ul class="nested">
                                <?php foreach ($ship as $key => $value3) { ?>
                                    <li><input class="chk" style="margin-right: 5px;" type="checkbox"><?php echo '[' . $value3->CODE . ']' . $value3->NAME ?></li>
                                <?php } ?>
                            </ul>
                        </li>
                    <?php } ?>
                </ul>
            </li>
        <?php } ?>
    </ul>
