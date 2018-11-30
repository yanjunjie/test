<?php

//Datatable
    public function getAllArticle(Request $request)
    {
        // The columns variable is used for sorting
        $columns = array(
            // datatable column index => database column name
            0 => 'title',
            1 => 'id',
            2 => 'action',
        );
        $totalData = Article::count();   //Total record
        $totalFiltered = $totalData;     // No filter at first so we can assign like this
        //Offset and Limit
        $start = $request->input('start');    // Skip first start records
        $length = $request->input('length');  //  Get length record from start
        $order = $request->input('length');   //  Get length record from start
        /*
         * Order By
         */
        if ($request->has('order')) {
            if ($request->input('order.0.column') != '') {
                $orderColumn = $columns[$request->input('order.0.column')];
                $orderDirection = $request->input('order.0.dir');
            }
        }
        //Query
        $articles = Article::offset($start)
            ->limit($length)
            ->orderBy($orderColumn, $orderDirection)
            ->get();
        /*
         * For Data Search Query
         */
        if ($request->has('search')) {
            if ($request->input('search.value') != '') {
                /*
                * Seach clause : we only allow to search on first_name, last_name, and id field
                */
                //where ( 'users.user_name', 'Like', '%' . $searchTerm . '%' );
                $search = $request->input('search.value');
                $articles = Article::where('title', 'like', "%{$search}%")
                    ->offset($start)
                    ->limit($length)
                    ->orderBy($orderColumn, $orderDirection)
                    ->get();
                $totalFiltered = Article::where('title', 'like', "%{$search}%")
                    ->count();
            }
        }
        /*
        * We built the structure required by BootStrap datatables
        */
        $data = array ();
        foreach ($articles as $article ) {
            $nestedData = array ();
            $nestedData ['title'] = $article->title;   //$nestedData [0] = $user->user_name and so on
            $nestedData ['id'] = $article->id;
            $nestedData ['action'] ='
            <a href="'.route('article.edit', $article->id).'" class="btn btn-warning btn-xs">Edit</a>
            <form action="'.route('article.destroy', $article->id).'" method="post" style="display: inline;">'.csrf_field().method_field("DELETE").'<button onclick="return confirmDel();" class="btn btn-danger btn-xs"> Delete </button></form>
        ';
            $data [] = $nestedData;
        }
        /*
        * This below structure is required by Datatables
        */
        $json_data = array (
            "draw" => intval ( $request->input ( 'draw' ) ), // for every request/draw by clientside
            "recordsTotal" => intval ( $totalData ), // total number of records
            "recordsFiltered" => intval ( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
            "data" => $data
        );
        echo json_encode($json_data);
    }

