<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Addcart extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		//load model
		$this->load->model('billing_model');
        $this->load->library('cart');
        $this->load->model('model_table', "mt", TRUE);
        $this->load->helper('form');
		date_default_timezone_set('Asia/Dhaka');
	}

	public function index(){	
        redirect("Administrator/products");
	}
	function purchaseTOcart(){
		 $sqlgetmodel = mysql_query("SELECT tbl_product.*, tbl_productcategory.* FROM tbl_product left join tbl_productcategory on tbl_productcategory.ProductCategory_SlNo= tbl_product.ProductCategory_ID Where tbl_product.Product_SlNo='".$this->input->post('id')."'");
         $rowmodel = mysql_fetch_array($sqlgetmodel);
		 $model = $rowmodel['ProductCategory_Name'];
		 $insert_data = array(
			'id' => $this->input->post('id'),
			'name' => $this->input->post('name'),
			'price' => $this->input->post('price'),
			'purchaserate' => $this->input->post('price'),
			'image' => $this->input->post('image'),
			'model' =>  $model,
			'gqty' => $this->input->post('gqty'),
			'qty' => $this->input->post('qty')
		);
		$this->cart->insert($insert_data);
		$this->load->view('Administrator/purchase/cartproduct');
	}
	
	function ajax_cart_remove() {
		$rowid = $this->input->post('rowid');
		if ($rowid==="all"){
			$this->cart->destroy();
		}
		else{
			$data = array(
				'rowid'   => $rowid,
				'qty'     => 0
			);
			$this->cart->update($data);
		}
		$this->load->view('Administrator/purchase/cartproduct');
	}
	function SalesTOcart(){
		 $sqlgetmodel = mysql_query("SELECT tbl_product.*, tbl_productcategory.*,tbl_produsize.* FROM tbl_product left join tbl_productcategory on tbl_productcategory.ProductCategory_SlNo= tbl_product.ProductCategory_ID left join tbl_produsize on tbl_produsize.Productsize_SlNo= tbl_product.sizeId Where tbl_product.Product_SlNo='".$this->input->post('ProID')."'");
         $rowmodel = mysql_fetch_array($sqlgetmodel);
		 $model = $rowmodel['ProductCategory_Name'];
		 $company_name = $rowmodel['company'];
		 $size = $rowmodel['Productsize_Name'];
		 
		$insert_data = array(
			'id' => $this->input->post('ProID'),
			'name' => $this->input->post('proName'),
			'model' => $model,
			'size' => $size,
			'price' => $this->input->post('ProRATe'),
            'company_name' => $company_name,
			'purchaserate' => $this->input->post('ProPurchaseRATe'),
			'packagename' => $this->input->post('packagename'),
			'packagecode' => $this->input->post('packagecode'),
			'image' => $this->input->post('unit'),
			'qty' => $this->input->post('proQTY')
		);
		$this->cart->insert($insert_data);
		$this->load->view('Administrator/sales/selseCArtlist');

	}

	function ajax_salsecart_remove() {
		$rowid = $this->input->post('rowid');
		if ($rowid==="all"){
			$this->cart->destroy();
		}
		else{
			$data = array(
				'rowid'   => $rowid,
				'qty'     => 0
			);
			$this->cart->update($data);
		}
		$this->load->view('Administrator/sales/selseCArtlist');
	}
	function cart_view(){
		$data ['title']= "Checkout";
		$data['products_page'] = $this->load->view('Administrator/checkout', $data, TRUE);
		$this->load->view('Administrator/index', $data);
    }
    function showcartAjax(){
		
		$this->load->view('Administrator/showcartAjax');
    }
    public function checkout(){
		$data['title'] = "Checkout";
		$data['sidebar'] = $this->load->view('Administrator/sidebar',$data,TRUE);
		$data['products_page'] = $this->load->view('Administrator/checkout',$data,TRUE);
		$this->load->view('Administrator/index',$data);
	}
	
	function remove($rowid) {
            // Check rowid value.
		if ($rowid==="all"){
            // Destroy data which store in  session.
			$this->cart->destroy();
			$this->session->unset_userdata('totalcart');
		}
		else{
            // Destroy selected rowid in session.
			$data = array(
				'rowid'   => $rowid,
				'qty'     => 0
			);
            // Update cart data, after cancle.
			$this->cart->update($data);
			$this->session->unset_userdata('totalcart');
		}
        // This will show cancle data in cart.
		redirect('shopping/checkout');
	}
	
	function update_cart(){
        // Recieve post values,calcute them and update
        $cart_info =  $_POST['cart'] ;
 		foreach( $cart_info as $id => $cart){	
            $rowid = $cart['rowid'];
            $price = $cart['price'];
            $amount = $price * $cart['qty'];
            $qty = $cart['qty'];
                    
                $data = array(
				'rowid'   => $rowid,
                'price'   => $price,
                'amount' =>  $amount,
				'qty'     => $qty
			);
			$this->cart->update($data);
		}
		redirect('shopping/checkout');        
	}
	public function order_success(){
    	$data ['title']= "Order Complete";
    	$data['sidebar'] = $this->load->view('Administrator/sidebar',$data,TRUE);
		$data['products_page'] = $this->load->view('Administrator/order_success', $data, TRUE);
		$this->load->view('Administrator/index', $data);
    }
    public function billing_view(){
    	$idd = $this->session->userdata('LogiinSession');
    	if($idd ==NULL){
    		$data ['title']= "Billing Page";
			$data['sidebar'] = $this->load->view('Administrator/sidebar',$data,TRUE);
        	$data['products_page'] = $this->load->view('Administrator/billing_page',$data,TRUE);
			$this->load->view('Administrator/index', $data);
    	}else{
    		redirect("shopping/billing_view_2");
    	}
    	
    }
    public function billing_view_2(){
    	$data ['title']= "Billing Page";
    	$data['sidebar'] = $this->load->view('Administrator/sidebar',$data,TRUE);
		$data['products_page'] = $this->load->view('Administrator/billing_page2', $data, TRUE);
		$this->load->view('Administrator/index', $data);
    }
    public function save_order(){
    	if (!empty($_SERVER['HTTP_CLIENT_IP'])){
          $ip=$_SERVER['HTTP_CLIENT_IP'];
        //Is it a proxy address
        }elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
          $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
        }else{
          $ip=$_SERVER['REMOTE_ADDR'];
        }
        
			$customer = array(
				"fld_fullname"          =>$this->input->post('fullname'),
	            "fld_password"          =>md5($this->input->post('password')),
	            "fld_email"          =>$this->input->post('email'),
	            "fld_address"          =>$this->input->post('address'),
	            "fld_phone"          =>$this->input->post('phone'),
	            "customer_ip"          =>$ip
			);		
	        // And store user imformation in database.
	        $cust_id = $this->billing_model->insert_customer($customer);
		
		$query = mysql_query("SELECT * from order_tbl order by fld_id desc limit 1");
		$row = mysql_fetch_array($query);

		$orderserial = "1000".$row['fld_id'];
		$order = array(
			'date' 			=> date('m/d/Y'),
			'customer_id' 	=> $cust_id,
			'payment' 		=> $this->input->post('payment'),
			'orderserial' 		=> $orderserial
		);
		$ord_id = $this->billing_model->insert_order($order);
		
		if ($cart = $this->cart->contents()):
			foreach ($cart as $item):
				$order_detail = array(
					'orderid' 		=> $ord_id,
					'productid' 	=> $item['id'],
					'quantity' 		=> $item['qty'],
					'price' 		=> $item['price'],
					'image' 		=> $item['image']

				);
                // Insert product imformation with order detail, store in cart also store in database. 
                $cust_id = $this->billing_model->insert_order_detail($order_detail);
			endforeach;
		endif;
        // After storing all imformation in database load "billing_success".
        $this->cart->destroy();
		redirect('shopping/order_success');
	}
	public function Loginsave_order(){
    	if (!empty($_SERVER['HTTP_CLIENT_IP'])){
          $ip=$_SERVER['HTTP_CLIENT_IP'];
        //Is it a proxy address
        }elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
          $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
        }else{
          $ip=$_SERVER['REMOTE_ADDR'];
        }
        $id = $this->input->post('orderID');
        $query = mysql_query("SELECT * from customer where fld_id = '$id'");
        $check = mysql_fetch_array($query);
        //$iidd = $check['fld_id'];
        if($query){$cust_id = $id;}

		$query = mysql_query("SELECT * from order_tbl order by fld_id desc limit 1");
		$row = mysql_fetch_array($query);

		$orderserial = "1000".$row['fld_id'];
		$order = array(
			'date' 			=> date('m/d/Y'),
			'customer_id' 	=> $cust_id,
			'payment' 		=> $this->input->post('payment'),
			'orderserial' 	=> $orderserial
		);
		$ord_id = $this->billing_model->insert_order($order);
		
		if ($cart = $this->cart->contents()):
			foreach ($cart as $item):
				$order_detail = array(
					'orderid' 		=> $ord_id,
					'productid' 	=> $item['id'],
					'quantity' 		=> $item['qty'],
					'price' 		=> $item['price'],
					'image' 		=> $item['image']
				);
                // Insert product imformation with order detail, store in cart also store in database. 
                $cust_id = $this->billing_model->insert_order_detail($order_detail);
			endforeach;
		endif;
        // After storing all imformation in database load "billing_success".
        $this->cart->destroy();
		redirect('shopping/order_success');
	}
	public function Back() {
           $rowid = $this->input->post('rowid');
		if ($rowid==="all"){
            // Destroy data which store in  session.
			$this->cart->destroy();
			$this->session->unset_userdata('totalcart');
		}
		else{
            // Destroy selected rowid in session.
			$data = array(
				'rowid'   => $rowid,
				'qty'     => 0
			);
            // Update cart data, after cancle.
			$this->cart->update($data);
		}
		redirect(base_url());
	}
	public function PurchacLoginCheck(){
		if (!empty($_SERVER['HTTP_CLIENT_IP'])){
          $ip=$_SERVER['HTTP_CLIENT_IP'];
        //Is it a proxy address
        }elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
          $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
        }else{
          $ip=$_SERVER['REMOTE_ADDR'];
        }
    	$data['title'] = ' Login';
        $user =mysql_real_escape_string($this->input->post('login_email'));
        $pass = md5($this->input->post('login_pass'));
        $x = "SELECT * from customer where fld_email ='$user' AND fld_password ='$pass'";
        $sql = mysql_query($x);
        $d = mysql_fetch_array($sql); 

        if($d['cusStatus'] == "2"){
            $sdata['LogiinSession'] = $d['fld_id'];
            $sdata['ID'] = $d['fld_id'];
            $sdata['name'] = $d['fld_fullname'];
            $sdata['NaMe'] = $d['fld_fullname'];
            $sdata['email'] = $d['fld_email'];
            $sdata['address'] = $d['fld_address'];
            $sdata['phone'] = $d['fld_phone'];
            $sdata['customer_ip'] = $ip;
            $this->session->set_userdata($sdata);
            redirect('shopping/billing_view_2');
        }
        else{
            $data['title'] = 'Billing Page';
            $data['staa'] = "Invalid Email or Password";
            $data['sidebar'] = $this->load->view('Administrator/sidebar',$data,TRUE);
        	$data['products_page'] = $this->load->view('Administrator/billing_page',$data,TRUE);
			$this->load->view('Administrator/index', $data);
        }
    }
    
    public function customerLogin(){
		
    	$data['title'] = ' Login';
        $user =mysql_real_escape_string($this->input->post('login_email'));
        $pass = md5($this->input->post('login_pass'));
        $x = "SELECT * from customer where fld_email ='$user' AND fld_password ='$pass'";
        $sql = mysql_query($x);
        $d = mysql_fetch_array($sql); 

        if($d['cusStatus'] == "2"){
            $sdata['LogiinSession'] = $d['fld_id'];
            $sdata['ID'] = $d['fld_id'];
            $sdata['NaMe'] = $d['fld_fullname'];
            $this->session->set_userdata($sdata);
            redirect(base_url(),'refresh');
        }
        else{
            $data['title'] = ' Login';
            $data['sta'] = "Invalid Email or Password";
            $data['sidebar'] = $this->load->view('Administrator/sidebar',$data,TRUE);
            $data['products_page'] = $this->load->view('Administrator/create_an_account', $data, TRUE);
			$this->load->view('Administrator/index', $data);
        }
    }
    public function LogOut(){
        $this->session->unset_userdata('ID');
        $this->session->unset_userdata('LogiinSession');
        $this->session->unset_userdata('NaMe');
        redirect(base_url(), 'refresh');
    }
}
?>