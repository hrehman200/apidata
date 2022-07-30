<?php
require_once __DIR__ . '/config.php';

## Read value
$draw = $_POST['draw'];
$row = $_POST['start'];
$rows_per_page = $_POST['length']; // Rows display per page
$column_index = $_POST['order'][0]['column']; // Column index
$column_name = $_POST['columns'][$column_index]['data']; // Column name
$column_sort_order = $_POST['order'][0]['dir']; // asc or desc
$search_term = $_POST['search']['value']; // Search value

## Search 
$search_query = " ";
if ($search_term != '') {
    if(is_numeric($search_term)) {
        $no = (int)$search_term;
        if($no < 20)
            $search_query = "and p.beds = ".$search_term;
        else
            $search_query = "and p.price like '%".$search_term."%'";
    } else if (strtolower($search_term) == 'sale' || strtolower($search_term) == 'rent') {
        $search_query = "and p.type = '" . $search_term . "'";
    } else {
        $search_query = " and (p.town like '%" . $search_term . "%' or 
            pt.title like '%" . $search_term . "%' ) ";
    }
}

## Total number of records without filtering
$result = $db->query("select count(*) as allcount 
    from " . TBL_PROPERTIES . " p
    LEFT JOIN " . TBL_PROPERTY_TYPES . " pt ON p.property_type_id = pt.id")->fetchAll();
$total_records = $result[0]['allcount'];

## Total number of record with filtering
$result = $db->query("select count(*) as allcount 
    FROM " . TBL_PROPERTIES . " p  
    LEFT JOIN " . TBL_PROPERTY_TYPES . " pt ON p.property_type_id = pt.id
    WHERE 1 " . $search_query)->fetchAll();
$total_records_w_filter = $result[0]['allcount'];

## Fetch records
$property_query = "select p.*, pt.title AS property_type
    FROM " . TBL_PROPERTIES . " p  
    LEFT JOIN " . TBL_PROPERTY_TYPES . " pt ON p.property_type_id = pt.id
    WHERE 1 " . $search_query . " ORDER BY " . $column_name . " " . $column_sort_order . " LIMIT " . $row . "," . $rows_per_page;
$data = $db->query($property_query)->fetchAll();

## Response
$response = array(
    "draw" => intval($draw),
    "iTotalRecords" => $total_records,
    "iTotalDisplayRecords" => $total_records_w_filter,
    "aaData" => $data
);

echo json_encode($response);
?>