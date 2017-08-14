<div class="content_scroll">
<h2>Sales Invoice</h2>
    <div style="width:100%; float:left;">
        <div style="border:1px solid #ddd">
            <table width="100%"> 
                <tr>
                    <td><strong>Invoice no</strong></td>
                    <td>
                        <div class="side-by-side clearfix">
                            <div>
                                <select id="SaleMasteriD" data-placeholder="Choose an Invoice..." class="chosen-select" style="width:250px;" tabindex="2" >
                                     <option value=""></option>
                                <?php $sql = mysql_query("SELECT * FROM tbl_salesmaster order by SaleMaster_InvoiceNo desc");
                                while($row = mysql_fetch_array($sql)){ ?>
                                <option value="<?php echo $row['SaleMaster_SlNo']; ?>"><?php echo $row['SaleMaster_InvoiceNo']; ?></option>
                                <?php } ?>
                            </select><input type="button" class="buttonAshiqe" onclick="searchforreturn()" value="Show Report">
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>

</div>
<div id="SalesInvoice"></div>
<script type="text/javascript">
  function searchforreturn(){
    var SaleMasteriD = $("#SaleMasteriD").val();
    if(SaleMasteriD==""){
      $("#SaleMasteriD").css('border-color','red');
      return false;
    }else{
        $("#SaleMasteriD").css('border-color','green');
    }
    var inputData = 'SaleMasteriD='+SaleMasteriD;
    var urldata = "<?php echo base_url();?>Administrator/sales/sales_invoice_search";
    $.ajax({
        type: "POST",
        url: urldata,
        data: inputData,
        success:function(data){
            $("#SalesInvoice").html(data);
        }
    });
  }
</script>