<?php
///MySQL libraary for IfLib
##<sect><label id="mysqli_lib">/MySQL libraary for IfLib</>
##<sect1>Functions
#! TODO: Add handlers support

$GLOBALS['db_handle'] = null;


function SQLuq($string)
{
    if (get_magic_quotes_gpc() == 1) {
        $string = stripslashes($string);
    };
    return $string;
}

function SQLQuote($string)
{
    if (get_magic_quotes_gpc() == 1) {
        $string = stripslashes($string);
    };
    return "'" . mysqli_real_escape_string($GLOBALS['db_handle'], $string) . "'";
}

function SQLqu($string)
{
    return "'" . mysqli_real_escape_string($GLOBALS['db_handle'], $string) . "'";
}

function SQLGetLastErrno()
{
    global $L3_sql_lasterr;
    return $L3_sql_lasterr;
}

function SQLQuery($query, $dbh = 0)
{
//	var_dump($dbh);
    if (is_null($dbh) || $dbh === 0) $dbh = $GLOBALS['db_handle'];
    //add_to_log( "[dbh ".var_export($dbh, true)."]", "mysql" );
    ##Run SQL Query
    $r = mysqli_query($dbh, $query);
//    add_to_log("[QUERY $query]", "mysqli_log");
    $err = mysqli_error($dbh);

    if (!empty($err)) {
        $query = str_replace(array("\r", "\n", "\t"), array("", " ", ""), $query);
        add_to_log("[QUERY=$query][ERROR=$err]", "error_mysql");
    }

    return $r;
}


function SQLFree($handle)
{
## Free handle
    @mysqli_free_result($handle);
}

function SQLFetchRow($handle)
{

    return mysqli_fetch_array($handle);
}

function SQLFetchFields($handle)
{
## Fetch fields list
    return mysqli_fetch_fields($handle);
}

function SQLNumRows($handle)
{
## Return number of row in result set
    return mysqli_num_rows($handle);
}

function SQLNumFields($handle)
{
## Return number of fields in result set
    return mysqli_num_fields($handle);
}

function SQLConnect($params)
{
## Connect to MySQL database

    if (!isset($params['server'])) $params['server'] = 'localhost';
    $dbh = mysqli_connect($params['server'], $params['user'], $params['password'], $params['database']);
    $GLOBALS['db_handle'] = $dbh;
    return $dbh;
}

/**
 * @param $query
 * @param int $id
 * @return array|null
 */
function SQLGet($query, $id = 0)
{
    global $L3Config;
## Return hashe with one row of result set
    $h = SQLQuery($query, $id ? $id : $L3Config['db.link_id']);
    //$id==0 ? $h=SQLQuery( $query ) : $h=SQLQuery( $query, $id );
    $ret = SQLFetchRow($h);
    SQLFree($h);
    return $ret;
}

function SQLGetRows($query, $id = 0)
{
    $result = SQLQuery($query, $id);
    $rows = array();
    if (SQLNumRows($result)) {
        while ($row = SQLFetchRowAssoc($result)) {
            $rows[] = $row;
        }
    }
    SQLFree($result);
    return $rows;
}

function SQLInsId($h = 0)
{
## Return last insert ID (obsolete )
#    SQLError(SQLWarning, "This function does not supported now");
    $query = "SELECT LAST_INSERT_ID() AS LID";
    $result = SQLQuery($query, $h);

    $last_id = 0;

    if (SQLNumRows($result)) {
        $row = SQLFetchRow($result);
        $last_id = $row["LID"];
    }

    return $last_id;
}

function SQLDescribe($table, $id = 0)
{
## Return structure of table
    $q = SQLQuery("DESCRIBE $table", $id);
    while ($r = SQLFetchRow($q)) {
        $ret[$r['Field']] = $r;
    }
    SQLFree($q);
    return $ret;
}

