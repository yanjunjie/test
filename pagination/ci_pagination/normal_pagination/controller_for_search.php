<?php
public function cari()
    {
        $key= $this->input->get('key'); //method get key
        $page=$this->input->get('per_page');  //method get per_page
 
        $search=array(
            'nama_brg'=> $key,
            'barcode'=> $key
        ); //array pencarian yang akan dibawa ke model
 
        $batas=5; //jlh data yang ditampilkan per halaman
        if(!$page):     //jika page bernilai kosong maka batas akhirna akan di set 0
           $offset = 0;
        else:
           $offset = $page; // jika tidak kosong maka nilai batas akhir nya akan diset nilai page terakhir
        endif;
 
        $config['page_query_string'] = TRUE; //mengaktifkan pengambilan method get pada url default
        $config['base_url'] = base_url().'barang/?key='.$key;   //url yang muncul ketika tombol pada paging diklik
        $config['total_rows'] = $this->mbarang->count_barang_search($search); // jlh total barang
        $config['per_page'] = $batas; //batas sesuai dengan variabel batas
 
        $config['uri_segment'] = $page; //merupakan posisi pagination dalam url pada kesempatan ini saya menggunakan method get untuk menentukan posisi pada url yaitu per_page
 
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = '&laquo; First';
        $config['first_tag_open'] = '<li class="prev page">';
        $config['first_tag_close'] = '</li>';
 
        $config['last_link'] = 'Last &raquo;';
        $config['last_tag_open'] = '<li class="next page">';
        $config['last_tag_close'] = '</li>';
 
        $config['next_link'] = 'Next &rarr;';
        $config['next_tag_open'] = '<li class="next page">';
        $config['next_tag_close'] = '</li>';
 
        $config['prev_link'] = '&larr; Prev';
        $config['prev_tag_open'] = '<li class="prev page">';
        $config['prev_tag_close'] = '</li>';
 
        $config['cur_tag_open'] = '<li class="current"><a href="">';
        $config['cur_tag_close'] = '</a></li>';
 
        $config['num_tag_open'] = '<li class="page">';
        $config['num_tag_close'] = '</li>';
        $this->pagination->initialize($config);
        $data['paging']=$this->pagination->create_links();
        $data['jlhpage']=$page;
 
        $data['title'] = 'CRUD CodeIgniter Studi Pencarian Kasus Barang'; //judul title
        $data['qbarang'] = $this->mbarang->get_allbarang($batas,$offset,$search); //query model semua barang
 
        $this->load->view('vbarang',$data);
 
    }