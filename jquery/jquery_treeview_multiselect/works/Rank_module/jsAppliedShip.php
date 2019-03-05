<script>

    /*
    * @author   Bablu <bablu@atilimited.net>
    * @return   Ajax Modal, Tree View
    */
    $(document).ready(function () {
        let selectPickerId;
        let modal_body;

        // Ajax Modal
        $(document).on("click", ".cia_modal_btn", function (e) {
            e.preventDefault();
            e.stopPropagation();

            // find closest selectpicker
            selectPickerId = $(this).prev().find(".selectpicker").attr('id');
            let selectPickerIdAlt = $(this).prevAll('.selectpicker').attr('id');
            selectPickerId = selectPickerId ? selectPickerId : selectPickerIdAlt;


            //Default Settings
            let IdD = '';
            let tableD = "";
            let attrD = "";
            let actionD = "";
            let titleD = "";
            let modalTitleD = "";
            let headerBgD = "";
            let modalTypeD = "";
            let modalContentD = "";

            //Attributes:
            let dataId = $(this).attr('data-id');
            let dataTable = $(this).attr('data-table');
            let dataAttr = $(this).attr('data-attr');
            let dataAction = $(this).attr('data-action');
            let dataTitle = $(this).attr("title");
            //let dataModalTitle = $(this).attr("data-modal-title");
            let dataHeaderBg = $(this).attr("data-header-bg");
            let dataModalType = $(this).attr("data-modal-type");
            let dataModalContent = $(this).attr("data-modal-content");

            //Ajax Params:
            let id = dataId?dataId:(IdD?IdD:'');
            let table = dataTable?dataTable:(tableD?tableD:'');
            let attr = dataAttr?dataAttr:(attrD?attrD:'');
            let url = dataAction?dataAction:(actionD?actionD:'');
            let title = dataTitle?dataTitle:(titleD?titleD:'');
            //let modalTitle = dataModalTitle?dataModalTitle:(modalTitleD?modalTitleD:'');
            let headerBg = dataHeaderBg?dataHeaderBg:(headerBgD?headerBgD:'');
            let modalType = dataModalType?dataModalType:(modalTypeD?modalTypeD:'');
            let modalContent = dataModalContent?dataModalContent:(modalContentD?modalContentD:'');

            //Modal elements to show contents
            let cia_modal = $('.cia_modal');
            let modal_dialog = cia_modal.find('.modal-dialog');
            let modal_header = cia_modal.find('.modal-header');
            let modal_title = cia_modal.find('.modal-title');
                modal_body = cia_modal.find('.modal-body');
            let modal_footer = cia_modal.find('.modal-footer');

            //Set modal show/hide
            cia_modal.modal('toggle');

            //Set Modal Title
            if(title && (title!=null))
            {
                modal_title.html(title);
            }
            //Set Modal Header Background
            if(headerBg && (headerBg!=null))
            {
                modal_header.attr('class', 'modal-header');
                modal_header.addClass(headerBg);
            }
            //Set Modal Size
            if(modalType && (modalType!=null))
            {
                modal_dialog.attr('class', 'modal-dialog');
                modal_dialog.addClass(modalType);
            }
            //Set Form Data
            let formData = new FormData();
            formData.append('id',id);
            formData.append('table',table);
            formData.append('attr',attr);
            formData.append('modalContent',modalContent);

            $.ajax({
                type: 'post',
                url: url,
                data: formData,
                contentType: false,
                processData: false,
                async: false,
                beforeSend: function () {
                    modal_body.html("<img src='<?php echo base_url(); ?>dist/img/loader-small.gif' />");
                },
                success: function (data) {
                    modal_body.html(data);
                    $('.selectpicker').selectpicker();
                },
                error: function( req, status, err ) {
                    alert("Error! " + err + " (" + status + ") ");
                }
            });
        });

        // All checkbox select
        $(document).on('click','.chkAll',function () {
            // Fetch all child CheckBoxes.
            let chkboxes = $(this).closest('li').find("input:checkbox").not(':first');

            // Check each child CheckBox.
            if(this.checked) {
                chkboxes.each(function() {
                    this.checked = true;
                    $(this).attr("checked", "checked");
                });
            }else{
                chkboxes.each(function() {
                    this.checked = false;
                    $(this).removeAttr("checked");
                });
            }
        });

        // select value using tree
        $(document).on("click",".okBtn", function(){
            let values = (function() {
                let shipIds = [];
                $('input[name=ship_ids][checked=checked]').each(function() {
                    shipIds.push(this.value);
                });
                return shipIds;
            })();

            // select for ship applied
            // $("#APPLIEDSHIP_ID").val(values).change();
            $("#"+selectPickerId).val(values).change();
            $(".selectpicker").selectpicker('refresh');
        });

        // select value using tree using equivalent rank
        $(document).on("click",".equiRefresh", function(){
            let selectPickerId;
            // find closest selectpicker
            selectPickerId = $(this).prev().find(".selectpicker").attr('id');
            let selectPickerIdAlt = $(this).prevAll('.selectpicker').attr('id');
            selectPickerId = selectPickerId ? selectPickerId : selectPickerIdAlt;
            let equRankIds = $("#"+selectPickerId).val();

            let dataAction = $(this).attr('data-action');
            if(!dataAction)
                console.log("You don't set data action for ajax request");

            let formData = new FormData();
            formData.append('equRankIds',equRankIds);

            $.ajax({
                type: 'post',
                url: dataAction,
                data: formData,
                contentType: false,
                processData: false,
                async: false,
                success: function (data) {
                    modal_body.find('#treeArea').html(data);
                    if(equRankIds)
                        $('.chkAll').trigger('click');

                    $('.selectpicker').selectpicker();
                },
                error: function( req, status, err ) {
                    alert("Error! " + err + " (" + status + ") ");
                }
            });
        });

    });

</script>