function SQLRun($query, $params, $id = 0)
{
## For calling stored procedures
    SQLError(SQLError, "Function does not implemented yet");
}

function SQLInsert($table, $fields, $ident = 0)
{
## Return autoincrement field value or <0 if any errors.
## This function check internal triggers
    global $L3_sql_lasterr;
    $L3_sql_lasterr = 0;

    $query = "INSERT INTO $table \n( ";
    $values = ') VALUES (';
    reset($fields);
    $delim = ' ';
    while (list($name, $value) = each($fields)) {
        if (!is_long($name)) {
            $query .= $delim . $name;
            if (is_array($value)) {
                $values .= $delim . $value['raw'];
            } else {
                $values .= $delim . "'" . mysqli_real_escape_string($GLOBALS['db_handle'], $value) . "'";
            };
            $delim = ',';
        }
    }

    // echo "query_start=".$query.$values.")"."=query_end";

    if ($ident === 0) $ident = $GLOBALS['db_handle'];
    $q = SQLQuery($query . $values . ")", $ident);


    $err = mysqli_error($ident);
    if (!empty($err)) add_to_log($err, "error_mysql");
    $q1 = $query . $values;

    if (!$q) {
        return false;
    }

    $debug = debug_backtrace();
//    	print_r($debug["1"]);

    //add_to_log($query . $values . ")" . ";function is " . $debug["1"]['function'], "mysqli_log");

    if ($ident === 0) $ident = $GLOBALS['db_handle'];
    $id = mysqli_insert_id($ident);
    return $id;
}


function SQLReplace($table, $fields, $ident = 0)
{

    global $L3_sql_lasterr;
    $L3_sql_lasterr = 0;

    $query = "REPLACE INTO $table \n( ";
    $values = ') VALUES (';
    reset($fields);
    $delim = ' ';
    while (list($name, $value) = each($fields)) {
        if (!is_long($name)) {
            $query .= $delim . $name;
            if (is_array($value)) {
                $values .= $delim . $value['raw'];
            } else {
                $values .= $delim . "'" . mysqli_real_escape_string($GLOBALS['db_handle'], $value) . "'";
            };
            $delim = ',';
        }
    }


    $ident == 0 ? $q = SQLQuery($query . $values . ")") : $q = SQLQuery($query . $values . ")", $ident);


    $err = mysqli_error($ident);
    if (!empty($err)) add_to_log($err, "error_mysql");
    $q1 = $query . $values;

    if (!$q) {
        return false;
    }

    $debug = debug_backtrace();
//    	print_r($debug["1"]);

    //add_to_log($query . $values . ")" . ";function is " . $debug["1"]['function'], "mysqli_log");

    $ident == 0 ? $id = mysqli_insert_id() : $id = mysqli_insert_id($ident);
    return $id;
}

function SQLUpdate($table, $fields, $where = '', $id = 0)
{
## Returns number of affected rows (or >=0 in success) or <0 if error occured
    $query = "UPDATE $table SET ";
    $delim = ' ';
    while (list($name, $value) = each($fields)) {
        if (!is_long($name)) {
            if (is_array($value)) {
                $query .= $delim . $name . "=$value[raw]";
            } else {
                $query .= $delim . $name . "='" . mysqli_real_escape_string($GLOBALS['db_handle'], $value) . "' ";
            };
            $delim = ',';
        };
    };


    //add_to_log($query . $where, "mysqli_update");
    if ($id === 0) {
        $q = SQLQuery($query . $where);
        $err = mysqli_error();
        if (!empty($err)) add_to_log($err, "error_mysql");
        return mysqli_affected_rows();
    } else {
        $q = SQLQuery($query . $where, $id);
        $err = mysqli_error($id);
        if (!empty($err)) add_to_log($err, "error_mysql");
        return mysqli_affected_rows($id);
    };
}

function SQLFetchRowAssoc($handle)
{
## Fetch row

    return mysqli_fetch_assoc($handle);
}


?>
