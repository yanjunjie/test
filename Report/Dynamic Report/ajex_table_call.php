<div class="text-right">
    <button style="margin-bottom: 5px;" type="button" class="btn btn-info btn-xs print">Print</button>
    <div class="clearfix"></div>
</div>
<div id="printablediv">
    <style type="text/css">
        @media print,screen {
            body {
                font-size: 12pt;
                font-family: Arial, Helvetica, sans-serif;
            }

            h1,h2,h3,h4,h5,h6 {
                page-break-after: avoid;
                page-break-before: always;
            }

            p {page-break-inside: avoid;}

            table {
                font-family: Arial, sans-serif;
                font-size: 13px;
                border-collapse: collapse;
                width: 100%;
                border-spacing: 0;
            }

            .table td, table th {
                border: 1px solid black;
            }

            /* header style*/
            .header-area{
                display: block;
                width: 100%;
                margin-bottom: 25px;
            }
            .header-left {
                text-align: left;
            }
            .header-right {
                text-align: right;
            }
            .header-middle {
                text-align: center;
            }
            .title-group {
                line-height: 1.2;
                text-align: center;
                text-transform: uppercase;
            }
            .main-title {
                font-size: 17px;
                font-weight: bold;
                margin: 0;
            }
            .sub-title {
                font-size: 15px;
                font-weight: normal;
                margin: 0;
            }
            /* end header style*/
        }

        @media print {
            html, body {
                box-shadow: none;
                width: 210mm;
                height: 297mm;
            }

            .page[size="A4"][layout="portrait"] {
                width: 8.5in;
                height: 11in;
                padding: .5in 16mm 16mm 16mm;
                @page {
                    size: A4;
                    margin: 0;
                };
            }
            .page[size="A4"][layout="landscape"] {
                width: 11in;
                height: 8.5in;
                padding: .5in 16mm 16mm 16mm;
                @page {
                    size: A4;
                    margin: 0;
                };
            }
        }
    </style>
    <?php 
        $partII = array();
        $partII['GI'] = 'GI';
        $partII['FC'] = 'FC';
        $partII['GA'] = 'GA';
        $partII['QA'] = 'QA';
        $partII['SGC/SGQ'] = 'SGC/SGQ';
        $partII['ND'] = 'ND';
        $partII['TD'] = 'TD';
        $partII['PT'] = 'PT';
        $partII['CD'] = 'CD';
        $partII['NCT'] = 'NCT';
        $partII['SR'] = 'SR';
        $partII['OTHERS'] = 'OTHERS';
    ?>
    <div class="page" size="A4" layout="portrait">
        <table class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <td rowspan="2">SHIP</td>
                    <td rowspan="2" style="text-align: left;">RANK</td>
                    <?php 
                    if(in_array(1, $branchName)){
                        foreach ($partII as $key => $value0) { ?>
                            <td colspan="2"><?php echo $value0?></td>
                        <?php } 
                      }
                    foreach ($branch as $key => $value1) { ?>
                        <td colspan="2" style="text-align: left;"><?php echo $value1->BRANCH_NAME ?></td>
                    <?php } ?>
                    <td colspan="2" style="text-align: left;">TOTAL</td>
                </tr>
                <tr>
                    <?php 
                    if(in_array(1, $branchName)){
                        foreach ($partII as $key => $value0) { ?>
                            <td>S</td>
                            <td>B</td>
                        <?php }
                        }
                    foreach ($branch as $key => $value2) { ?>
                        <td>S</td>
                        <td>B</td>
                    <?php } ?>
                    <td>S</td>
                    <td>B</td>
                </tr>
            </thead>
            <tbody>
                <?php
                $Total_s_gi = 0;
                $Total_b_gi = 0;
                $Total_s_fc = 0;
                $Total_b_fc = 0;
                $Total_s_ga = 0;
                $Total_b_ga = 0;
                $Total_s_qa = 0;
                $Total_b_qa = 0;
                $Total_s_sgcsgq = 0;
                $Total_b_sgcsgq = 0;
                $Total_s_nd = 0;
                $Total_b_nd = 0;
                $Total_s_td = 0;
                $Total_b_td = 0;
                $Total_s_pt = 0;
                $Total_b_pt = 0;
                $Total_s_cd = 0;
                $Total_b_cd = 0;
                $Total_s_nct = 0;
                $Total_b_nct = 0;
                $Total_s_sr = 0;
                $Total_b_sr = 0;
                $Total_s_other = 0;
                $Total_b_other = 0;
                
                $Total_s_total = 0;
                $Total_b_total = 0;
                
                
                foreach ($ship as $key => $row) {
                    $rankInfo = $this->db->query("select * from
                                                (select '11,1,2' EQUIVALANT_RANKID, 'MCPO' RANK_NAME, '1' posi
                                                union
                                                (select EQUIVALANT_RANKID, RANK_NAME, POSITION posi
                                                from bn_equivalent_rank
                                                where EQUIVALANT_RANKID not in (11,1,2,7,8,9) order by POSITION)
                                                union
                                                select '7,8,9' EQUIVALANT_RANKID, 'OD' RANK_NAME, '9' posi)a order by posi")->result();
                    ?>
                    <tr>
                        <td rowspan="<?php echo 15 ?>"><?php echo $row->NAME ?></td>
                    </tr>
                    <?php 
                    //Seaman total
                        $s_gi = 0;
                        $b_gi = 0;
                        $s_fc = 0;
                        $b_fc = 0;
                        $s_ga = 0;
                        $b_ga = 0;
                        $s_qa = 0;
                        $b_qa = 0;
                        $s_sgcsgq = 0;
                        $b_sgcsgq = 0;
                        $s_nd = 0;
                        $b_nd = 0;
                        $s_td = 0;
                        $b_td = 0;
                        $s_pt = 0;
                        $b_pt = 0;
                        $s_cd = 0;
                        $b_cd = 0;
                        $s_nct = 0;
                        $b_nct = 0;
                        $s_sr = 0;
                        $b_sr = 0;
                        $s_other = 0;
                        $b_other = 0;
                        
                        $s_total = 0;
                        $b_total = 0;
                    foreach ($rankInfo as $key => $value3) {
                        $sancBorne = $this->db->query("select b.BRANCH_ID, b.BRANCH_NAME, br.Borne, san.Sanction
                                                        from bn_branch b
                                                        left join (select BRANCHID, count(SAILORID)Borne
                                                        from sailor where SAILORSTATUS = 1 and EQUIVALANTRANKID in ($value3->EQUIVALANT_RANKID)
                                                        and SHIPESTABLISHMENTID = $row->SHIP_ESTABLISHMENTID 
                                                        group by BRANCHID)br on b.BRANCH_ID = br.BRANCHID
                                                        left join (select r.BRANCH_ID, sum(u.SanctionNo)Sanction
                                                        from unitwisesanction u
                                                        left join bn_rank r on u.RankID = r.RANK_ID
                                                        where r.EQUIVALANT_RANKID in ($value3->EQUIVALANT_RANKID) and u.ShipEstablishmentID = $row->SHIP_ESTABLISHMENTID GROUP BY r.BRANCH_ID)san on b.BRANCH_ID = san.BRANCH_ID
                                                        where b.BRANCH_ID in($branchNameString) AND b.BRANCH_ID not in(1)")->result();
                        //
                        $partIIBorne = $this->db->query("select count(s.SAILORID)total_borne, COUNT(CASE WHEN p.PartIIID in(1) THEN 1 ELSE NULL END) AS 'GI',
                                                        COUNT(CASE WHEN p.PartIIID in(2,3,44) THEN 1 ELSE NULL END) AS 'FC',
                                                        COUNT(CASE WHEN p.PartIIID in(8,9) THEN 1 ELSE NULL END) AS 'GA',
                                                        COUNT(CASE WHEN p.PartIIID in(4,5) THEN 1 ELSE NULL END) AS 'QA',
                                                        COUNT(CASE WHEN p.PartIIID in(6,7) THEN 1 ELSE NULL END) AS 'SGCSGQ',
                                                        COUNT(CASE WHEN t.TRADE_ID in(3) THEN 1 ELSE NULL END) AS 'ND',
                                                        COUNT(CASE WHEN t.TRADE_ID in(2) THEN 1 ELSE NULL END) AS 'TD',
                                                        COUNT(CASE WHEN t.TRADE_ID in(6) THEN 1 ELSE NULL END) AS 'PT',
                                                        COUNT(CASE WHEN t.TRADE_ID in(4) THEN 1 ELSE NULL END) AS 'CD',
                                                        COUNT(CASE WHEN t.TRADE_ID in(19) THEN 1 ELSE NULL END) AS 'NCT',
                                                        COUNT(CASE WHEN t.TRADE_ID in(5) THEN 1 ELSE NULL END) AS 'SR',
                                                        COUNT(CASE WHEN s.FIRSTPARTID is null THEN 1 ELSE NULL END) AS 'Other'
                                                        from sailor s
                                                        left join partii p on p.PartIIID = s.FIRSTPARTID
                                                        left join bn_trade t on p.TradeID = t.TRADE_ID
                                                        where s.SAILORSTATUS = 1 and s.BRANCHID = 1 and SHIPESTABLISHMENTID = $row->SHIP_ESTABLISHMENTID
                                                        and s.EQUIVALANTRANKID in($value3->EQUIVALANT_RANKID)")->row();
                        //
                        $partIISanc = $this->db->query("select sum(u.SanctionNo)total_sanc,
                                                        sum(CASE WHEN p.PartIIID in(1) THEN u.SanctionNo ELSE NULL END) AS 'GI',
                                                        sum(CASE WHEN p.PartIIID in(2,3,44) THEN u.SanctionNo ELSE NULL END) AS 'FC',
                                                        sum(CASE WHEN p.PartIIID in(8,9) THEN u.SanctionNo ELSE NULL END) AS 'GA',
                                                        sum(CASE WHEN p.PartIIID in(4,5) THEN u.SanctionNo ELSE NULL END) AS 'QA',
                                                        sum(CASE WHEN p.PartIIID in(6,7) THEN u.SanctionNo ELSE NULL END) AS 'SGCSGQ',
                                                        sum(CASE WHEN t.TRADE_ID in(3) THEN u.SanctionNo ELSE NULL END) AS 'ND',
                                                        sum(CASE WHEN t.TRADE_ID in(2) THEN u.SanctionNo ELSE NULL END) AS 'TD',
                                                        sum(CASE WHEN t.TRADE_ID in(6) THEN u.SanctionNo ELSE NULL END) AS 'PT',
                                                        sum(CASE WHEN t.TRADE_ID in(4) THEN u.SanctionNo ELSE NULL END) AS 'CD',
                                                        sum(CASE WHEN t.TRADE_ID in(19) THEN u.SanctionNo ELSE NULL END) AS 'NCT',
                                                        sum(CASE WHEN t.TRADE_ID in(5) THEN u.SanctionNo ELSE NULL END) AS 'SR',
                                                        sum(CASE WHEN p.PartIIID is null THEN u.SanctionNo ELSE NULL END) AS 'Other'
                                                        from unitwisesanction u
                                                        left join partii p on p.PartIIID = u.PartIIID
                                                        left join bn_trade t on p.TradeID = t.TRADE_ID
                                                        left join bn_rank r on u.RankID = r.RANK_ID
                                                        where r.BRANCH_ID = 1 and u.ShipEstablishmentID = $row->SHIP_ESTABLISHMENTID and r.EQUIVALANT_RANKID in($value3->EQUIVALANT_RANKID)")->row();
                        $ParTotalSanction = 0;
                        $ParTotalBorne = 0;
                        $totalSanction = 0;
                        $totalBorne = 0;
                        
                        ?>
                        <tr>
                            <td style="text-align: left;"><?php echo $value3->RANK_NAME ?></td>
                            <?php 
                            if(in_array(1, $branchName)){
                                $ParTotalSanction = $partIISanc->total_sanc;
                                $ParTotalBorne = $partIIBorne->total_borne;
                                ?>
                                <td><?php $s_gi+= $partIISanc->GI;echo $partIISanc->GI?></td>
                                <td><?php $b_gi+= $partIIBorne->GI;echo $partIIBorne->GI?></td>
                                <td><?php $s_fc+= $partIISanc->FC;echo $partIISanc->FC?></td>
                                <td><?php $b_fc+= $partIIBorne->FC;echo $partIIBorne->FC?></td>
                                <td><?php $s_ga+= $partIISanc->GA;echo $partIISanc->GA?></td>
                                <td><?php $b_ga+= $partIIBorne->GA;echo $partIIBorne->GA?></td>
                                <td><?php $s_qa+= $partIISanc->QA;echo $partIISanc->QA?></td>
                                <td><?php $b_qa+= $partIIBorne->QA;echo $partIIBorne->QA?></td>
                                <td><?php $s_sgcsgq+= $partIISanc->SGCSGQ;echo $partIISanc->SGCSGQ?></td>
                                <td><?php $b_sgcsgq+= $partIIBorne->SGCSGQ;echo $partIIBorne->SGCSGQ?></td>
                                <td><?php $s_nd+= $partIISanc->ND;echo $partIISanc->ND?></td>
                                <td><?php $b_nd+= $partIIBorne->ND;echo $partIIBorne->ND?></td>
                                <td><?php $s_td+= $partIISanc->TD;echo $partIISanc->TD?></td>
                                <td><?php $b_td+= $partIIBorne->TD;echo $partIIBorne->TD?></td>
                                <td><?php $s_pt+= $partIISanc->PT;echo $partIISanc->PT?></td>
                                <td><?php $b_pt+= $partIIBorne->PT;echo $partIIBorne->PT?></td>
                                <td><?php $s_cd+= $partIISanc->CD;echo $partIISanc->CD?></td>
                                <td><?php $b_cd+= $partIIBorne->CD;echo $partIIBorne->CD?></td>
                                <td><?php $s_nct+= $partIISanc->NCT;echo $partIISanc->NCT?></td>
                                <td><?php $b_nct+= $partIIBorne->NCT;echo $partIIBorne->NCT?></td>
                                <td><?php $s_sr+= $partIISanc->SR;echo $partIISanc->SR?></td>
                                <td><?php $b_sr+= $partIIBorne->SR;echo $partIIBorne->SR?></td>
                                <td><?php $s_other+= $partIISanc->Other;echo $partIISanc->Other?></td>
                                <td><?php $b_other+= $partIIBorne->Other;echo $partIIBorne->Other?></td>
                                <?php 
                             };
                            foreach ($sancBorne as $key => $value4) {?>
                                <td><?php $totalSanction+=$value4->Sanction; echo $value4->Sanction?></td>
                                <td><?php $totalBorne+=$value4->Borne; echo $value4->Borne?></td>
                            <?php }?>
                            <td><?php $s_total+= $totalSanction+$ParTotalSanction; echo $totalSanction+$ParTotalSanction ?></td>
                            <td><?php $b_total+= $totalBorne+$ParTotalBorne; echo $totalBorne+$ParTotalBorne?></td>
                        </tr>
                        <tr>
                            <td style="text-align: left;">UD(+/-)</td>
                            <?php 
                            if(in_array(1, $branchName)){
                                foreach ($partII as $key => $value0) { ?>
                                    <td></td>
                                    <td></td>
                                <?php }
                              }
                            foreach ($sancBorne as $key => $value4) {?>
                                <td></td>
                                <td></td>
                            <?php }?>
                            <td></td>
                            <td></td>
                        </tr>
                    <?php }
                    //end rank loop
                    $Total_s_gi += $s_gi;
                    $Total_b_gi += $b_gi;
                    $Total_s_fc += $s_fc;
                    $Total_b_fc += $b_fc;
                    $Total_s_ga += $s_ga;
                    $Total_b_ga += $b_ga;
                    $Total_s_qa += $s_qa;
                    $Total_b_qa += $b_qa;
                    $Total_s_sgcsgq += $s_sgcsgq;
                    $Total_b_sgcsgq += $b_sgcsgq;
                    $Total_s_nd += $s_nd;
                    $Total_b_nd += $b_nd;
                    $Total_s_td += $s_td;
                    $Total_b_td += $b_td;
                    $Total_s_pt += $s_pt;
                    $Total_b_pt += $b_pt;
                    $Total_s_cd += $s_cd;
                    $Total_b_cd += $b_cd;
                    $Total_s_nct += $s_nct;
                    $Total_b_nct += $b_nct;
                    $Total_s_sr += $s_sr;
                    $Total_b_sr += $b_sr;
                    $Total_s_other += $s_other;
                    $Total_b_other += $b_other;
                    
                    $Total_s_total += $s_total;
                    $Total_b_total += $b_total;
                    ?>
                <?php } 
                $grandTotalSancBorn = $this->db->query("select b.BRANCH_ID, b.BRANCH_NAME, br.Borne, san.Sanction
                                                        from bn_branch b
                                                        left join (select BRANCHID, count(SAILORID)Borne
                                                        from sailor where SAILORSTATUS = 1 and SHIPESTABLISHMENTID in($shifIDString) group by BRANCHID)br on b.BRANCH_ID = br.BRANCHID
                                                        left join (select r.BRANCH_ID, sum(u.SanctionNo)Sanction
                                                        from unitwisesanction u
                                                        left join bn_rank r on u.RankID = r.RANK_ID
                                                        where u.ShipEstablishmentID in ($shifIDString) GROUP BY r.BRANCH_ID)san on b.BRANCH_ID = san.BRANCH_ID
                                                        where b.BRANCH_ID in($branchNameString) AND b.BRANCH_ID not in(1)")->result();
                ?>
                <tr>
                    <td colspan="2">GRAND TOTAL</td>
                    <?php if(in_array(1, $branchName)){?>
                        <td><?php echo $Total_s_gi?></td>
                        <td><?php echo $Total_b_gi?></td>
                        
                        <td><?php echo $Total_s_fc?></td>
                        <td><?php echo $Total_b_fc?></td>
                        
                        <td><?php echo $Total_s_ga?></td>
                        <td><?php echo $Total_b_ga?></td>
                        
                        <td><?php echo $Total_s_qa?></td>
                        <td><?php echo $Total_b_qa?></td>
                        
                        <td><?php echo $Total_s_sgcsgq?></td>
                        <td><?php echo $Total_b_sgcsgq?></td>
                        
                        <td><?php echo $Total_s_nd?></td>
                        <td><?php echo $Total_b_nd?></td>
                        
                        <td><?php echo $Total_s_td?></td>
                        <td><?php echo $Total_b_td?></td>
                        
                        <td><?php echo $Total_s_pt?></td>
                        <td><?php echo $Total_b_pt?></td>
                        
                        <td><?php echo $Total_s_cd?></td>
                        <td><?php echo $Total_b_cd?></td>
                        
                        <td><?php echo $Total_s_nct?></td>
                        <td><?php echo $Total_b_nct?></td>
                        
                        <td><?php echo $Total_s_sr?></td>
                        <td><?php echo $Total_b_sr?></td>
                        
                        <td><?php echo $Total_s_other?></td>
                        <td><?php echo $Total_b_other?></td>
                    <?php }
                    foreach ($grandTotalSancBorn as $key => $value5) {?>
                        <td><?php echo $value5->Sanction?></td>
                        <td><?php echo $value5->Borne?></td>
                    <?php }
                    ?>
                        <td><?php echo $Total_s_total?></td>
                        <td><?php echo $Total_b_total?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<script src="<?php echo base_url('dist/scripts/jquery.min.js') ?>"></script>
<script>
    // Print
    $(document).on("click", ".print", function(e) {
        e.preventDefault();
        Popup($("#printablediv").html());
    });

    function Popup(data)
    {
        var currentdate = new Date();
        var datetime = "File: " + currentdate.getDate() + ""
                + (currentdate.getMonth() + 1) + ""
                + currentdate.getFullYear() + ""
                + currentdate.getHours() + ""
                + currentdate.getMinutes() + ""
                + currentdate.getSeconds();

        var mywindow = window.open('', datetime, 'height=800,width=1024');
        mywindow.document.write('<html><head><title>' + datetime + '</title>');
        /*optional stylesheet*/ //mywindow.document.write('<link rel="stylesheet" href="main.css" type="text/css" />');
        mywindow.document.write('</head><body >');
        mywindow.document.write(data);
        mywindow.document.write('</body></html>');
        mywindow.print();
        mywindow.close();

        return true;
    }
</script>