<?php

///MySQL libraary for IfLib

##<sect><label id="MySQL_lib">/MySQL libraary for IfLib</>

##<sect1>Functions

#! TODO: Add handlers support



function SQLuq( $string ) {

    if( get_magic_quotes_gpc() == 1 ) {

	$string=stripslashes($string);

    };

    return $string;

}



function SQLQuote( $string ) {

    if( get_magic_quotes_gpc() == 1 ) {

	$string=stripslashes($string);

    };

    return "'".mysql_real_escape_string( $string )."'";

}

function SQLqu( $string ) {

    return "'".mysql_real_escape_string( $string )."'";

}



function SQLGetLastErrno() {

    global $L3_sql_lasterr;

    return $L3_sql_lasterr;

}

function SQLQuery( $query , $dbh=0) {

	##Run SQL Query

	$r = @mysql_query( $query, $dbh);

	

	$err = mysql_error($dbh);

	if( !empty($err) ) {

		$query=str_replace(array("\r","\n","\t"),array(""," ",""),$query);

		add_to_log( "[QUERY=$query][ERROR=$err]", "mysql_error" );

	}



	return $r;

}





function SQLFree( $handle ) {

## Free handle

    @mysql_free_result( $handle );

}



function SQLFetchRow( $handle ) {

## Fetch row

    global $L3_queris, $L3_queris;

    if( !$handle || ($handle==0) ) return;

    return mysql_fetch_array( $handle );

}



function SQLFetchFields( $handle ) {

## Fetch fields list

    return mysql_fetch_fields( $handle );

}



function SQLNumRows( $handle ) {

## Return number of row in result set
	if(!is_resource($handle)) return false;
    return mysql_num_rows( $handle );

}



function SQLNumFields( $handle ) {

## Return number of fields in result set

    return mysql_num_fields( $handle );

}



function SQLConnect($params) {

## Connect to MySQL database
    if(!isset($params['server'])) $params['server']='localhost';

    if( version_compare($ver=phpversion(),'4.2.0') >= 0 ) {

      $dbh=@mysql_connect( $params['server'] ,$params['user'],$params['password'], true );

    } else {

      $dbh=@mysql_connect( $params['server'] ,$params['user'],$params['password']);

    }

    if( isset( $params['database'] ) ){
        mysql_select_db( $params['database'] ,$dbh );
    }
    return $dbh;

}



function SQLGet($query, $id=0) {
    $h=SQLQuery( $query, $id );
    $ret=SQLFetchRow($h);
    SQLFree($h);
    return $ret;
}



function SQLGetRows($query,$id=0){
	$result=SQLQuery($query,$id);
	$rows=array();
	if(SQLNumRows($result)){
	   while($row=SQLFetchRowAssoc($result)){
			$rows[]=$row;
		}
	}
	SQLFree($result);
	return $rows;
}



function SQLInsId($h=0) {

## Return last insert ID (obsolete )

#    SQLError(SQLWarning, "This function does not supported now");

    if ($h==0) {

     return mysql_insert_id();

    } else {

     $query = "SELECT LAST_INSERT_ID() AS LID";

     $result=SQLQuery($query,$h);

     

     $last_id = 0;

     

     if(SQLNumRows($result)){

     	$row= SQLFetchRow($result);

     	$last_id = $row["LID"];

     	

     }

     	

     return $last_id;

    };

}



function SQLDescribe( $table , $id=0) {

## Return structure of table

    $q= SQLQuery("DESCRIBE $table", $id);

    while($r=SQLFetchRow($q) ) {

    $ret[$r['Field']]=$r;

    }

    SQLFree($q);

    return $ret;

}



function SQLRun( $query, $params , $id=0) {

## For calling stored procedures

    SQLError(SQLError, "Function does not implemented yet" );

}



function SQLInsert( $table, $fields, $ident=0) {

## Return autoincrement field value or <0 if any errors.

## This function check internal triggers

    global $L3_sql_lasterr;

    $L3_sql_lasterr=0;



    $query="INSERT INTO $table \n( ";

    $values=') VALUES (';

    reset($fields);

    $delim=' ';

    while( list($name, $value) = each( $fields ) ) {

        if( !is_long( $name ) ) {

        $query.=$delim.$name;

        if( is_array( $value ) ) {

        	$values.=$delim.$value['raw'];

        } else {

        	$values.=$delim."'".mysql_real_escape_string( $value )."'";

        };

        $delim=',';

        }

    }
    $ident==0 ? $q=SQLQuery( $query.$values.")" ) : $q=SQLQuery( $query.$values.")", $ident );
    $err = mysql_error($ident);
	if( !empty($err) ) add_to_log( $err, "mysql_error" );	
    $q1=$query.$values;
    if( !$q ) {
        return false;
    }
    $debug = debug_backtrace();
    add_to_log( $query.$values.")", "mysql_log" );
    $ident==0 ? $id=mysql_insert_id() : $id=mysql_insert_id($ident);
    return $id;
}





function SQLReplace( $table, $fields, $ident=0) {



    global $L3_sql_lasterr;

    $L3_sql_lasterr=0;



    $query="REPLACE INTO $table \n( ";

    $values=') VALUES (';

    reset($fields);

    $delim=' ';

    while( list($name, $value) = each( $fields ) ) {

        if( !is_long( $name ) ) {

        $query.=$delim.$name;

        if( is_array( $value ) ) {

        	$values.=$delim.$value['raw'];

        } else {

        	$values.=$delim."'".mysql_real_escape_string( $value )."'";

        };

        $delim=',';

        }

    }

   

    

    $ident==0 ? $q=SQLQuery( $query.$values.")" ) : $q=SQLQuery( $query.$values.")", $ident );



    



    $err = mysql_error($ident);

	if( !empty($err) ) add_to_log( $err, "mysql_error" );	

    $q1=$query.$values;



    if( !$q ) {

        return false;

    }



    	$debug = debug_backtrace();

//    	print_r($debug["1"]);

    	

    	add_to_log( $query.$values.")".";function is ".$debug["1"]['function'], "mysql_log" );



    $ident==0 ? $id=mysql_insert_id() : $id=mysql_insert_id($ident);

    return $id;

}



function SQLUpdate( $table, $fields, $where='' , $id=0) {

## Returns number of affected rows (or >=0 in success) or <0 if error occured

    $query="UPDATE $table SET ";

    $delim=' ';

    while( list($name, $value) = each( $fields ) ) {

        if( !is_long( $name ) ) {

        if( is_array( $value ) ) {

        	$query.=$delim.$name."=$value[raw]";

        } else {

        	$query.=$delim.$name."='".mysql_real_escape_string($value)."' ";

        };

        $delim=',';

        };

    };



    if ($id == 0){

    	$q=SQLQuery( $query.$where );

 		$err = mysql_error();

		if( !empty($err) ) add_to_log( $err, "mysql_error" );	   	

    	return mysql_affected_rows();

    } else {

    	$q=SQLQuery( $query.$where, $id );

 		$err = mysql_error($id);

		if( !empty($err) ) add_to_log( $err, "mysql_error" );    	

    	return mysql_affected_rows($id);

    };

}



function SQLFetchRowAssoc( $handle  ) {

## Fetch row

    global $L3_queris, $L3_queris;

    if( !$handle || ($handle==0) ) return;

    return mysql_fetch_assoc( $handle );

}



?>