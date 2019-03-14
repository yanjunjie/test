<ul id="myUL">
    <?php
    foreach ($branch as $key => $value1) {
        $rank = $this->db->query("select RANK_CODE, RANK_ID, RANK_NAME from bn_rank where ACTIVE_STATUS = 1 and BRANCH_ID = $value1->BRANCH_ID $equRankIds")->result();
        ?>
        <li><span class="carett glyphicon"></span><input class="chkAll" style="margin-right: 5px;" type="checkbox"><?php echo '[' . $value1->BRANCH_CODE . '] ' . $value1->BRANCH_NAME ?>
            <ul class="nested">
                <?php foreach ($rank as $key2 => $value2) { ?>
                    <li><input style="margin-right: 5px;" name="ship_ids" type="checkbox" value="<?php echo $value2->RANK_ID; ?>"><?php echo '[' . $value2->RANK_CODE . '] ' . $value2->RANK_NAME ?></li>
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