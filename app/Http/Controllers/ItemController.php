<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    public function view(Request $request): Response
    {
        // initialize fields options
        $fields = [
            ['table' => 'items', 'name' => 'name', 'label' => 'Name', 'type' => 'text'],
            ['table' => 'items', 'name' => 'category', 'label' => 'Category', 'type' => 'selection', 'options' => ['Movies', 'Books', 'Musics', 'Games']],
            ['table' => 'items', 'name' => 'quantity', 'label' => 'Quantity', 'type' => 'number'],
            ['table' => 'prices', 'name' => 'price', 'label' => 'Price', 'type' => 'number']
        ];

        // using inertia to render vue page
        return Inertia::render('QueryGenerator/App', [
            'fields' => $fields
        ]);
    }

    public function fetch(Request $request)
    {
        // get all post data
        $datas = $request->all();

        // initialize
        $params = [];
        $query = "
            SELECT 
                items.name, items.category, items.quantity, prices.price
            FROM items
            INNER JOIN prices ON prices.item_id = items.id
            WHERE 1=1
            %s
        ";
        // call convertToQuery function
        $condition = $this->convertToQuery($datas, $params);

        // add AND if condition not empty
        if (!empty($condition))
        {
            $condition = "AND " . $condition;
        }

        // concat query and condition to form a complete query
        $query = sprintf($query, $condition);

        // execute query using Eloquent ORM
        $items = DB::select(DB::raw($query), $params);

        // return the results
        return $items;
    }


    public function convertToQuery($data, &$params)
    {
        // Init
        $query = "";

        if ($data['type'] == "group")
        {
            // add open bracket
            $query .= "(";
            $ruleQuery = [];


            // do the looping to convert group data into query (because group have more than 1 data)
            foreach($data['data'] as $d)
            {
                // call convertToQuery (self) to do deep loop to search for rule data
                $resultQuery = $this->convertToQuery($d, $params);
                if (!empty($resultQuery))
                {
                    array_push($ruleQuery, $resultQuery);
                }
            }

            if (count($ruleQuery) > 0)
            {
                // join the rule query with group condition ("AND" or "OR")
                $query .= join(" " . $data['condition'] . " ", $ruleQuery) . ")";
            }
            else
            {
                $query = "";
            }

        }
        else
        {
            // use parameter to prevent SQL Injection or something simillar
            $totalParams = count($params);
            $param_name = "value_" . $totalParams;

            // build query using rule data
            $query .= $data['data']['table'] . "." . $data['data']['field'] . " " . $data['data']['type'] . " :" . $param_name;

            // set params value to be used when execute the query
            $params[$param_name] = $data['data']['value'];

            if ($data['data']['dataType'] == "integer")
            {
                // convert value to integer
                $params[$param_name] = (int)$params[$param_name];
            }
        }


        return $query;
    }
}
