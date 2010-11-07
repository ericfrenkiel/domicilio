<?php
function db_connect( )
{
	global $link;
	if ( isset( $link ) )
		return;
	$ip = "localhost";
	$user = "thedom_thedom";
	$pass = "ETP+}fViQKK_";
	$link = mysql_connect( $ip, $user, $pass );
	if ( !isset( $link ) || !$link )
	{
		if ( isset( $link ) )
			unset( $link );
		die( "No mysql server" );
	}
  mysql_select_db("thedom_info");
}

function db_close( )
{
	global $link;
	if ( !isset( $link ) )
		return;
	mysql_close( $link );
	unset( $link );
}

function db_escape( $s )
{
  db_connect( );
  return mysql_real_escape_string( $s );
}

function db_fetch( $res )
{
  return mysql_fetch_row( $res );
}

function db_query( $query )
{
  db_connect( );
  $result = mysql_query($query);
  if ( !$result )
  {
  	$s = mysql_error( );
  	echo "<hr />Mysql error: " . htmlspecialchars($s) . "<hr />";
  }
  return $result;
}

function db_value( $query )
{
  $res = db_query( $query );
  if ( $arr = db_fetch( $res ) )
  	return idx($arr, 0);
  return null;
}

db_connect( );

?>
