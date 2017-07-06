
//Dynamic form field / dynamically add form field using jquery

//v.01
<script>
    $(document).ready(function() {
        var max_fields      = 10; //maximum input boxes allowed
        var wrapper         = $(".input_fields_wrap"); //Fields wrapper
        var add_button      = $(".add_field_button"); //Add button ID
        
        var x = 1; //initlal text box count
        $(add_button).click(function(e){ //on add input button click
            e.preventDefault();
            if(x < max_fields){ //max input box allowed
                x++; //text box increment
                $(wrapper).append('<div><input type="text" name="mytext[]"/><a href="#" class="remove_field">Remove</a></div>'); //add input box
            }
        });
        
        $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
            e.preventDefault(); $(this).parent('div').remove(); x--;
        })
    });
</script>

//HTML: 
<div class="input_fields_wrap">
    <button class="add_field_button">Add More Fields</button>
    <div><input type="text" name="mytext[]"></div>
</div>

//v.02
$('.selector').append("<input type='text'/>"); 
//OR
$("<input type='text' />").appendTo('.selector');

$(function() {

  // append input control at start of form
  $("<input type='text' value='' />")
     .attr("id", "myfieldid")
     .attr("name", "myfieldid")
     .prependTo("#form-0");

  // OR

  // append input control at end of form
  $("<input type='text' value='' />")
     .attr("id", "myfieldid")
     .attr("name", "myfieldid")
     .appendTo("#form-0");

  // OR

  // see .after() or .before() in the api.jquery.com library

});

//v.03 //Dynamically Add or Remove input fields in PHP with JQuery | Every single field data inserted seperately in db table
 
<form name="add_name" id="add_name">  
    <div class="table-responsive">  
        <table class="table table-bordered" id="dynamic_field">  
            <tr>  
                <td><input type="text" name="name[]" placeholder="Enter your Name" class="form-control name_list" /></td>  
                <td><button type="button" name="add" id="add" class="btn btn-success">Add More</button></td>  
            </tr>  
        </table>  
        <input type="button" name="submit" id="submit" class="btn btn-info" value="Submit" />  
    </div>  
</form>  
  
 <script>  
 $(document).ready(function(){  
      var i=1;  
      $('#add').click(function(){  
           i++;  
           $('#dynamic_field').append('<tr id="row'+i+'"><td><input type="text" name="name[]" placeholder="Enter your Name" class="form-control name_list" /></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');  
      });  
      $(document).on('click', '.btn_remove', function(){  
           var button_id = $(this).attr("id");   
           $('#row'+button_id+'').remove();  
      });  
      $('#submit').click(function(){            
           $.ajax({  
                url:"name.php",  
                method:"POST",  
                data:$('#add_name').serialize(),  
                success:function(data)  
                {  
                     alert(data);  
                     $('#add_name')[0].reset();  
                }  
           });  
      });  
 });  
 </script>

 //PHP Insert:
<?php  
 $connect = mysqli_connect("localhost", "root", "", "test_db");  
 $number = count($_POST["name"]);  
 if($number > 0)  
 {  
      for($i=0; $i<$number; $i++)  
      {  
           if(trim($_POST["name"][$i] != ''))  
           {  
                $sql = "INSERT INTO tbl_name(name) VALUES('".mysqli_real_escape_string($connect, $_POST["name"][$i])."')";  
                mysqli_query($connect, $sql);  
           }  
      }  
      echo "Data Inserted";  
 }  
 else  
 {  
      echo "Please Enter Name";  
 }  
?>

//v.04 Multiple Inline Insert into Mysql using Ajax JQuery in PHP
<div class="table-responsive">
    <table class="table table-bordered" id="crud_table">
        <tr>
          <th width="30%">Item Name</th>
          <th width="10%">Item Code</th>
          <th width="45%">Description</th>
          <th width="10%">Price</th>
          <th width="5%"></th>
        </tr>
        <tr>
          <td contenteditable="true" class="item_name"></td>
          <td contenteditable="true" class="item_code"></td>
          <td contenteditable="true" class="item_desc"></td>
          <td contenteditable="true" class="item_price"></td>
          <td></td>
        </tr>
    </table>
    <div align="right">
        <button type="button" name="add" id="add" class="btn btn-success btn-xs">+</button>
    </div>
    <div align="center">
        <button type="button" name="save" id="save" class="btn btn-info">Save</button>
    </div>
    <br />
    <div id="inserted_item_data"></div>
