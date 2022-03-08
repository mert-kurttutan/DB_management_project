<?php 
require_once "pdo.php";

// the function to get current time

function get_cur_time($pdo){

    $stmt = $pdo->prepare("SELECT Time_t FROM CurrentTime");
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    return $row["Time_t"];
}

function to_date($MM, $DD, $YYYY, $hh, $mm, $ss){
    $selected_time = sprintf('%s-%s-%s %s:%s:%s', $YYYY, $MM, $DD, $hh, $mm, $ss);
    return $selected_time;
}

function seach_where_clause($where_dict){
    
    $where_list = array();
    foreach ($where_dict as $key => $value){
        $elem = (strlen($key) != 0) ? $value : '';
        array_push($where_list, $elem);
    }
    
    // filter out if there is empty string
    $where_string = implode(" AND ", array_filter($where_list));
    return $where_string;
}


// drop empty keys 
// pass by reference
function filter_dict(&$where_dict){
    foreach ($where_dict as $key => $value){
        if (strlen($value) == 0){
            unset($where_dict[$key]);
        }
    }
}


function get_column_names($pdo_mysql, $table_name){
    // get column names
    $rs = $pdo_mysql->query('SELECT * FROM '. $table_name .' LIMIT 0');
    for ($i = 0; $i < $rs->columnCount(); $i++) {
        $col = $rs->getColumnMeta($i);
        $columns[] = $col['name'];
    }
    return $columns;
}




?>