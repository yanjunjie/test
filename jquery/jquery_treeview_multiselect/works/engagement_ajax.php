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
        content:"\2b";
        color: #171616;
        display: inline-block;
        margin-right: 15px;
    }
    .carett-down::before {
        content:"\2212";
    }
    .nested {
        display: none;
    }
    .active {
        display: block;
    }
    </style>

    <ul id="myUL">
        <?php
        foreach ($zone as $key => $value1) {
            $area = $this->db->query("select ADMIN_ID, CODE, NAME from bn_navyadminhierarchy where ADMIN_TYPE = 2 and PARENT_ID = $value1->ADMIN_ID")->result();
            ?>
            <li><span class="carett glyphicon"></span><input class="chkAll" style="margin-right: 5px;" type="checkbox"><?php echo '[' . $value1->CODE . ']' . $value1->NAME ?>
                <ul class="nested">
                    <?php
                    foreach ($area as $key2 => $value2) {
                        $ship = $this->db->query("select SHIP_ESTABLISHMENTID, CODE, NAME from bn_ship_establishment where AREA_ID = $value2->ADMIN_ID")->result();
                        ?>
                        <li><span class="carett glyphicon"></span><input class="chkAll" style="margin-right: 5px;" type="checkbox"><?php echo '[' . $value2->CODE . ']' . $value2->NAME ?>
                            <ul class="nested">
                                <?php foreach ($ship as $key3 => $value3) { ?>
                                    <li><input style="margin-right: 5px;" name="ship_ids" type="checkbox" value="<?php echo $value3->SHIP_ESTABLISHMENTID; ?>"><?php echo '[' . $value3->CODE . ']' . $value3->NAME ?></li>
                                <?php } ?>
                            </ul>
                        </li>
                    <?php } ?>
                </ul>
            </li>
        <?php } ?>
    </ul>

<script>
    // Tree View
    let toggler = document.getElementsByClassName("carett");
    for (let i = 0; i < toggler.length; i++) {
        toggler[i].addEventListener("click", function() {
            this.parentElement.querySelector(".nested").classList.toggle("active");
            this.classList.toggle("carett-down");
        });
    }
</script>