</div>
<script>
$(document).ready(function(){
    var count = 1;
    $('#add').click(function(){
        count = count + 1;
        var html_code = "<tr id='row"+count+"'>";
        html_code += "<td contenteditable='true' class='item_name'></td>";
        html_code += "<td contenteditable='true' class='item_code'></td>";
        html_code += "<td contenteditable='true' class='item_desc'></td>";
        html_code += "<td contenteditable='true' class='item_price' ></td>";
        html_code += "<td><button type='button' name='remove' data-row='row"+count+"' class='btn btn-danger btn-xs remove'>-</button></td>";   
        html_code += "</tr>";  
        $('#crud_table').append(html_code);
    });
 
    $(document).on('click', '.remove', function(){
        var delete_row = $(this).data("row");
        $('#' + delete_row).remove();
    });
 
    $('#save').click(function(){
        var item_name = [];
        var item_code = [];
        var item_desc = [];
        var item_price = [];
        $('.item_name').each(function(){
            item_name.push($(this).text());
        });
        $('.item_code').each(function(){
            item_code.push($(this).text());
        });
        $('.item_desc').each(function(){
            item_desc.push($(this).text());
        });
        $('.item_price').each(function(){
            item_price.push($(this).text());
        });
        $.ajax({
           url:"insert.php",
           method:"POST",
           data:{item_name:item_name, item_code:item_code, item_desc:item_desc, item_price:item_price},
            success:function(data){
                alert(data);
                $("td[contentEditable='true']").text("");
                for(var i=2; i<= count; i++){
                    $('tr#'+i+'').remove();
                }

                fetch_item_data();
            }
        });
    });
 
    function fetch_item_data(){
        $.ajax({
            url:"fetch.php",
            method:"POST",
            success:function(data){
                $('#inserted_item_data').html(data);
            }
        });
    }

    fetch_item_data();
});

</script>

//PHP Insert:
<?php
//insert.php
$connect = mysqli_connect("localhost", "root", "", "testing");
if(isset($_POST["item_name"]))
{
 $item_name = $_POST["item_name"];
 $item_code = $_POST["item_code"];
 $item_desc = $_POST["item_desc"];
 $item_price = $_POST["item_price"];
 $query = '';
 for($count = 0; $count<count($item_name); $count++)
 {
  $item_name_clean = mysqli_real_escape_string($connect, $item_name[$count]);
  $item_code_clean = mysqli_real_escape_string($connect, $item_code[$count]);
  $item_desc_clean = mysqli_real_escape_string($connect, $item_desc[$count]);
  $item_price_clean = mysqli_real_escape_string($connect, $item_price[$count]);
  if($item_name_clean != '' && $item_code_clean != '' && $item_desc_clean != '' && $item_price_clean != '')
  {
   $query .= '
   INSERT INTO item(item_name, item_code, item_description, item_price) 
   VALUES("'.$item_name_clean.'", "'.$item_code_clean.'", "'.$item_desc_clean.'", "'.$item_price_clean.'"); 
   ';
  }
 }
 if($query != '')
 {
  if(mysqli_multi_query($connect, $query))
  {
   echo 'Item Data Inserted';
  }
  else
  {
   echo 'Error';
  }
 }
 else
 {
  echo 'All Fields are Required';
 }
}
?>

//Fetch
<?php
//fetch.php
$connect = mysqli_connect("localhost", "root", "", "testing");
$output = '';
$query = "SELECT * FROM item ORDER BY item_id DESC";
$result = mysqli_query($connect, $query);
$output = '
<br />
<h3 align="center">Item Data</h3>
<table class="table table-bordered table-striped">
 <tr>
  <th width="30%">Item Name</th>
  <th width="10%">Item Code</th>
  <th width="50%">Description</th>
  <th width="10%">Price</th>
 </tr>
';
while($row = mysqli_fetch_array($result))
{
 $output .= '
 <tr>
  <td>'.$row["item_name"].'</td>
  <td>'.$row["item_code"].'</td>
  <td>'.$row["item_description"].'</td>
  <td>'.$row["item_price"].'</td>
 </tr>
 ';
}
$output .= '</table>';
echo $output;
?>

