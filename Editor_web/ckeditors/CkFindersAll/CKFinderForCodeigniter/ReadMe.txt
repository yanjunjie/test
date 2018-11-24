I use this steps to add ckeditor to my codeigniter apps:

1) Download these files:

This for Ckeditor: http://pastebin.com/fkK9e0RR
This for Ckfinder: http://pastebin.com/SvyypmX4
2) Copy the files you just downloaded into your Application/libraries folder

3) Download the ckeditor helper here: http://pastebin.com/Cd3GqYbx

4) Copy the last file in application/helper folder as ckeditor_helper.php

5) Download the CKeditor controller here: http://pastebin.com/UD0bB9ig

6) Copy the controller in your application/controllers folder as ckeditor.php

7) Download the main ckeditor project from the official site: http://ckeditor.com/download/

8) Copy the ckeditor folder you just download into your asset folder (if you want you can also download the ckfinder project and put it in the same folder)

9) Add these line of js to your view file (adjust the path):

<script type="text/javascript" src="/asset/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="/asset/ckfinder/ckfinder.js"></script>
10) In your controller add this php code and adjust the path:

$this->load->library('ckeditor');
$this->load->library('ckfinder');



$this->ckeditor->basePath = base_url().'asset/ckeditor/';
$this->ckeditor->config['toolbar'] = array(
                array( 'Source', '-', 'Bold', 'Italic', 'Underline', '-','Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo','-','NumberedList','BulletedList' )
                                                    );
$this->ckeditor->config['language'] = 'it';
$this->ckeditor->config['width'] = '730px';
$this->ckeditor->config['height'] = '300px';            

//Add Ckfinder to Ckeditor
$this->ckfinder->SetupCKEditor($this->ckeditor,'../../asset/ckfinder/'); 
11) In your view print the editor with:

echo $this->ckeditor->editor("textarea name","default textarea value");

