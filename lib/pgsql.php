<?php

/*
 *  SQL library; Postgres
 *  Copyright (C) 1999-2000 Inferno Group
 *	Alex Rozhik		<rozhik@ziet.zhitomir.ua>
 *	Valentine Danilchuk	<valdan@ziet.zhitomir.ua>
 *	Max Rudensky		<fonin@ziet.zhitomir.ua>
 *
 *  This library is free software; you can redistribute it and/or
 *  modify it under the terms of the GNU Library General Public
 *  License as published by the Free Software Foundation; either
 *  version 2 of the License, or (at your option) any later version.
 *
 *  This library is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 *  Library General Public License for more details.
 *
 *  You should have received a copy of the GNU Library General Public
 *  License along with this library; if not, write to the Free
 *  Software Foundation, Inc., 675 Mass Ave, Cambridge, MA 02139, USA.
 */

/*
 * $Id: pgsql.php,v 1.1.1.1 2001/01/25 08:25:51 rozhik Exp $
 */

/*
 * Globals:
 *	$db          - database
 *	$db_user     - user name
 *	$db_password - user password
 *	$db_server   - database server
 *	$dbh         - database handle
 */

/*
 * Function performs query to database and returns resource identifier
 */
function SQLQuery( $query , $dbh=0) {
    global $db,$queris,$querisn,$error_level,$curr_row,$result_hash;

    if( !isset( $querisn ) ) {
	$querisn=0;
    }
    $querisn=1+$querisn;
    $fields=-0;

    /* MySQL equivalent:
     *	 if( !($r=mysql_db_query($db, $query )) ) {
     * Notes:
     *	 $db was specified in SQLConnect;
     *	 $dbh (connection id) must be used
     */
    if( !($r=pg_exec($dbh, $query)) ) {
	if ($error_level>0) {
	    /* MySQL equivalent:
             *	 echo "<hr>SQL error (".mysql_error().")<br>in ($query) <hr>";
	     * Notes:
	     *  $dbh must be specified
	     */
	    echo "<hr>SQL error (".pg_ErrorMessage($dbh).")<br>in ($query) <hr>";
	}

	/* Same as above */
	$query.="\n*** ERROR ***\n".pg_ErrorMessage($dbh)."\n******\n";

	/* 
         * Not sure about this in Postgres...
	 *    $r=mysql_db_query($db, "select 'error' as error");
	 */
        $r=pg_exec($dbh, "select 'error' as error");
    }

    /*
     * Initialize $curr_row for SQLFetchRow function
     * (this is required by PostgreSQL)
     */

    $curr_row[$r] = 0;
    /*
     * MySQL equivalent:
     *	$rows=@@mysql_num_rows( $r );
     */
    $rows=@@pg_numrows( $r );

    /*
     * maintaining table $result_hash for sqlinsid()
     */
    if(eregi("insert",$query)) {
	list($f1,$f2)=split('into',$query);
	list($tablename,$bullshit)=split("\(",$f2);
	$result_hash[$r]=$tablename;
    }

    $queris.="\n=== Query #$querisn ==========================\n$query\nRows=$rows Fields=$fields\n";

    return $r;
}

/*
 * Function frees resources grabbed by SQLQuery
 */
function SQLFree( $handle ) {
    /*
     * MySQL equivalent:
     *	mysql_free_result( $handle );
     */
     pg_freeresult( $handle );
}

/*
 * Fetching row from SQLQuery response
 */
function SQLFetchRow( $handle ) {
    global $queris, $curr_row;
    if( !$handle || ($handle==0) ) {
	$queris.="\n*ERROR in sqlget\n";
	return;
    };

    /* MySQL equivalent:
     *	return mysql_fetch_array( $handle );
     * Notes:
     * PostgreSQL needs a row counter
     * $curr_row[$handle] is initialized in SQLQuery function
     */
    if(sqlnumrows($handle)>$curr_row[$handle]) {
	return pg_fetch_array( $handle, $curr_row[$handle]++ );
    }
}

/*
 * Fetching fields from SQLQuery response
 */
function SQLFetchFields( $handle ) {
    /* MySQL equivalent:
     *	return mysql_fetch_field( $handle );
     * Original:
     *  return mysql_fetch_fields( $handle );
     *                          ^ It seems that no one ever used it. %)
     * Notes:
     *  valdan> There seems to be no equivalent for Postgres... %(
     *  fonin>  You are wrong, what about pg_result() ?
     */
}

/*
 * Returns count of affected rows
 */
function SQLNumRows( $handle ) {
    /*
     * MySQL equivalent:
     *	return mysql_num_rows( $handle );
     */
    return pg_numrows( $handle );
}

/*
 * Returns count of affected fields
 */
function SQLNumFields( $handle ) {
    /*
     * MySQL equivalent:
     *  return mysql_num_fields( $handle );
     */
    return pg_numfields( $handle );
}

/*
 * Connect to Postgres database
 */
function SQLConnect($params) {
    global $db_server, $dbh, $db;
    /*
     * MySQL equivalent:
     *	$dbh=mysql_pconnect( $db_server,$db_user,$db_password );
     * Notes:
     *  $db_port should be defined;
     *  $db is used here
     */
    $connect="host=$params[server] port=$params[port] user=$params[user] dbname=$params[database]";
    if(isset($params['password']) && $params['password'] != '') {
	$connect.=" password=$params[password]";
    }
    $dbh=pg_pconnect($connect);
}

/*
 * Get the first row from SELECT
 */
function SQLGet($query) {
    $ret = "";
    $h   = SQLQuery( $query );
    /*
     * Bugsome code - tried to fix...
     *	$ret=SQLFetchRow($h);
     */
    if( SQLNumRows($h) > 0 ) {
	$ret=SQLFetchRow($h);
    }

    SQLFree($h);
    return $ret;
}

/*
 * Returns primary key of last INSERTed row
 */
function sqlinsid($result_id=0) {
    global $result_hash;

    /*
     * There are 2 limitations affected by current implementation:
     *	- sqlinsid() always must get $result_id as parameter (it is not 
     *	  required however for backward compatibility)
     *	- primary key field in all tables must be first by order
     */
    if(isset($result_hash[$result_id]) && $result_hash[$result_id] != '') {
	list($insid)=sqlget("
	    select * from $result_hash[$result_id]
	    where oid=".pg_getlastoid($result_id));
	return $insid;
    }

    return 0;
}

?>