//Database
--
-- Table structure for table `item`
--

CREATE TABLE IF NOT EXISTS `item` (
  `item_id` int(11) NOT NULL,
  `item_name` varchar(250) NOT NULL,
  `item_code` varchar(250) NOT NULL,
  `item_description` text NOT NULL,
  `item_price` varchar(30) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`item_id`, `item_name`, `item_code`, `item_description`, `item_price`) VALUES
(1, 'Grease', 'HP38AST', 'General purpose Grease', '50'),
(2, 'Adhesive Epoxy', 'AS38DM33', 'Sealing epoxy', '20'),
(3, 'Connector 2 Way', 'PH848383', 'To be used for power supply connection in ABB Molding Machine', '500'),
(4, 'Laser Sensor', 'D383', 'Laser sensor for cutting machine', '10'),
(5, 'Power Supply 24V', 'D098', '24 Volt power supply for meter unit packing dept', '5'),
(6, 'V Belt 4', 'S34', 'V Belt for motor coupling drive used in milling machine, cutting machine, vibrator, seprator', '30'),
(7, 'Pressure Sensor', 'P38AST-3938B', 'Pressure sensor 4-20mA unit for storage tanks', '6'),
(8, 'LED Light Bulb', 'L24V3', '\n  LED ights', '100'),
(9, 'Item 1', 'Code1', 'Description1', '10'),
(10, 'Item 2', 'Code 2', 'Description 2', '20'),
(11, 'Item 3Â ', 'Code 3Â ', 'Description 3Â ', '30');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`item_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;

//v.05 with validation
<form id="surveyForm" method="post" class="form-horizontal">
    <div class="form-group">
        <label class="col-xs-3 control-label">Question</label>
        <div class="col-xs-5">
            <input type="text" class="form-control" name="question" />
        </div>
    </div>

    <div class="form-group">
        <label class="col-xs-3 control-label">Options</label>
        <div class="col-xs-5">
            <input type="text" class="form-control" name="option[]" />
        </div>
        <div class="col-xs-4">
            <button type="button" class="btn btn-default addButton"><i class="fa fa-plus"></i></button>
        </div>
    </div>

    <!-- The option field template containing an option field and a Remove button -->
    <div class="form-group hide" id="optionTemplate">
        <div class="col-xs-offset-3 col-xs-5">
            <input class="form-control" type="text" name="option[]" />
        </div>
        <div class="col-xs-4">
            <button type="button" class="btn btn-default removeButton"><i class="fa fa-minus"></i></button>
        </div>
    </div>

    <div class="form-group">
        <div class="col-xs-5 col-xs-offset-3">
            <button type="submit" class="btn btn-default">Validate</button>
        </div>
    </div>
</form>

<script>
$(document).ready(function() {
    // The maximum number of options
    var MAX_OPTIONS = 5;

    $('#surveyForm')
        .formValidation({
            framework: 'bootstrap',
            icon: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                question: {
                    validators: {
                        notEmpty: {
                            message: 'The question required and cannot be empty'
                        }
                    }
                },
                'option[]': {
                    validators: {
                        notEmpty: {
                            message: 'The option required and cannot be empty'
                        },
                        stringLength: {
                            max: 100,
                            message: 'The option must be less than 100 characters long'
                        }
                    }
                }
            }
        })

        // Add button click handler
        .on('click', '.addButton', function() {
            var $template = $('#optionTemplate'),
                $clone    = $template
                                .clone()
                                .removeClass('hide')
                                .removeAttr('id')
                                .insertBefore($template),
                $option   = $clone.find('[name="option[]"]');

            // Add new field
            $('#surveyForm').formValidation('addField', $option);
        })

        // Remove button click handler
        .on('click', '.removeButton', function() {
            var $row    = $(this).parents('.form-group'),
                $option = $row.find('[name="option[]"]');

            // Remove element containing the option
            $row.remove();

            // Remove field
            $('#surveyForm').formValidation('removeField', $option);
        })

        // Called after adding new field
        .on('added.field.fv', function(e, data) {
            // data.field   --> The field name
            // data.element --> The new field element
            // data.options --> The new field options

            if (data.field === 'option[]') {
                if ($('#surveyForm').find(':visible[name="option[]"]').length >= MAX_OPTIONS) {
                    $('#surveyForm').find('.addButton').attr('disabled', 'disabled');
                }
            }
        })

        // Called after removing the field
        .on('removed.field.fv', function(e, data) {
           if (data.field === 'option[]') {
                if ($('#surveyForm').find(':visible[name="option[]"]').length < MAX_OPTIONS) {
                    $('#surveyForm').find('.addButton').removeAttr('disabled');
                }
            }
        });
});
</script>

//v.06 with validation
<form id="bookForm" method="post" class="form-horizontal">
    <div class="form-group">
        <label class="col-xs-1 control-label">Book</label>
        <div class="col-xs-4">
            <input type="text" class="form-control" name="book[0].title" placeholder="Title" />
        </div>
        <div class="col-xs-4">
            <input type="text" class="form-control" name="book[0].isbn" placeholder="ISBN" />
        </div>
        <div class="col-xs-2">
            <input type="text" class="form-control" name="book[0].price" placeholder="Price" />
        </div>
        <div class="col-xs-1">
            <button type="button" class="btn btn-default addButton"><i class="fa fa-plus"></i></button>
        </div>
    </div>

    <!-- The template for adding new field -->
    <div class="form-group hide" id="bookTemplate">
        <div class="col-xs-4 col-xs-offset-1">
            <input type="text" class="form-control" name="title" placeholder="Title" />
        </div>
        <div class="col-xs-4">
            <input type="text" class="form-control" name="isbn" placeholder="ISBN" />
        </div>
        <div class="col-xs-2">
            <input type="text" class="form-control" name="price" placeholder="Price" />
        </div>
        <div class="col-xs-1">
            <button type="button" class="btn btn-default removeButton"><i class="fa fa-minus"></i></button>
        </div>
    </div>

    <div class="form-group">
        <div class="col-xs-5 col-xs-offset-1">
            <button type="submit" class="btn btn-default">Submit</button>
        </div>
    </div>
</form>

<script>
$(document).ready(function() {
    var titleValidators = {
            row: '.col-xs-4',   // The title is placed inside a <div class="col-xs-4"> element
            validators: {
                notEmpty: {
                    message: 'The title is required'
                }
            }
        },
        isbnValidators = {
            row: '.col-xs-4',
            validators: {
                notEmpty: {
                    message: 'The ISBN is required'
                },
                isbn: {
                    message: 'The ISBN is not valid'
                }
            }
        },
        priceValidators = {
            row: '.col-xs-2',
            validators: {
                notEmpty: {
                    message: 'The price is required'
                },
                numeric: {
                    message: 'The price must be a numeric number'
                }
            }
        },
        bookIndex = 0;

    $('#bookForm')
        .formValidation({
            framework: 'bootstrap',
            icon: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                'book[0].title': titleValidators,
                'book[0].isbn': isbnValidators,
                'book[0].price': priceValidators
            }
        })

        // Add button click handler
        .on('click', '.addButton', function() {
            bookIndex++;
            var $template = $('#bookTemplate'),
                $clone    = $template
                                .clone()
                                .removeClass('hide')
                                .removeAttr('id')
                                .attr('data-book-index', bookIndex)
                                .insertBefore($template);

            // Update the name attributes
            $clone
                .find('[name="title"]').attr('name', 'book[' + bookIndex + '].title').end()
                .find('[name="isbn"]').attr('name', 'book[' + bookIndex + '].isbn').end()
                .find('[name="price"]').attr('name', 'book[' + bookIndex + '].price').end();

            // Add new fields
            // Note that we also pass the validator rules for new field as the third parameter
            $('#bookForm')
                .formValidation('addField', 'book[' + bookIndex + '].title', titleValidators)
                .formValidation('addField', 'book[' + bookIndex + '].isbn', isbnValidators)
                .formValidation('addField', 'book[' + bookIndex + '].price', priceValidators);
        })

        // Remove button click handler
        .on('click', '.removeButton', function() {
            var $row  = $(this).parents('.form-group'),
                index = $row.attr('data-book-index');

            // Remove fields
            $('#bookForm')
                .formValidation('removeField', $row.find('[name="book[' + index + '].title"]'))
                .formValidation('removeField', $row.find('[name="book[' + index + '].isbn"]'))
                .formValidation('removeField', $row.find('[name="book[' + index + '].price"]'));

            // Remove element containing the fields
            $row.remove();
        });
});
</script>

//v.07 with validation
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.min.css" />
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker3.min.css" />
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.min.js"></script>

<form id="taskForm" method="post" class="form-horizontal">
    <div class="form-group">
        <label class="col-xs-1 control-label">Task(s)</label>
        <div class="col-xs-6">
            <input type="text" class="form-control" name="task[]" placeholder="Task" />
        </div>
        <div class="col-xs-4 dateContainer">
            <div class="input-group input-append date" id="dueDatePicker">
                <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                <input type="text" class="form-control" name="dueDate[]" placeholder="Due date" />
            </div>
        </div>
        <div class="col-xs-1">
            <button type="button" class="btn btn-default addButton"><i class="fa fa-plus"></i></button>
        </div>
    </div>

    <!-- The template for adding new field -->
    <div class="form-group hide" id="taskTemplate">
        <div class="col-xs-6 col-xs-offset-1">
            <input type="text" class="form-control" name="task[]" placeholder="Task" />
        </div>
        <div class="col-xs-4 dateContainer">
            <div class="input-group input-append date">
                <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                <input type="text" class="form-control" name="dueDate[]" placeholder="Due date" />
            </div>
        </div>
        <div class="col-xs-1">
            <button type="button" class="btn btn-default removeButton"><i class="fa fa-minus"></i></button>
        </div>
    </div>

    <div class="form-group">
        <div class="col-xs-5 col-xs-offset-1">
            <button type="submit" class="btn btn-default">Submit</button>
        </div>
    </div>
</form>

<script>
$(document).ready(function() {
    // Initialize the date picker for the original due date field
    $('#dueDatePicker')
        .datepicker({
            format: 'yyyy/mm/dd'
        })
        .on('changeDate', function(evt) {
            // Revalidate the date field
            $('#taskForm').formValidation('revalidateField', $('#dueDatePicker').find('[name="dueDate[]"]'));
        });

    $('#taskForm')
        .formValidation({
            framework: 'bootstrap',
            icon: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                'task[]': {
                    // The task is placed inside a .col-xs-6 element
                    row: '.col-xs-6',
                    validators: {
                        notEmpty: {
                            message: 'The task is required'
                        }
                    }
                },
                'dueDate[]': {
                    // The due date is placed inside a .col-xs-4 element
                    row: '.col-xs-4',
                    validators: {
                        notEmpty: {
                            message: 'The due date is required'
                        },
                        date: {
                            format: 'YYYY/MM/DD',
                            min: new Date(),
                            message: 'The due date is not valid'
                        }
                    }
                }
            }
        })

        .on('added.field.fv', function(e, data) {
            if (data.field === 'dueDate[]') {
                // The new due date field is just added
                // Create a new date picker
                data.element
                    .parent()
                    .datepicker({
                        format: 'yyyy/mm/dd'
                    })
                    .on('changeDate', function(evt) {
                        // Revalidate the date field
                        $('#taskForm').formValidation('revalidateField', data.element);
                    });
            }
        })

        // Add button click handler
        .on('click', '.addButton', function() {
            var $template = $('#taskTemplate'),
                $clone    = $template
                                .clone()
                                .removeClass('hide')
                                .removeAttr('id')
                                .insertBefore($template);

            // Add new fields
            // Note that we DO NOT need to pass the set of validators
            // because the new field has the same name with the original one
            // which its validators are already set
            $('#taskForm')
                .formValidation('addField', $clone.find('[name="task[]"]'))
                .formValidation('addField', $clone.find('[name="dueDate[]"]'))
        })

        // Remove button click handler
        .on('click', '.removeButton', function() {
            var $row = $(this).closest('.form-group');

            // Remove fields
            $('#taskForm')
                .formValidation('removeField', $row.find('[name="task[]"]'))
                .formValidation('removeField', $row.find('[name="dueDate[]"]'));

            // Remove element containing the fields
            $row.remove();
        });
});
</script>



