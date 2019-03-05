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

    <div class="col-md-12">
        <div class="col-md-4 text-right">Equivalent Rank</div>
        <div class="col-md-8">
            <div class="form-group">
                <div class="col-md-8" style="padding: 0;">
                    <select class="selectpicker form-control" multiple data-actions-box="true" name="TREE_EQU_RANKID[]" id="TREE_EQU_RANKID" data-width="175px" data-tags="true" data-placeholder="Select Rank"
                            data-allow-clear="true">
                        <?php foreach ($equivalent_rank as $value): ?>
                            <option value="<?php echo $value->EQUIVALANT_RANKID ?>"><?php echo $value->RANK_NAME; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button style="margin-top: 5px;" type="button" class="btn btn-info btn-xs equiRefresh" title="Refresh By Equivalent Rank" data-action="<?php echo base_url('common/treeEquRank')?>">
                    Refresh
                </button>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    <br>

   <div id="treeArea">
       <ul id="myUL">
           <?php
           foreach ($branch as $key => $value1) {
               $rank = $this->db->query("select RANK_CODE, RANK_ID, RANK_NAME from bn_rank where ACTIVE_STATUS = 1 and BRANCH_ID = $value1->BRANCH_ID")->result();
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
   </div>

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