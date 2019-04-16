<script>
    /**
     * Jquery Branch & rank Section
     */
    $(document).on('click', '#branchRank', function(event) {
       $('.borneANDSan').prop('disabled',true);
        $('.branchEquiRank').css('opacity', '0.5');

        $('.normalDetails').prop('disabled',false);
        $('.branchRank').css('opacity', '1');
        //('.bANDr').prop('checked', true)
    });
    $(document).on('click', '#branchEquiRank', function(event) {
        $('.normalDetails').prop('disabled',true);
        $('.branchRank').css('opacity', '0.5');

        $('.borneANDSan').prop('disabled',false);
        $('.branchEquiRank').css('opacity', '1');

    });

    //$('#branchRank').prop('checked', true);;
    $('.borneANDSan').prop('disabled',true);
    $('.branchEquiRank').css('opacity', '0.5');

    /*End section*/
    $(document).on('change', '#TRAINING_TYPE_ID', function(event) {
        event.preventDefault();
        var id = $(this).val();
        $.ajax({
            url: '<?php echo base_url() ?>setup/common/trainingName_by_trainingType',
            type: 'POST',
            dataType: 'html',
            data: {TRAINING_TYPE: id},
            beforeSend: function () {
                $(".training_dropdown").html("<img src='<?php echo base_url(); ?>dist/img/loader.gif' />");
            },
            success: function (data) {
                $('.training_dropdown').html(data);
            }
        });
    });
    /*Single element change Trade get partII value*/
    $(document).on('changed.bs.select', '#trade', function(event) {
        var id = $(this).val();
        $.ajax({
            url: '<?php echo base_url() ?>reportViewPrint/strengthByBranch/partTwoByTrade',
            type: 'POST',
            dataType: 'html',
            data: {trade: id},
            beforeSend: function () {
                $(".trade").html("<img src='<?php echo base_url(); ?>dist/img/loader-small.gif' />");
            },
            success: function (data) {
                 $(".trade").html('');
                $('#partTwo').html(data);
                $('#partTwo').selectpicker('refresh');
            }
        });
    });

    /*Single element change Trade get partII value*/
    $(document).on('changed.bs.select', '#zone', function(event) {
        var zone = $(this).val();
        $.ajax({
            url: '<?php echo base_url() ?>reportViewPrint/strengthByBranch/areaByZone',
            type: 'POST',
            dataType: 'html',
            data: {zone: zone},
            beforeSend: function () {
                $(".zone").html("<img src='<?php echo base_url(); ?>dist/img/loader-small.gif' />");
            },
            success: function (data) {
                $(".zone").html('');
                $('#area').html(data);
                $('#area').selectpicker('refresh');

                /*ship establishment section*/
                $.ajax({
                    url: '<?php echo base_url() ?>reportViewPrint/strengthByBranch/shipEstablishmentByZone',
                    type: 'POST',
                    dataType: 'html',
                    data: {zone: zone},
                    beforeSend: function () {
                        $(".shipEst").html("<img src='<?php echo base_url(); ?>dist/img/loader-small.gif' />");
                    },
                    success: function (data) {
                        $(".shipEst").html('');
                        $('#shipEst').html(data);
                        $('#shipEst').selectpicker('refresh');

                        /*ship establishment section*/
                    }
                });
            }
        });
    });
    /*Single element change Trade get partII value*/
    $(document).on('changed.bs.select', '#area', function(event) {
        var area = $(this).val();
        /*ship establishment section*/
        $.ajax({
            url: '<?php echo base_url() ?>reportViewPrint/strengthByBranch/shipEstablishmentByZone',
            type: 'POST',
            dataType: 'html',
            data: {zone: 0, area:area},
            beforeSend: function () {
                $(".shipEst").html("<img src='<?php echo base_url(); ?>dist/img/loader-small.gif' />");
            },
            success: function (data) {
                $(".shipEst").html('');
                $('#shipEst').html(data);
                $('#shipEst').selectpicker('refresh');

                /*ship establishment section*/
            }
        });

    });

    /*Single element change Trade get partII value*/
    $(document).on('changed.bs.select', '#shipEst', function(event) {
        var shipEstId = $(this).val();
        /*ship establishment section*/
        $.ajax({
            url: '<?php echo base_url() ?>reportViewPrint/strengthByBranch/postingUnitByshipEstablishment',
            type: 'POST',
            dataType: 'html',
            data: {shipEst:shipEstId},
            beforeSend: function () {
                $(".postingUnit").html("<img src='<?php echo base_url(); ?>dist/img/loader-small.gif' />");
            },
            success: function (data) {
                $(".postingUnit").html('');
                $('#postingUnit').html(data);
                $('#postingUnit').selectpicker('refresh');
            }
        });

    });


    /*Select all option click*/
    $(document).ready(function() {
        function selectDeselectTrade(){
             $.ajax({
                url: '<?php echo base_url() ?>reportViewPrint/strengthByBranch/partTwoByTrade',
                type: 'POST',
                dataType: 'html',
                data: {trade: $(this).val()},
                beforeSend: function () {
                    $(".trade").html("<img src='<?php echo base_url(); ?>dist/img/loader-small.gif' />");
                },
                success: function (data) {
                     $(".trade").html('');
                    $('#partTwo').html(data);
                    $('#partTwo').selectpicker('refresh');
                }
            });
        }
        function selectDeselectZone(zoneId){
            $.ajax({
                url: '<?php echo base_url() ?>reportViewPrint/strengthByBranch/areaByZone',
                type: 'POST',
                dataType: 'html',
                data: {zone: zoneId}, /*zone array*/
                beforeSend: function () {
                    $(".zone").html("<img src='<?php echo base_url(); ?>dist/img/loader-small.gif' />");
                },
                success: function (data) {
                     $(".zone").html('');
                    $('#area').html(data);
                    $('#area').selectpicker('refresh');

                    /*ship establishment section*/
                    $.ajax({
                        url: '<?php echo base_url() ?>reportViewPrint/strengthByBranch/shipEstablishmentByZone',
                        type: 'POST',
                        dataType: 'html',
                        data: {zone: zoneId, area:0 }, /*zone array*/
                        beforeSend: function () {
                            $(".shipEst").html("<img src='<?php echo base_url(); ?>dist/img/loader-small.gif' />");
                        },
                        success: function (data) {
                            $(".shipEst").html('');
                            $('#shipEst').html(data);
                            $('#shipEst').selectpicker('refresh');

                            /*ship establishment section*/
                        }
                    });
                }
            });
        }
        function selectDeselectArea(areaId){
             $.ajax({
                url: '<?php echo base_url() ?>reportViewPrint/strengthByBranch/shipEstablishmentByZone',
                type: 'POST',
                dataType: 'html',
                data: {zone: 0, area:areaId},
                beforeSend: function () {
                    $(".shipEst").html("<img src='<?php echo base_url(); ?>dist/img/loader-small.gif' />");
                },
                success: function (data) {
                    $(".shipEst").html('');
                    $('#shipEst').html(data);
                    $('#shipEst').selectpicker('refresh');
                }
            });
        }
        function selectDeselectShipEst(shipEstId){
            $.ajax({
                url: '<?php echo base_url() ?>reportViewPrint/strengthByBranch/postingUnitByshipEstablishment',
                type: 'POST',
                dataType: 'html',
                data: {shipEst:shipEstId},
                beforeSend: function () {
                    $(".postingUnit").html("<img src='<?php echo base_url(); ?>dist/img/loader-small.gif' />");
                },
                success: function (data) {
                    $(".postingUnit").html('');
                    $('#postingUnit').html(data);
                    $('#postingUnit').selectpicker('refresh');
                }
            });
        }
        function selectDeselectBranchRank(equiRankId){
            $.ajax({
                url: '<?php echo base_url() ?>reportViewPrint/strengthByBranch/rankByEquRank',
                type: 'POST',
                dataType: 'html',
                data: {equiRank: equiRankId},
                beforeSend: function () {
                    $(".rank").html("<img src='<?php echo base_url(); ?>dist/img/loader-small.gif' />");
                },
                success: function (data) {
                    $(".rank").html('');
                    $('#rank').html(data);
                    $('#rank').selectpicker('refresh');

                    /*ship establishment section*/
                }
            });
        }
        /*section division, district, thana*/
        function selectDeselectDivision(divisionId){
            $.ajax({
                url: '<?php echo base_url() ?>reportViewPrint/strengthByBDAdmin/districtBydivision',
                type: 'POST',
                dataType: 'html',
                data: {division: divisionId}, /*zone array*/
                beforeSend: function () {
                    $(".division").html("<img src='<?php echo base_url(); ?>dist/img/loader-small.gif' />");
                },
                success: function (data) {
                     $(".division").html('');
                    $('#district').html(data);
                    $('#district').selectpicker('refresh');

                    /*ship establishment section*/
                    $.ajax({
                        url: '<?php echo base_url() ?>reportViewPrint/strengthByBDAdmin/thanaBydistrict',
                        type: 'POST',
                        dataType: 'html',
                        data: {district: divisionId}, /*division array*/
                        beforeSend: function () {
                            $(".district").html("<img src='<?php echo base_url(); ?>dist/img/loader-small.gif' />");
                        },
                        success: function (data) {
                            $(".district").html('');
                            $('#thana').html(data);
                            $('#thana').selectpicker('refresh');

                            /*ship establishment section*/
                        }
                    });
                }
            });
        }
        function selectDeselectDistrict(districtId){
             $.ajax({
                url: '<?php echo base_url() ?>reportViewPrint/strengthByBDAdmin/thanaBydistrict',
                type: 'POST',
                dataType: 'html',
                data: {district:districtId},
                beforeSend: function () {
                    $(".district").html("<img src='<?php echo base_url(); ?>dist/img/loader-small.gif' />");
                },
                success: function (data) {
                    $(".district").html('');
                    $('#thana').html(data);
                    $('#thana').selectpicker('refresh');
                }
            });
        }
        /*end section*/

        $(".bs-select-all").on('click', function() {
            var trade = 1, zone = 1, area=1, shipEst = 1, equiRank = 1, district=1, division=1;
            /*Select all click for trade get partTwo*/
            $("#trade").on('change', function(event){
                if(trade == 1){
                   selectDeselectTrade();
                }
                trade++;
            });
            /*Select all click for trade get zone*/
            $("#zone").on('change', function(event){
                if(zone == 1){
                    var zoneId = $(this).val();
                    selectDeselectZone(zoneId)
                }
                zone++;
            });
            /*Select all click for zone get area*/
            $("#area").on('change', function(event){
                if(area == 1){
                    var areaId = $(this).val();
                    selectDeselectArea(areaId)
                    area++;
                }
            });
            /*Select all click for select all get ship Establishment*/
            $("#shipEst").on('change', function(event){
                if(shipEst == 1){
                    var shipEstId = $(this).val();
                    selectDeselectShipEst(shipEstId)
                    shipEst++;
                }
            });
            /*Select all click for equi.Rank get branch & Rank*/
            $("#equRank").on('change', function(event){
                if(equiRank == 1){
                    var equiRankId = $(this).val();
                    selectDeselectBranchRank(equiRankId)
                    equiRank++;
                }
            });
            /*Select all click for equi.Rank get branch & Rank*/
            $("#division").on('change', function(event){
                if(division == 1){
                    var divisionId = $(this).val();
                    selectDeselectDivision(divisionId)
                    division++;
                }
            });
            /*Select all click for equi.Rank get branch & Rank*/
            $("#district").on('change', function(event){
                if(district == 1){
                    var districtId = $(this).val();
                    selectDeselectDistrict(districtId)
                    district++;
                }
            });


        });
        $(".bs-deselect-all").on('click', function() {
            var trade = 1, zone = 1, area=1, shipEst = 1, equiRank = 1, district=1, division=1, thana =1;
            /*Select all click for trade get partTwo*/
            $("#trade").on('change', function(event){
                if(trade == 1){
                   selectDeselectTrade();
                }
                trade++;
            });
            /*Select all click for trade get zone*/
            $("#zone").on('change', function(event){
                if(zone == 1){
                    var zoneId = 0;
                    selectDeselectZone(zoneId)
                }
                zone++;
            });
            /*Select all click for trade get area*/
            $("#area").on('change', function(event){
                if(area == 1){
                    var areaId = $(this).val();
                    selectDeselectArea(areaId)
                    area++;
                }
            });
            /*Select all click for trade get ship Establishment*/
            $("#shipEst").on('change', function(event){
                if(shipEst == 1){
                    var shipEstId = $(this).val();
                    selectDeselectShipEst(shipEstId)
                    shipEst++;
                }
            });
            /*Select all click for equi.Rank get branch & Rank*/
            $("#equRank").on('change', function(event){
                if(equiRank == 1){
                    var equiRankId = $(this).val();
                    selectDeselectBranchRank(equiRankId)
                    equiRank++;
                }
            });
            /*Select all click for equi.Rank get branch & Rank*/
            $("#division").on('change', function(event){
                if(division == 1){
                    var divisionId = $(this).val();
                    selectDeselectDivision(divisionId)
                    division++;
                }
            });
            /*Select all click for district get division*/
            $("#district").on('change', function(event){
                if(district == 1){
                    var districtId = $(this).val();
                    selectDeselectDistrict(districtId)
                    district++;
                }
            });
            /*Select all click for equi.Rank get branch & Rank*/
            /*$("#thana").on('change', function(event){
                if(thana == 1){
                    var thanaId = $(this).val();
                    selectDeselectThana(thanaId)
                    thana++;
                }
            });*/

        });
    });


    /**
     * Section Equi. Rank, Branch, Rank
     */

    /*Single element change equi rank get Rank, Branch value*/
    $(document).on('changed.bs.select', '#equRank', function(event) {
        var equiRank = $(this).val();

        /*ship establishment section*/
        $.ajax({
            url: '<?php echo base_url() ?>reportViewPrint/strengthByBranch/rankByEquRank',
            type: 'POST',
            dataType: 'html',
            data: {equiRank: equiRank},
            beforeSend: function () {
                $(".rank").html("<img src='<?php echo base_url(); ?>dist/img/loader-small.gif' />");
            },
            success: function (data) {
                $(".rank").html('');
                $('#rank').html(data);
                $('#rank').selectpicker('refresh');

                /*ship establishment section*/
            }
        });

    });
    /**
     * Section disvision, district, thana
     */

    /*Single element change district get division value*/
    $(document).on('changed.bs.select', '#division', function(event) {
        var division = $(this).val();

        /*ship establishment section*/
        $.ajax({
            url: '<?php echo base_url() ?>reportViewPrint/strengthByBDAdmin/districtBydivision',
            type: 'POST',
            dataType: 'html',
            data: {division: division},
            beforeSend: function () {
                $(".division").html("<img src='<?php echo base_url(); ?>dist/img/loader-small.gif' />");
            },
            success: function (data) {
                $(".division").html('');
                $('#district').html(data);
                $('#district').selectpicker('refresh');
                $('#thana').selectpicker('refresh');
            }
        });
    });
    /*Single element change thana get district value*/
    $(document).on('changed.bs.select', '#district', function(event) {
        var district = $(this).val();

        /*ship establishment section*/
        $.ajax({
            url: '<?php echo base_url() ?>reportViewPrint/strengthByBDAdmin/thanaBydistrict',
            type: 'POST',
            dataType: 'html',
            data: {district: district},
            beforeSend: function () {
                $(".district").html("<img src='<?php echo base_url(); ?>dist/img/loader-small.gif' />");
            },
            success: function (data) {
                $(".district").html('');
                $('#thana').html(data);
                $('#thana').selectpicker('refresh');
            }
        });

    });

    /**
     * @package     Query Tools
     * @author      Emdadul Huq <Emdadul@atilimited.net>
     * @copyright   2017 atilimited.net
     */

    /*General section javascript*/

    $("#birthendDate").prop('disabled', true);
    $(document).on('change', '#filterBirtha', function(){
        var val = $(this).val();
        if(val == 4){
            $("#birthendDate").prop('disabled', false);
        }else {
            $("#birthendDate").prop('disabled', true);
            $("#birthendDate").val('');
        }
    });
    
    $("#endheight").prop('disabled', true);
    $(document).on('change', '#filterHeight', function(){
        var val = $(this).val();
        if(val == 4){
            $("#endheight").prop('disabled', false);
        }else {
            $("#endheight").prop('disabled', true);
            $("#endheight").val('');
        }
    });

    /*end general section javascript*/
    
    /*Foreign visit and mark run section javascript*/

    $("#StartDateend").prop('disabled', true);
    $(document).on('change', '#filterStartDatefv', function(){
        var val = $(this).val();
        if(val == 4){
            $("#StartDateend").prop('disabled', false);
        }else {
            $("#StartDateend").prop('disabled', true);
            $("#StartDateend").val('');
        }
    });
    
    $("#EndDateEnd").prop('disabled', true);
    $(document).on('change', '#filterEndDatefv', function(){
        var val = $(this).val();
        if(val == 4){
            $("#EndDateEnd").prop('disabled', false);
        }else {
            $("#EndDateEnd").prop('disabled', true);
            $("#EndDateEnd").val('');
        }
    });
    
    $("#DurationEnd").prop('disabled', true);
    $(document).on('change', '#filterDurationfv', function(){
        var val = $(this).val();
        if(val == 4){
            $("#DurationEnd").prop('disabled', false);
        }else {
            $("#DurationEnd").prop('disabled', true);
            $("#DurationEnd").val('');
        }
    });
    
    $("#AbsentDateEnd").prop('disabled', true);
    $(document).on('change', '#absentFilter', function(){
        var val = $(this).val();
        if(val == 4){
            $("#AbsentDateEnd").prop('disabled', false);
        }else {
            $("#AbsentDateEnd").prop('disabled', true);
            $("#AbsentDateEnd").val('');
        }
    });
    
    $("#RunDateEnd").prop('disabled', true);
    $(document).on('change', '#runFilter', function(){
        var val = $(this).val();
        if(val == 4){
            $("#RunDateEnd").prop('disabled', false);
        }else {
            $("#RunDateEnd").prop('disabled', true);
            $("#RunDateEnd").val('');
        }
    });
    
    $("#SurrenderDateEnd").prop('disabled', true);
    $(document).on('change', '#surrenderFilter', function(){
        var val = $(this).val();
        if(val == 4){
            $("#SurrenderDateEnd").prop('disabled', false);
        }else {
            $("#SurrenderDateEnd").prop('disabled', true);
            $("#SurrenderDateEnd").val('');
        }
    });

    $("#RemoveDateEnd").prop('disabled', true);
    $(document).on('change', '#runremoveFilter', function(){
        var val = $(this).val();
        if(val == 4){
            $("#RemoveDateEnd").prop('disabled', false);
        }else {
            $("#RemoveDateEnd").prop('disabled', true);
            $("#RemoveDateEnd").val('');
        }
    });


    /*end Foreign visit and mark run section javascript*/
    
    /*Engagement, Assignment, Branch change section javascript*/
    $("#EngagementNoEnd").prop('disabled', true);
    $(document).on('change', '#engagementnoFilter', function(){
        var val = $(this).val();
        if(val == 4){
            $("#EngagementNoEnd").prop('disabled', false);
        }else {
            $("#EngagementNoEnd").prop('disabled', true);
            $("#EngagementNoEnd").val('');
        }
    });

    $("#EngagementDateEnd").prop('disabled', true);
    $(document).on('change', '#engagementDateFilter', function(){
        var val = $(this).val();
        if(val == 4){
            $("#EngagementDateEnd").prop('disabled', false);
        }else {
            $("#EngagementDateEnd").prop('disabled', true);
            $("#EngagementDateEnd").val('');
        }
    });
    
    $("#ExpiryDateEnd").prop('disabled', true);
    $(document).on('change', '#engageExpiryFilter', function(){
        var val = $(this).val();
        if(val == 4){
            $("#ExpiryDateEnd").prop('disabled', false);
        }else {
            $("#ExpiryDateEnd").prop('disabled', true);
            $("#ExpiryDateEnd").val('');
        }
    });

    $("#reEngDueEnd").prop('disabled', true);
    $(document).on('change', '#reEngDueFilter', function(){
        var val = $(this).val();
        if(val == 4){
            $("#reEngDueEnd").prop('disabled', false);
        }else {
            $("#reEngDueEnd").prop('disabled', true);
            $("#reEngDueEnd").val('');
        }
    });

    $("#AssessYearEnd").prop('disabled', true);
    $(document).on('change', '#assessyearFilter', function(){
        var val = $(this).val();
        if(val == 4){
            $("#AssessYearEnd").prop('disabled', false);
        }else {
            $("#AssessYearEnd").prop('disabled', true);
            $("#AssessYearEnd").val('');
        }
    });

    $("#numberVgEnd").prop('disabled', true);
    $(document).on('change', '#vgNumberFilter', function(){
        var val = $(this).val();
        if(val == 4){
            $("#numberVgEnd").prop('disabled', false);
        }else {
            $("#numberVgEnd").prop('disabled', true);
            $("#numberVgEnd").val('');
        }
    });

    $("#CHANGE_DATEEnd").prop('disabled', true);
    $(document).on('change', '#branchChangeFilter', function(){
        var val = $(this).val();
        if(val == 4){
            $("#CHANGE_DATEEnd").prop('disabled', false);
        }else {
            $("#CHANGE_DATEEnd").prop('disabled', true);
            $("#CHANGE_DATEEnd").val('');
        }
    });

    /*End Engagement, Assignment, Branch change section javascript*/
    
    /*Engagement, Assignment, Branch change section javascript*/

    $("#courseStartDateEnd").prop('disabled', true);
    $(document).on('change', '#courInfoStartFilter', function(){
        var val = $(this).val();
        if(val == 4){
            $("#courseStartDateEnd").prop('disabled', false);
        }else {
            $("#courseStartDateEnd").prop('disabled', true);
            $("#courseStartDateEnd").val('');
        }
    });

    $("#courseEndDateEnd").prop('disabled', true);
    $(document).on('change', '#courInfoEndFilter', function(){
        var val = $(this).val();
        if(val == 4){
            $("#courseEndDateEnd").prop('disabled', false);
        }else {
            $("#courseEndDateEnd").prop('disabled', true);
            $("#courseEndDateEnd").val('');
        }
    });

    $("#courseDurationEnd").prop('disabled', true);
    $(document).on('change', '#courDurationFilter', function(){
        var val = $(this).val();
        if(val == 4){
            $("#courseDurationEnd").prop('disabled', false);
        }else {
            $("#courseDurationEnd").prop('disabled', true);
            $("#courseDurationEnd").val('');
        }
    });

    $("#courseMarkEnd").prop('disabled', true);
    $(document).on('change', '#courMarkFilter', function(){
        var val = $(this).val();
        if(val == 4){
            $("#courseMarkEnd").prop('disabled', false);
        }else {
            $("#courseMarkEnd").prop('disabled', true);
            $("#courseMarkEnd").val('');
        }
    });

    $("#coursePercentageEnd").prop('disabled', true);
    $(document).on('change', '#courpercentageFilter', function(){
        var val = $(this).val();
        if(val == 4){
            $("#coursePercentageEnd").prop('disabled', false);
        }else {
            $("#coursePercentageEnd").prop('disabled', true);
            $("#coursePercentageEnd").val('');
        }
    });

    $("#courseSeniorityEnd").prop('disabled', true);
    $(document).on('change', '#courSeniorityFilter', function(){
        var val = $(this).val();
        if(val == 4){
            $("#courseSeniorityEnd").prop('disabled', false);
        }else {
            $("#courseSeniorityEnd").prop('disabled', true);
            $("#courseSeniorityEnd").val('');
        }
    });

    $("#endDate").prop('disabled', true);
    $("#endDate").val('');
    $(document).on('change', '#filterBirth', function(){
        var val = $(this).val();
        if(val == 4){
            $("#endDate").prop('disabled', false);
        }else {
            $("#endDate").prop('disabled', true);
            $("#endDate").val('');
        }
    });


    /*End Engagement, Assignment, Branch change section javascript*/
    
    /*Promotion, Recommendation and Fraudent Info section javascript*/
    $("#PromoDateEnd").prop('disabled', true);
    $(document).on('change', '#promotionDateFilter', function(){
        var val = $(this).val();
        if(val == 4){
            $("#PromoDateEnd").prop('disabled', false);
        }else {
            $("#PromoDateEnd").prop('disabled', true);
            $("#PromoDateEnd").val('');
        }
    });

    $("#promoEffectingDateEnd").prop('disabled', true);
    $(document).on('change', '#promoEffecDateFilter', function(){
        var val = $(this).val();
        if(val == 4){
            $("#promoEffectingDateEnd").prop('disabled', false);
        }else {
            $("#promoEffectingDateEnd").prop('disabled', true);
            $("#promoEffectingDateEnd").val('');
        }
    });

    $("#recomnDateEnd").prop('disabled', true);
    $(document).on('change', '#recomnDateFilter', function(){
        var val = $(this).val();
        if(val == 4){
            $("#recomnDateEnd").prop('disabled', false);
        }else {
            $("#recomnDateEnd").prop('disabled', true);
            $("#recomnDateEnd").val('');
        }
    });

    $("#TransDateEnd").prop('disabled', true);
    $(document).on('change', '#TranDateFilter', function(){
        var val = $(this).val();
        if(val == 4){
            $("#TransDateEnd").prop('disabled', false);
        }else {
            $("#TransDateEnd").prop('disabled', true);
            $("#TransDateEnd").val('');
        }
    });

        
    /*End Promotion, Recommendation and Fraudent Info section javascript*/
    /*Honor section Javascript*/
    $("#GCBNumberEnd").prop('disabled', true);
    $(document).on('change', '#GCBNumberFilter', function(){
        var val = $(this).val();
        if(val == 4){
            $("#GCBNumberEnd").prop('disabled', false);
        }else {
            $("#GCBNumberEnd").prop('disabled', true);
            $("#GCBNumberEnd").val('');
        }
    });

    $("#GCBEffectDateEnd").prop('disabled', true);
    $(document).on('change', '#GCBEffectDateFilter', function(){
        var val = $(this).val();
        if(val == 4){
            $("#GCBEffectDateEnd").prop('disabled', false);
        }else {
            $("#GCBEffectDateEnd").prop('disabled', true);
            $("#GCBEffectDateEnd").val('');
        }
    });

    $("#JesthataAwardDateEnd").prop('disabled', true);
    $(document).on('change', '#JesthataAwardDateFilter', function(){
        var val = $(this).val();
        if(val == 4){
            $("#JesthataAwardDateEnd").prop('disabled', false);
        }else {
            $("#JesthataAwardDateEnd").prop('disabled', true);
            $("#JesthataAwardDateEnd").val('');
        }
    });

    $("#MedalAwardDateEnd").prop('disabled', true);
    $(document).on('change', '#MedalAwardDateFilter', function(){
        var val = $(this).val();
        if(val == 4){
            $("#MedalAwardDateEnd").prop('disabled', false);
        }else {
            $("#MedalAwardDateEnd").prop('disabled', true);
            $("#MedalAwardDateEnd").val('');
        }
    });

    $("#HonorAwardDateEnd").prop('disabled', true);
    $(document).on('change', '#HonorAwardDateFilter', function(){
        var val = $(this).val();
        if(val == 4){
            $("#HonorAwardDateEnd").prop('disabled', false);
        }else {
            $("#HonorAwardDateEnd").prop('disabled', true);
            $("#HonorAwardDateEnd").val('');
        }
    });

    $("#frequencyEndDate").prop('disabled', true);
    $(document).on('change', '#filterBirth', function(){
        var val = $(this).val();
        if(val == 4){
            $("#frequencyEndDate").prop('disabled', false);
        }else {
            $("#frequencyEndDate").prop('disabled', true);
            $("#frequencyEndDate").val('');
        }
    });

    /*End honor section Javascript*/
    

    /*Family section Javascript*/
    
    /*End family section Javascript*/

    /*Service section Javascript*/

    /*End service section Javascript*/
    
    /*Medical, Overweight and Punishment section Javascript*/

    $("#mcFromdateEnd").prop('disabled', true);
    $(document).on('change', '#mcDateFilter', function(){
        var val = $(this).val();
        if(val == 4){
            $("#mcFromdateEnd").prop('disabled', false);
        }else {
            $("#mcFromdateEnd").prop('disabled', true);
            $("#mcFromdateEnd").val('');
        }
    });
    
    $("#mcDurationEnd").prop('disabled', true);
    $(document).on('change', '#mcfilterDuration', function(){
        var val = $(this).val();
        if(val == 4){
            $("#mcDurationEnd").prop('disabled', false);
        }else {
            $("#mcDurationEnd").prop('disabled', true);
            $("#mcDurationEnd").val('');
        }
    });
    
    $("#ovStartDateEnd").prop('disabled', true);
    $(document).on('change', '#ovfilterDate', function(){
        var val = $(this).val();
        if(val == 4){
            $("#ovStartDateEnd").prop('disabled', false);
        }else {
            $("#ovStartDateEnd").prop('disabled', true);
            $("#ovStartDateEnd").val('');
        }
    });
    
    $("#ovamountEnd").prop('disabled', true);
    $(document).on('change', '#ovfilterAmount', function(){
        var val = $(this).val();
        if(val == 4){
            $("#ovamountEnd").prop('disabled', false);
        }else {
            $("#ovamountEnd").prop('disabled', true);
            $("#ovamountEnd").val('');
        }
    });
    
    $("#punishmentDateEnd").prop('disabled', true);
    $(document).on('change', '#filterPunishment', function(){
        var val = $(this).val();
        if(val == 4){
            $("#punishmentDateEnd").prop('disabled', false);
        }else {
            $("#punishmentDateEnd").prop('disabled', true);
            $("#punishmentDateEnd").val('');
        }
    });
    
    $("#NoOfDaysStartEnd").prop('disabled', true);
    $(document).on('change', '#filterNoOfDays', function(){
        var val = $(this).val();
        if(val == 4){
            $("#NoOfDaysStartEnd").prop('disabled', false);
        }else {
            $("#NoOfDaysStartEnd").prop('disabled', true);
            $("#NoOfDaysStartEnd").val('');
        }
    });
    
    $("#frequenceEndDate").prop('disabled', true);
    $(document).on('change', '#frequencefilterBirth', function(){
        var val = $(this).val();
        if(val == 4){
            $("#frequenceEndDate").prop('disabled', false);
        }else {
            $("#frequenceEndDate").prop('disabled', true);
            $("#frequenceEndDate").val('');
        }
    });
    
    $("#medicalEndDate").prop('disabled', true);
    $(document).on('change', '#medicalfilterBirth', function(){
        var val = $(this).val();
        if(val == 4){
            $("#medicalEndDate").prop('disabled', false);
        }else {
            $("#medicalEndDate").prop('disabled', true);
            $("#medicalEndDate").val('');
        }
    });

    /* End Medical, Overweight and Punishment section Javascript*/
    
    /*Movement & Transfer section Javascript*/
    $("#movPostDateEnd").prop('disabled', true);
    $(document).on('change', '#movPostDateFilter', function(){
        var val = $(this).val();
        if(val == 4){
            $("#movPostDateEnd").prop('disabled', false);
        }else {
            $("#movPostDateEnd").prop('disabled', true);
            $("#movPostDateEnd").val('');
        }
    });

    $("#draftOutDateEnd").prop('disabled', true);
    $(document).on('change', '#darftOutDateFilter', function(){
        var val = $(this).val();
        if(val == 4){
            $("#draftOutDateEnd").prop('disabled', false);
        }else {
            $("#draftOutDateEnd").prop('disabled', true);
            $("#draftOutDateEnd").val('');
        }
    });

    $("#effectDateEnd").prop('disabled', true);
    $(document).on('change', '#underDrafEffectDateFilter', function(){
        var val = $(this).val();
        if(val == 4){
            $("#effectDateEnd").prop('disabled', false);
        }else {
            $("#effectDateEnd").prop('disabled', true);
            $("#effectDateEnd").val('');
        }
    });

    $("#orderDateEnd").prop('disabled', true);
    $(document).on('change', '#underOrderDateFilter', function(){
        var val = $(this).val();
        if(val == 4){
            $("#orderDateEnd").prop('disabled', false);
        }else {
            $("#orderDateEnd").prop('disabled', true);
            $("#orderDateEnd").val('');
        }
    });

    $("#noOfDrafEnd").prop('disabled', true);
    $(document).on('change', '#noOfDrafDateFilter', function(){
        var val = $(this).val();
        if(val == 4){
            $("#noOfDrafEnd").prop('disabled', false);
        }else {
            $("#noOfDrafEnd").prop('disabled', true);
            $("#noOfDrafEnd").val('');
        }
    });

    
    /*End Movement & Transfer section Javascript*/
    
    /*End exam Information section Javascript*/
    $("#ExamStartDateEnd").prop('disabled', true);
    $(document).on('change', '#ExamDateFilter', function(){
        var val = $(this).val();
        if(val == 4){
            $("#ExamStartDateEnd").prop('disabled', false);
        }else {
            $("#ExamStartDateEnd").prop('disabled', true);
            $("#ExamStartDateEnd").val('');
        }
    });

    $("#examMarkEnd").prop('disabled', true);
    $(document).on('change', '#ExamMarkFilter', function(){
        var val = $(this).val();
        if(val == 4){
            $("#examMarkEnd").prop('disabled', false);
        }else {
            $("#examMarkEnd").prop('disabled', true);
            $("#examMarkEnd").val('');
        }
    });

    $("#PercentageEnd").prop('disabled', true);
    $(document).on('change', '#PercentageFilter', function(){
        var val = $(this).val();
        if(val == 4){
            $("#PercentageEnd").prop('disabled', false);
        }else {
            $("#PercentageEnd").prop('disabled', true);
            $("#PercentageEnd").val('');
        }
    });

    $("#SeniorityEnd").prop('disabled', true);
    $(document).on('change', '#SeniorityFilter', function(){
        var val = $(this).val();
        if(val == 4){
            $("#SeniorityEnd").prop('disabled', false);
        }else {
            $("#SeniorityEnd").prop('disabled', true);
            $("#SeniorityEnd").val('');
        }
    });

    $("#AttemptEnd").prop('disabled', true);
    $(document).on('change', '#AttemptFilter', function(){
        var val = $(this).val();
        if(val == 4){
            $("#AttemptEnd").prop('disabled', false);
        }else {
            $("#AttemptEnd").prop('disabled', true);
            $("#AttemptEnd").val('');
        }
    });

    $("#clearanceDateEnd").prop('disabled', true);
    $(document).on('change', '#clearanceDateFilter', function(){
        var val = $(this).val();
        if(val == 4){
            $("#clearanceDateEnd").prop('disabled', false);
        }else {
            $("#clearanceDateEnd").prop('disabled', true);
            $("#clearanceDateEnd").val('');
        }
    });

    $("#validDateEnd").prop('disabled', true);
    $(document).on('change', '#validDateFilter', function(){
        var val = $(this).val();
        if(val == 4){
            $("#validDateEnd").prop('disabled', false);
        }else {
            $("#validDateEnd").prop('disabled', true);
            $("#validDateEnd").val('');
        }
    });

    /*End exam Information section Javascript*/
    //$("#validDateEnd").prop('disabled', true);
    $(document).on('change', '#DOB_ID', function(){
        var val = $(this).val();
        if(val != ''){
           $("#DOBFORM_ID").prop('disabled', false); 
            if(val == 4){
                $("#DOBTO_ID").prop('disabled', false);
            }else{
                $("#DOBTO_ID").prop('disabled', true);
                $("#DOBTO_ID").val('');
            }
        }else {
            $("#DOBTO_ID").prop('disabled', true);
            $("#DOBFORM_ID").prop('disabled', true);
            $("#DOBTO_ID").val('');
            $("#DOBFORM_ID").val('');
        }
    });



    /*PDF, Excel, Word, print*/

    // html to word function
    function htmlToWord(html, filename='') {
        // Specify file name
        filename = filename?filename+'.doc':'document.doc';

        let header = "<html xmlns:o='urn:schemas-microsoft-com:office:office' "+
            "xmlns:w='urn:schemas-microsoft-com:office:word' "+
            "xmlns='http://www.w3.org/TR/REC-html40'>"+
            "<head><meta charset='utf-8'><title>Export HTML to Word Document</title></head><body>";
        let footer = "</body></html>";

        //let sourceHTML = header+document.getElementById("source-html").innerHTML+footer;
        let sourceHTML = header+html+footer;

        // Remove comments
        sourceHTML = sourceHTML = sourceHTML.replace(/<!--(?:.|\n)*?-->/gm, '');

        let source = 'data:application/vnd.ms-word;charset=utf-8,' + encodeURIComponent(sourceHTML);
        let fileDownload = document.createElement("a");
        document.body.appendChild(fileDownload);
        fileDownload.href = source;
        fileDownload.download = filename;
        fileDownload.click();
        document.body.removeChild(fileDownload);
    }

    // html to excel function
    function htmlToExcel(tableId,filename) {

        let table = tableId;
        let name = filename ? filename + '.xls' : 'Report.xls';

        let uri = 'data:application/vnd.ms-excel;base64,',
            template = '<html lang="en" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><title></title><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--><meta http-equiv="content-type" content="text/plain; charset=UTF-8"/></head>' +
                '<body><table>{table}</table></body></html>',
            base64 = function (s) {
                return window.btoa(decodeURIComponent(encodeURIComponent(s)))
            },
            format = function (s, c) {
                return s.replace(/{(\w+)}/g, function (m, p) {
                    return c[p];
                })
            };

        if (!table.nodeType) table = document.getElementById(table);
        var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML};

        var link = document.createElement('a');
        link.target='_blank';
        document.body.appendChild(link);  // You need to add this line
        link.download = name;
        link.href = uri + base64(format(template, ctx));
        link.click();
    }

    // html to pdf function
    function htmlToPdf(autoTableId='', fileName = '', headerHtmlId = '', footerHtmlId='', otherHtmlId = '' ) {
        //let doc = new jsPDF();
        let doc = new jsPDF('p', 'pt', 'a4', true);  //pt = px * .75

        let table = autoTableId ? ($("#"+autoTableId).get(0)) : document.getElementById("autoTableId");
        let newFileName = fileName ? (fileName + '.pdf') : 'report.pdf';
        let headerHtml = headerHtmlId ? ($("#"+headerHtmlId).get(0)) : document.getElementById("headerHtmlId");
        let footerHtml = footerHtmlId ? ($("#"+footerHtmlId).get(0)) : document.getElementById("footerHtmlId");
        let otherHtml = otherHtmlId ? ($("#"+otherHtmlId).get(0)) : document.getElementById("otherHtmlId");

        let startY = 300;
        let finalY = doc.previousAutoTable.finalY;
        /*let pageNumber = doc.internal.getNumberOfPages();
        doc.setPage(pageNumber);*/
        let totalPagesExp = "{total_pages_count_string}";

        // Document default options
        doc.autoTableSetDefaults({
            //headStyles: {fillColor: [155, 89, 182]}, // Purple, fillColor: 0
            //margin: {top: 25},
        });

        // Document margin list
        let margins = {mTop: 10, mBottom: 60, mLeft: 50, pTop: 10, pBottom: 60, pLeft: 50, width: 800};

        // Skip elements instead of display: none
        let specialElementHandlers = {
            '#skipElement': function (element,renderer) {
                return true;
            }
        };

        // Other content options
        let otherContentOptions = {
            'width': margins.width, //max width of content on PDF
            'elementHandlers': specialElementHandlers,
            'pagesplit': true,
        };

        // Header content options
        let header = function(data) {
            doc.setFontSize(18);
            doc.setTextColor(40);
            doc.setFontStyle('normal');

           headerHtml = '<div style="text-align: center;">' +
                            '<p style="width: 200px;">Main Header</p> ' +
                            '<p style="width: 200px;">Second Header</p>' +
                            '<p style="width: 200px;">Third Header</p>' +
                        '</div>';
            //doc.text('This is header', data.settings.margin.left + 15, 22);

            doc.fromHTML(
                headerHtml,
                //margins.mLeft, //x coord
               // margins.mTop, //y coord
                {
                    useCss: true,
                    margin: {left:0, right: 0},
                    align: "center"
                }
                //otherContentOptions, //options object
                //margins
            );
        };

        //header();

       /* let pageNumber = doc.internal.getNumberOfPages();
        if (pageNumber === 1) {

        }*/

        // Footer content options
        let footer = function(data) {
            let str = "Page " + doc.internal.getNumberOfPages();

            // Total page number plugin only available in jspdf v1.0+
            if (typeof doc.putTotalPages === 'function') {
                str = str + " of " + totalPagesExp;
            }
            doc.setFontSize(10);

            // jsPDF 1.4+ uses getWidth, <1.4 uses .width
            let pageSize = doc.internal.pageSize;
            let pageHeight = pageSize.height ? pageSize.height : pageSize.getHeight();
            doc.text(str, data.settings.margin.left, pageHeight - 10);

            // Total page number
            if (typeof doc.putTotalPages === 'function') {
                doc.putTotalPages(totalPagesExp);
            }
        };

        // Auto table content options
        let autoTableOptions = {
            html: table,
            startY: 100, //false
            //margin: {top: 30},
            theme: 'plain', //striped, plain, grid
            cellWidth: 'auto',
            useCss: true,
            //tableWidth: 'wrap',
            margin: {bottom:20},
            showHead: 'everyPage', //false, 'everyPage', 'firstPage'
            //tableLineWidth: .75,
            //tableLineColor: [0, 0, 0],
            styles: {
                fontSize: 10.5, //14px
                font: 'helvetica', //helvetica, times, courier
                lineColor: [0, 0, 0], //or single value ie. lineColor: 255,
                lineWidth: .75, //1px
                cellPadding: 1.5,
                textColor: [0, 0, 0],
                fillColor: [255, 255, 255], //false for transparent or number or array of number
                valign: 'middle', //top, middle, bottom
                halign: 'left', //left, center, right
                cellWidth: 'auto', //'auto', 'wrap' or a number
                overflow: 'visible', //visible, hidden, ellipsize or linebreak
                fontStyle: 'normal', //normal, bold, italic, bolditalic
                rowPageBreak: 'always', //always, auto, avoid
                useCss: true,
            },

            // Header & Footer
            didDrawPage: function (data) {
                // Header Content
                //let pageNumber = doc.internal.getNumberOfPages();
                if(data.pageNumber === 1) {
                    header(data);
                }

                // Footer Content
                footer(data);
            },
        };

        // Auto table with header content and footer page number
        doc.autoTable(autoTableOptions);

        // Footer content
        /*doc.fromHTML(
            footerHtml,
            margins.mLeft, //x coord
            margins.mTop, //y coord
           // otherContentOptions, //options object
            margins
        );*/


        // Output
        doc.save(newFileName);
        //doc.output("dataurlnewwindow");
    }

    // html to print function
    function htmlToPrint() {

    }

    /*End PDF, Excel, Word, print*/

</script>
