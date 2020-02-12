<?php
if(!defined('__KIMS__')) exit;

//데이터
$_tmp = db_query( "select count(*) from ".$table[$module.'data'], $DB_CONNECT );
if ( !$_tmp ) {
$_tmp = ("

CREATE TABLE ".$table[$module.'data']." (
uid			    INT				PRIMARY KEY		NOT NULL AUTO_INCREMENT,
site		    INT				DEFAULT '0'		NOT NULL,
gid			    INT				DEFAULT '0'		NOT NULL,
mbruid		  INT				DEFAULT '0'		NOT NULL,
cid		      INT				DEFAULT '0'		NOT NULL,
subject		  VARCHAR(200)	DEFAULT ''		NOT NULL,
review		  VARCHAR(200)	DEFAULT ''		NOT NULL,
content		  MEDIUMTEXT		DEFAULT	''		NOT NULL,
tag			    VARCHAR(200)	DEFAULT ''		NOT NULL,
display		  TINYINT			DEFAULT '0'		NOT NULL,
hidden		  TINYINT			DEFAULT '0'		NOT NULL,
html		    VARCHAR(4)		DEFAULT ''		NOT NULL,
category		TEXT			NOT NULL,
member		  TEXT			NOT NULL,
upload		  TEXT			NOT NULL,
videos		  TEXT			NOT NULL,
featured_img    INT   DEFAULT '0'     NOT NULL,
comment		  INT				DEFAULT '0'		NOT NULL,
oneline		  INT				DEFAULT '0'		NOT NULL,
hit			    INT				DEFAULT '0'		NOT NULL,
likes			  INT				DEFAULT '0'		NOT NULL,
dislikes	  INT				DEFAULT '0'		NOT NULL,
rating		  INT				DEFAULT '0'		NOT NULL,
num_rating	INT				DEFAULT '0'		NOT NULL,
location		VARCHAR(200)	DEFAULT ''		NOT NULL,
pin		      VARCHAR(50)	DEFAULT ''		NOT NULL,
dis_like		TINYINT			DEFAULT '0'		NOT NULL,
dis_rating	TINYINT			DEFAULT '0'		NOT NULL,
dis_comment	TINYINT			DEFAULT '0'		NOT NULL,
dis_listadd	TINYINT			DEFAULT '0'		NOT NULL,
perm_g		VARCHAR(200)	DEFAULT ''		NOT NULL,
perm_l		TINYINT			DEFAULT '0'		NOT NULL,
format	TINYINT			DEFAULT '0'		NOT NULL,
d_regis		  VARCHAR(14)		DEFAULT ''		NOT NULL,
d_modify		VARCHAR(14)		DEFAULT ''		NOT NULL,
d_comment		VARCHAR(14)		DEFAULT ''		NOT NULL,
ip			    VARCHAR(25)	 	DEFAULT ''		NOT NULL,
agent	 	    VARCHAR(150)	DEFAULT ''		NOT NULL,
joint		    TEXT			NOT NULL,
linkedmenu	 	    VARCHAR(100)	DEFAULT ''		NOT NULL,
goods	 	    VARCHAR(200)	DEFAULT ''		NOT NULL,
log		      TEXT			NOT NULL,
adddata		  TEXT			NOT NULL,
KEY gid(gid),
KEY display(display),
KEY subject(subject),
KEY tag(tag),
KEY hit(hit),
KEY likes(likes),
KEY dislikes(dislikes),
KEY d_modify(d_modify),
KEY d_regis(d_regis)) ENGINE=".$DB['type']." CHARSET=UTF8MB4");
db_query($_tmp, $DB_CONNECT);
db_query("OPTIMIZE TABLE ".$table[$module.'data'],$DB_CONNECT);
}

//리스트 인덱스
$_tmp = db_query( "select count(*) from ".$table[$module.'list_index'], $DB_CONNECT );
if ( !$_tmp ) {
$_tmp = ("

CREATE TABLE ".$table[$module.'list_index']." (
site		  INT				DEFAULT '0'		NOT NULL,
list	INT				DEFAULT '0'		NOT NULL,
display		TINYINT		DEFAULT '0'		NOT NULL,
data			INT				DEFAULT '0'		NOT NULL,
gid			  INT				DEFAULT '0'		NOT NULL,
mbruid		  INT				DEFAULT '0'		NOT NULL,
KEY site(site),
KEY list(list),
KEY data(data),
KEY gid(gid)) ENGINE=".$DB['type']." CHARSET=UTF8MB4");
db_query($_tmp, $DB_CONNECT);
db_query("OPTIMIZE TABLE ".$table[$module.'list_index'],$DB_CONNECT);
}

//데이타 인덱스
$_tmp = db_query( "select count(*) from ".$table[$module.'index'], $DB_CONNECT );
if ( !$_tmp ) {
$_tmp = ("

CREATE TABLE ".$table[$module.'index']." (
site		  INT				DEFAULT '0'		NOT NULL,
display		TINYINT		DEFAULT '0'		NOT NULL,
format	TINYINT			DEFAULT '0'		NOT NULL,
gid			  INT				DEFAULT '0'		NOT NULL,
KEY site(site),
KEY display(display),
KEY format(format),
KEY gid(gid)) ENGINE=".$DB['type']." CHARSET=UTF8MB4");
db_query($_tmp, $DB_CONNECT);
db_query("OPTIMIZE TABLE ".$table[$module.'index'],$DB_CONNECT);
}

//카테고리 인덱스
$_tmp = db_query( "select count(*) from ".$table[$module.'category_index'], $DB_CONNECT );
if ( !$_tmp ) {
$_tmp = ("

CREATE TABLE ".$table[$module.'category_index']." (
site		  INT				DEFAULT '0'		NOT NULL,
category	INT				DEFAULT '0'		NOT NULL,
display		TINYINT		DEFAULT '0'		NOT NULL,
format	TINYINT			DEFAULT '0'		NOT NULL,
data			INT				DEFAULT '0'		NOT NULL,
gid			  INT				DEFAULT '0'		NOT NULL,
depth		TINYINT		DEFAULT '0'		NOT NULL,
KEY site(site),
KEY category(category),
KEY data(data),
KEY display(display),
KEY format(format),
KEY gid(gid)) ENGINE=".$DB['type']." CHARSET=UTF8MB4");
db_query($_tmp, $DB_CONNECT);
db_query("OPTIMIZE TABLE ".$table[$module.'category_index'],$DB_CONNECT);
}

//카테고리
$_tmp = db_query( "select count(*) from ".$table[$module.'category'], $DB_CONNECT );
if ( !$_tmp ) {
$_tmp = ("

CREATE TABLE ".$table[$module.'category']." (
uid			  INT				PRIMARY KEY		NOT NULL AUTO_INCREMENT,
gid			  INT				DEFAULT '0'		NOT NULL,
site		  INT				DEFAULT '0'		NOT NULL,
id		    VARCHAR(50)		DEFAULT ''		NOT NULL,
is_child  TINYINT			DEFAULT '0'		NOT NULL,
parent		INT				DEFAULT '0'		NOT NULL,
depth		  TINYINT			DEFAULT '0'		NOT NULL,
hidden		TINYINT			DEFAULT '0'		NOT NULL,
reject		TINYINT			DEFAULT '0'		NOT NULL,
name		  VARCHAR(50)		DEFAULT ''		NOT NULL,
layout		VARCHAR(50)		DEFAULT ''		NOT NULL,
layout_mobile		VARCHAR(50)		DEFAULT ''		NOT NULL,
skin		  VARCHAR(50)		DEFAULT ''		NOT NULL,
skin_mobile	VARCHAR(50)		DEFAULT ''		NOT NULL,
imghead		VARCHAR(100)	DEFAULT ''		NOT NULL,
imgfoot		VARCHAR(100)	DEFAULT ''		NOT NULL,
puthead		TINYINT			DEFAULT '0'		NOT NULL,
putfoot		TINYINT			DEFAULT '0'		NOT NULL,
recnum		INT				DEFAULT '0'		NOT NULL,
num			  INT				DEFAULT '0'		NOT NULL,
sosokmenu	VARCHAR(50)		DEFAULT ''		NOT NULL,
KEY gid(gid),
KEY parent(parent),
KEY depth(depth),
KEY hidden(hidden)) ENGINE=".$DB['type']." CHARSET=UTF8MB4");
db_query($_tmp, $DB_CONNECT);
db_query("OPTIMIZE TABLE ".$table[$module.'category'],$DB_CONNECT);
}

//멤버
$_tmp = db_query( "select count(*) from ".$table[$module.'member'], $DB_CONNECT );
if ( !$_tmp ) {
$_tmp = ("

CREATE TABLE ".$table[$module.'member']." (
mbruid		INT				DEFAULT '0'		NOT NULL,
site		    INT				DEFAULT '0'		NOT NULL,
gid			  INT				DEFAULT '0'		NOT NULL,
data			INT				DEFAULT '0'		NOT NULL,
display		  TINYINT			DEFAULT '0'		NOT NULL,
format	TINYINT			DEFAULT '0'		NOT NULL,
auth		  TINYINT			DEFAULT '0'		NOT NULL,
level		  TINYINT			DEFAULT '0'		NOT NULL,
d_regis		VARCHAR(14)		DEFAULT ''		NOT NULL,
KEY mbruid(mbruid),
KEY gid(gid),
KEY data(data),
KEY display(display),
KEY format(format),
KEY auth(auth),
KEY level(level)) ENGINE=".$DB['type']." CHARSET=UTF8MB4");
db_query($_tmp, $DB_CONNECT);
db_query("OPTIMIZE TABLE ".$table[$module.'member'],$DB_CONNECT);
}

//리스트
$_tmp = db_query( "select count(*) from ".$table[$module.'list'], $DB_CONNECT );
if ( !$_tmp ) {
$_tmp = ("

CREATE TABLE ".$table[$module.'list']." (
uid			INT				PRIMARY KEY		NOT NULL AUTO_INCREMENT,
gid			INT				DEFAULT '0'		NOT NULL,
site		INT				DEFAULT '0'		NOT NULL,
id			VARCHAR(30)		DEFAULT ''		NOT NULL,
name		VARCHAR(200)	DEFAULT ''		NOT NULL,
review  VARCHAR(300)	DEFAULT ''		NOT NULL,
mbruid			INT				DEFAULT '0'		NOT NULL,
display		  TINYINT			DEFAULT '0'		NOT NULL,
num		INT				DEFAULT '0'		NOT NULL,
tag		   VARCHAR(200)	DEFAULT ''		NOT NULL,
d_last		VARCHAR(14)		DEFAULT ''		NOT NULL,
d_regis		VARCHAR(14)		DEFAULT ''		NOT NULL,
imghead		VARCHAR(100)	DEFAULT ''		NOT NULL,
imgfoot		VARCHAR(100)	DEFAULT ''		NOT NULL,
puthead		VARCHAR(20)		DEFAULT ''		NOT NULL,
putfoot		VARCHAR(20)		DEFAULT ''		NOT NULL,
addinfo		TEXT			NOT NULL,
writecode	TEXT			NOT NULL,
KEY gid(gid),
KEY mbruid(mbruid),
KEY id(id)) ENGINE=".$DB['type']." CHARSET=UTF8MB4");
db_query($_tmp, $DB_CONNECT);
db_query("OPTIMIZE TABLE ".$table[$module.'list'],$DB_CONNECT);
}

//리스트 멤버
$_tmp = db_query( "select count(*) from ".$table[$module.'list_member'], $DB_CONNECT );
if ( !$_tmp ) {
$_tmp = ("

CREATE TABLE ".$table[$module.'list_member']." (
mbruid		INT				DEFAULT '0'		NOT NULL,
site		    INT				DEFAULT '0'		NOT NULL,
gid			  INT				DEFAULT '0'		NOT NULL,
list			INT				DEFAULT '0'		NOT NULL,
display		  TINYINT			DEFAULT '0'		NOT NULL,
auth		  TINYINT			DEFAULT '0'		NOT NULL,
level		  TINYINT			DEFAULT '0'		NOT NULL,
d_regis		VARCHAR(14)		DEFAULT ''		NOT NULL,
KEY mbruid(mbruid),
KEY gid(gid),
KEY list(list),
KEY display(display),
KEY auth(auth),
KEY level(level)) ENGINE=".$DB['type']." CHARSET=UTF8MB4");
db_query($_tmp, $DB_CONNECT);
db_query("OPTIMIZE TABLE ".$table[$module.'list_member'],$DB_CONNECT);
}

//포스트 월별수량
$_tmp = db_query( "select count(*) from ".$table[$module.'month'], $DB_CONNECT );
if ( !$_tmp ) {
$_tmp = ("

CREATE TABLE ".$table[$module.'month']." (
date		CHAR(6)			DEFAULT ''		NOT NULL,
site		INT				DEFAULT '0'		NOT NULL,
data			INT				DEFAULT '0'		NOT NULL,
hit			INT				DEFAULT '0'		NOT NULL,
likes			INT				DEFAULT '0'		NOT NULL,
dislikes			INT				DEFAULT '0'		NOT NULL,
comment			INT				DEFAULT '0'		NOT NULL,
mobile			INT				DEFAULT '0'		NOT NULL,
desktop			INT				DEFAULT '0'		NOT NULL,
inside			INT				DEFAULT '0'		NOT NULL,
outside			INT				DEFAULT '0'		NOT NULL,
yt			INT				DEFAULT '0'		NOT NULL,
kt			INT				DEFAULT '0'		NOT NULL,
ks			INT				DEFAULT '0'		NOT NULL,
bd			INT				DEFAULT '0'		NOT NULL,
ig			INT				DEFAULT '0'		NOT NULL,
fb			INT				DEFAULT '0'		NOT NULL,
tt			INT				DEFAULT '0'		NOT NULL,
nb			INT				DEFAULT '0'		NOT NULL,
KEY date(date),
KEY data(data),
KEY hit(hit),
KEY likes(likes),
KEY dislikes(dislikes),
KEY comment(comment),
KEY site(site)) ENGINE=".$DB['type']." CHARSET=UTF8MB4");
db_query($_tmp, $DB_CONNECT);
db_query("OPTIMIZE TABLE ".$table[$module.'month'],$DB_CONNECT);
}
//포스트 일별수량
$_tmp = db_query( "select count(*) from ".$table[$module.'day'], $DB_CONNECT );
if ( !$_tmp ) {
$_tmp = ("

CREATE TABLE ".$table[$module.'day']." (
date		CHAR(8)			DEFAULT ''		NOT NULL,
site		INT				DEFAULT '0'		NOT NULL,
data			INT				DEFAULT '0'		NOT NULL,
display		  TINYINT			DEFAULT '0'		NOT NULL,
hit			INT				DEFAULT '0'		NOT NULL,
likes			INT				DEFAULT '0'		NOT NULL,
dislikes			INT				DEFAULT '0'		NOT NULL,
comment			INT				DEFAULT '0'		NOT NULL,
mobile			INT				DEFAULT '0'		NOT NULL,
desktop			INT				DEFAULT '0'		NOT NULL,
inside			INT				DEFAULT '0'		NOT NULL,
outside			INT				DEFAULT '0'		NOT NULL,
yt			INT				DEFAULT '0'		NOT NULL,
kt			INT				DEFAULT '0'		NOT NULL,
ks			INT				DEFAULT '0'		NOT NULL,
bd			INT				DEFAULT '0'		NOT NULL,
ig			INT				DEFAULT '0'		NOT NULL,
fb			INT				DEFAULT '0'		NOT NULL,
tt			INT				DEFAULT '0'		NOT NULL,
nb			INT				DEFAULT '0'		NOT NULL,
KEY date(date),
KEY data(data),
KEY hit(hit),
KEY likes(likes),
KEY dislikes(dislikes),
KEY comment(comment),
KEY site(site)) ENGINE=".$DB['type']." CHARSET=UTF8MB4");
db_query($_tmp, $DB_CONNECT);
db_query("OPTIMIZE TABLE ".$table[$module.'day'],$DB_CONNECT);
}

?>
