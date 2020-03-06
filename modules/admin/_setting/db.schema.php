<?php
if(!defined('__KIMS__')) exit;


//모듈리스트
$_tmp = db_query( "select count(*) from ".$table['s_module'], $DB_CONNECT );
if ( !$_tmp ) {
$_tmp = ("

CREATE TABLE ".$table['s_module']." (
gid			INT				DEFAULT '0'		NOT NULL,
system		TINYINT			DEFAULT '0'		NOT NULL,
hidden		TINYINT			DEFAULT '0'		NOT NULL,
mobile		TINYINT			DEFAULT '0'		NOT NULL,
name		VARCHAR(200)	DEFAULT ''		NOT NULL,
id			VARCHAR(30)		DEFAULT ''		NOT NULL,
tblnum		INT				DEFAULT '0'		NOT NULL,
icon		VARCHAR(50)		DEFAULT ''		NOT NULL,
d_regis		VARCHAR(14)		DEFAULT ''		NOT NULL,
lang		VARCHAR(20)		DEFAULT ''		NOT NULL,
KEY gid(gid),
KEY system(system),
KEY hidden(hidden),
KEY mobile(mobile),
KEY id(id)) ENGINE=".$DB['type']." CHARSET=UTF8MB4");
db_query($_tmp, $DB_CONNECT);
db_query("OPTIMIZE TABLE ".$table['s_module'],$DB_CONNECT);
}

//관리자즐겨찾는페이지
$_tmp = db_query( "select count(*) from ".$table['s_admpage'], $DB_CONNECT );
if ( !$_tmp ) {
$_tmp = ("

CREATE TABLE ".$table['s_admpage']." (
uid			INT				PRIMARY KEY		NOT NULL AUTO_INCREMENT,
memberuid	INT				DEFAULT '0'		NOT NULL,
gid			INT				DEFAULT '0'		NOT NULL,
name		VARCHAR(200)	DEFAULT ''		NOT NULL,
url			VARCHAR(200)	DEFAULT ''		NOT NULL,
KEY memberuid(memberuid),
KEY gid(gid)) ENGINE=".$DB['type']." CHARSET=UTF8MB4");
db_query($_tmp, $DB_CONNECT);
db_query("OPTIMIZE TABLE ".$table['s_admpage'],$DB_CONNECT);
}

//모바일
$_tmp = db_query( "select count(*) from ".$table['s_mobile'], $DB_CONNECT );
if ( !$_tmp ) {
$_tmp = ("

CREATE TABLE ".$table['s_mobile']." (
usemobile	TINYINT			DEFAULT '0'		NOT NULL,
startsite	INT				DEFAULT '0'		NOT NULL,
startdomain	VARCHAR(50)		DEFAULT ''		NOT NULL
) ENGINE=".$DB['type']." CHARSET=UTF8MB4");
db_query($_tmp, $DB_CONNECT);
db_query("OPTIMIZE TABLE ".$table['s_mobile'],$DB_CONNECT);
}

//도메인
$_tmp = db_query( "select count(*) from ".$table['s_domain'], $DB_CONNECT );
if ( !$_tmp ) {
$_tmp = ("

CREATE TABLE ".$table['s_domain']." (
uid			INT				PRIMARY KEY		NOT NULL AUTO_INCREMENT,
gid			INT				DEFAULT '0'		NOT NULL,
is_child	TINYINT			DEFAULT '0'		NOT NULL,
parent		INT				DEFAULT '0'		NOT NULL,
depth		TINYINT			DEFAULT '0'		NOT NULL,
name		VARCHAR(100)	DEFAULT ''		NOT NULL,
site		INT				DEFAULT '0'		NOT NULL,
KEY gid(gid),
KEY parent(parent),
KEY depth(depth),
KEY name(name),
KEY site(site)) ENGINE=".$DB['type']." CHARSET=UTF8MB4");
db_query($_tmp, $DB_CONNECT);
db_query("OPTIMIZE TABLE ".$table['s_domain'],$DB_CONNECT);
}

//사이트
$_tmp = db_query( "select count(*) from ".$table['s_site'], $DB_CONNECT );
if ( !$_tmp ) {
$_tmp = ("

CREATE TABLE ".$table['s_site']." (
uid			INT				PRIMARY KEY		NOT NULL AUTO_INCREMENT,
gid			INT				DEFAULT '0'		NOT NULL,
id			VARCHAR(20)		DEFAULT ''		NOT NULL,
name		VARCHAR(50)		DEFAULT ''		NOT NULL,
label		VARCHAR(50)		DEFAULT ''		NOT NULL,
title		VARCHAR(100)	DEFAULT ''		NOT NULL,
titlefix	TINYINT			DEFAULT '0'		NOT NULL,
icon		VARCHAR(50)		DEFAULT ''		NOT NULL,
layout		VARCHAR(50)		DEFAULT ''		NOT NULL,
startpage	INT				DEFAULT '0'		NOT NULL,
m_layout	VARCHAR(50)		DEFAULT ''		NOT NULL,
m_startpage	INT				DEFAULT '0'		NOT NULL,
lang		VARCHAR(20)		DEFAULT ''		NOT NULL,
open		TINYINT			DEFAULT '0'		NOT NULL,
dtd			VARCHAR(20)		DEFAULT ''		NOT NULL,
nametype	VARCHAR(5)		DEFAULT ''		NOT NULL,
timecal		TINYINT			DEFAULT '0'		NOT NULL,
rewrite		TINYINT			DEFAULT '0'		NOT NULL,
buffer		TINYINT			DEFAULT '0'		NOT NULL,
usescode	TINYINT			DEFAULT '0'		NOT NULL,
headercode	TEXT			NOT NULL,
footercode	TEXT			NOT NULL,
KEY gid(gid),
KEY id(id),
KEY open(open)) ENGINE=".$DB['type']." CHARSET=UTF8MB4");
db_query($_tmp, $DB_CONNECT);
db_query("OPTIMIZE TABLE ".$table['s_site'],$DB_CONNECT);
}

//메뉴
$_tmp = db_query( "select count(*) from ".$table['s_menu'], $DB_CONNECT );
if ( !$_tmp ) {
$_tmp = ("

CREATE TABLE ".$table['s_menu']." (
uid			INT				PRIMARY KEY		NOT NULL AUTO_INCREMENT,
gid			INT				DEFAULT '0'		NOT NULL,
site		INT				DEFAULT '0'		NOT NULL,
is_child	TINYINT			DEFAULT '0'		NOT NULL,
parent		INT				DEFAULT '0'		NOT NULL,
depth		TINYINT			DEFAULT '0'		NOT NULL,
id			VARCHAR(50)		DEFAULT ''		NOT NULL,
menutype	TINYINT			DEFAULT '0'		NOT NULL,
mobile		TINYINT			DEFAULT '0'		NOT NULL,
hidden		TINYINT			DEFAULT '0'		NOT NULL,
reject		TINYINT			DEFAULT '0'		NOT NULL,
name		VARCHAR(50)		DEFAULT ''		NOT NULL,
target		VARCHAR(20)		DEFAULT ''		NOT NULL,
redirect	TINYINT			DEFAULT '0'		NOT NULL,
joint		VARCHAR(250)	DEFAULT ''		NOT NULL,
perm_g		VARCHAR(200)	DEFAULT ''		NOT NULL,
perm_l		TINYINT			DEFAULT '0'		NOT NULL,
layout		VARCHAR(50)		DEFAULT ''		NOT NULL,
m_layout	VARCHAR(50)		DEFAULT ''		NOT NULL,
imghead		VARCHAR(100)	DEFAULT ''		NOT NULL,
imgfoot		VARCHAR(100)	DEFAULT ''		NOT NULL,
addattr		VARCHAR(100)	DEFAULT ''		NOT NULL,
num			INT				DEFAULT '0'		NOT NULL,
d_last		VARCHAR(14)		DEFAULT ''		NOT NULL,
addinfo		TEXT			NOT NULL,
upload	TEXT			DEFAULT ''		NOT NULL,
imgicon		VARCHAR(100)	DEFAULT ''		NOT NULL,
KEY gid(gid),
KEY site(site),
KEY parent(parent),
KEY depth(depth),
KEY id(id),
KEY mobile(mobile),
KEY hidden(hidden)) ENGINE=".$DB['type']." CHARSET=UTF8MB4");
db_query($_tmp, $DB_CONNECT);
db_query("OPTIMIZE TABLE ".$table['s_menu'],$DB_CONNECT);
}

//페이지
$_tmp = db_query( "select count(*) from ".$table['s_page'], $DB_CONNECT );
if ( !$_tmp ) {
$_tmp = ("

CREATE TABLE ".$table['s_page']." (
uid			INT				PRIMARY KEY		NOT NULL AUTO_INCREMENT,
site		INT				DEFAULT '0'		NOT NULL,
pagetype	TINYINT			DEFAULT '0'		NOT NULL,
ismain		TINYINT			DEFAULT '0'		NOT NULL,
mobile		TINYINT			DEFAULT '0'		NOT NULL,
id			VARCHAR(50)		DEFAULT ''		NOT NULL,
category	VARCHAR(50)		DEFAULT ''		NOT NULL,
name		VARCHAR(200)	DEFAULT ''		NOT NULL,
perm_g		VARCHAR(200)	DEFAULT ''		NOT NULL,
perm_l		TINYINT			DEFAULT '0'		NOT NULL,
layout		VARCHAR(50)		DEFAULT ''		NOT NULL,
m_layout	VARCHAR(50)		DEFAULT ''		NOT NULL,
joint		VARCHAR(250)	DEFAULT ''		NOT NULL,
hit			INT				DEFAULT '0'		NOT NULL,
linkedmenu	VARCHAR(100)	DEFAULT ''		NOT NULL,
d_regis		VARCHAR(14)		DEFAULT ''		NOT NULL,
d_last	VARCHAR(14)		DEFAULT ''		NOT NULL,
upload	TEXT			DEFAULT ''		NOT NULL,
featured_img    INT   DEFAULT '0'     NOT NULL,
member		INT				DEFAULT '0'		NOT NULL,
extra		TEXT			DEFAULT ''		NOT NULL,
KEY site(site),
KEY ismain(ismain),
KEY mobile(mobile),
KEY id(id),
KEY category(category),
KEY linkedmenu(linkedmenu),
KEY d_regis(d_regis),
KEY d_last(d_last),
KEY member(member)) ENGINE=".$DB['type']." CHARSET=UTF8MB4");
db_query($_tmp, $DB_CONNECT);
db_query("OPTIMIZE TABLE ".$table['s_page'],$DB_CONNECT);
}


// 팝업
$_tmp = db_query( "select count(*) from ".$table['s_popup'], $DB_CONNECT );
if ( !$_tmp ) {
$_tmp = ("

CREATE TABLE ".$table['s_popup']." (
uid			INT				PRIMARY KEY		NOT NULL AUTO_INCREMENT,
hidden		TINYINT			DEFAULT '0'		NOT NULL,
admin 		TINYINT			DEFAULT '0'		NOT NULL,
term0		TINYINT			DEFAULT '0'		NOT NULL,
term1		VARCHAR(14)		DEFAULT ''		NOT NULL,
term2		VARCHAR(14)		DEFAULT ''		NOT NULL,
name		VARCHAR(50)		DEFAULT ''		NOT NULL,
content		TEXT			NOT NULL,
m_content		TEXT			NOT NULL,
html		VARCHAR(4)		DEFAULT ''		NOT NULL,
m_html		VARCHAR(4)		DEFAULT ''		NOT NULL,
upload		TEXT			NOT NULL,
m_upload		TEXT			NOT NULL,
position		VARCHAR(10)		DEFAULT ''		NOT NULL,
center		TINYINT			DEFAULT '0'		NOT NULL,
ptop		INT				DEFAULT '0'		NOT NULL,
pleft		INT				DEFAULT '0'		NOT NULL,
width		INT				DEFAULT '0'		NOT NULL,
draggable		TINYINT			DEFAULT '0'		NOT NULL,
type		TINYINT			DEFAULT '0'		NOT NULL,
m_type		TINYINT			DEFAULT '0'		NOT NULL,
dispage		TEXT			DEFAULT ''		NOT NULL,
skin		VARCHAR(50)		DEFAULT ''		NOT NULL,
m_skin		VARCHAR(50)		DEFAULT ''		NOT NULL,
bgcolor		VARCHAR(10)		DEFAULT ''		NOT NULL,
KEY hidden(hidden)) ENGINE=".$DB['type']." CHARSET=UTF8MB4");
db_query($_tmp, $DB_CONNECT);
db_query("OPTIMIZE TABLE ".$table['s_popup'],$DB_CONNECT);
}

//회원아이디데이터
$_tmp = db_query( "select count(*) from ".$table['s_mbrid'], $DB_CONNECT );
if ( !$_tmp ) {
$_tmp = ("

CREATE TABLE ".$table['s_mbrid']." (
uid			INT				PRIMARY KEY		NOT NULL AUTO_INCREMENT,
site		INT				DEFAULT '0'		NOT NULL,
id			VARCHAR(50)		DEFAULT ''		NOT NULL,
pw			VARCHAR(250)	DEFAULT ''		NOT NULL,
KEY site(site),
KEY id(id)) ENGINE=".$DB['type']." CHARSET=UTF8MB4");
db_query($_tmp, $DB_CONNECT);
db_query("OPTIMIZE TABLE ".$table['s_mbrid'],$DB_CONNECT);
}

//회원기본데이터
$_tmp = db_query( "select count(*) from ".$table['s_mbrdata'], $DB_CONNECT );
if ( !$_tmp ) {
$_tmp = ("

CREATE TABLE ".$table['s_mbrdata']." (
memberuid	INT				PRIMARY KEY		NOT NULL,
site		INT				DEFAULT '0'		NOT NULL,
auth		    TINYINT			DEFAULT '0'		NOT NULL,
hidden		  TINYINT			DEFAULT '0'		NOT NULL,
mygroup		INT				DEFAULT '0'		NOT NULL,
level		  INT				DEFAULT '0'		NOT NULL,
comp		TINYINT			DEFAULT '0'		NOT NULL,
super		TINYINT			DEFAULT '0'		NOT NULL,
admin		TINYINT			DEFAULT '0'		NOT NULL,
adm_view	TEXT			NOT NULL,
adm_site	TEXT			NOT NULL,
email		VARCHAR(50)	 	DEFAULT ''		NOT NULL,
email_profile		VARCHAR(50)	 	DEFAULT ''		NOT NULL,
email_noti		VARCHAR(50)	 	DEFAULT ''		NOT NULL,
email_backup		VARCHAR(50)	 	DEFAULT ''		NOT NULL,
phone		VARCHAR(20)		DEFAULT ''		NOT NULL,
name		VARCHAR(30)	 	DEFAULT ''		NOT NULL,
nic			VARCHAR(50)		DEFAULT ''		NOT NULL,
grade		VARCHAR(20)		DEFAULT ''		NOT NULL,
photo		VARCHAR(200)	DEFAULT ''		NOT NULL,
cover		VARCHAR(200)	DEFAULT ''		NOT NULL,
home		VARCHAR(100)	DEFAULT ''		NOT NULL,
sex			TINYINT			DEFAULT '0'		NOT NULL,
birth1		SMALLINT		DEFAULT '0'		NOT NULL,
birth2		SMALLINT(4)		UNSIGNED ZEROFILL DEFAULT '0000' NOT NULL,
birthtype	TINYINT			DEFAULT '0'		NOT NULL,
tel		VARCHAR(20)		DEFAULT ''		NOT NULL,
location			VARCHAR(250)		DEFAULT ''		NOT NULL,
job			VARCHAR(30)		DEFAULT ''		NOT NULL,
marr1		SMALLINT		DEFAULT '0'		NOT NULL,
marr2		SMALLINT(4)		UNSIGNED ZEROFILL DEFAULT '0000' NOT NULL,
sms			TINYINT			DEFAULT '0'		NOT NULL,
mailing		TINYINT			DEFAULT '0'		NOT NULL,
smail		TINYINT			DEFAULT '0'		NOT NULL,
point		INT				DEFAULT '0'		NOT NULL,
usepoint	INT				DEFAULT '0'		NOT NULL,
money		INT				DEFAULT '0'		NOT NULL,
cash		INT				DEFAULT '0'		NOT NULL,
num_login	INT				DEFAULT '0'		NOT NULL,
num_follower	INT				DEFAULT '0'		NOT NULL,
num_post	INT				DEFAULT '0'		NOT NULL,
num_list	INT				DEFAULT '0'		NOT NULL,
num_goods	INT				DEFAULT '0'		NOT NULL,
num_notice	INT				DEFAULT '0'		NOT NULL,
hit_post	INT				DEFAULT '0'		NOT NULL,
likes_post	INT				DEFAULT '0'		NOT NULL,
dislikes_post	INT				DEFAULT '0'		NOT NULL,
bio		TEXT			NOT NULL,
now_log		TINYINT			DEFAULT '0'		NOT NULL,
last_log	VARCHAR(14)		DEFAULT ''		NOT NULL,
last_pw		VARCHAR(8)		DEFAULT ''		NOT NULL,
is_paper	TINYINT			DEFAULT '0'		NOT NULL,
d_regis		VARCHAR(14)		DEFAULT ''		NOT NULL,
tmpcode		VARCHAR(250)	DEFAULT ''		NOT NULL,
sns		VARCHAR(14)		DEFAULT ''		NOT NULL,
noticeconf	TEXT			NOT NULL,
addfield	TEXT			NOT NULL,
KEY site(site),
KEY auth(auth),
KEY comp(comp),
KEY mygroup(mygroup),
KEY level(level),
KEY admin(admin),
KEY email(email),
KEY email_profile(email_profile),
KEY email_noti(email_noti),
KEY email_backup(email_backup),
KEY phone(phone),
KEY name(name),
KEY nic(nic),
KEY sex(sex),
KEY birth1(birth1),
KEY birth2(birth2),
KEY birthtype(birthtype),
KEY location(location),
KEY job(job),
KEY marr1(marr1),
KEY marr2(marr2),
KEY sms(sms),
KEY mailing(mailing),
KEY smail(smail),
KEY point(point),
KEY usepoint(usepoint),
KEY now_log(now_log),
KEY num_follower(num_follower),
KEY num_post(num_post),
KEY num_list(num_list),
KEY num_goods(num_goods),
KEY hit_post(hit_post),
KEY likes_post(likes_post),
KEY dislikes_post(dislikes_post),
KEY d_regis(d_regis)) ENGINE=".$DB['type']." CHARSET=UTF8MB4");
db_query($_tmp, $DB_CONNECT);
db_query("OPTIMIZE TABLE ".$table['s_mbrdata'],$DB_CONNECT);
}

//회원 월별활동
$_tmp = db_query( "select count(*) from ".$table['s_mbrmonth'], $DB_CONNECT );
if ( !$_tmp ) {
$_tmp = ("

CREATE TABLE ".$table['s_mbrmonth']." (
date		CHAR(6)			DEFAULT ''		NOT NULL,
site		INT				DEFAULT '0'		NOT NULL,
mbruid			INT				DEFAULT '0'		NOT NULL,
post_num			INT				DEFAULT '0'		NOT NULL,
post_hit			INT				DEFAULT '0'		NOT NULL,
post_likes			INT				DEFAULT '0'		NOT NULL,
post_dislikes			INT				DEFAULT '0'		NOT NULL,
post_comment			INT				DEFAULT '0'		NOT NULL,
follower			INT				DEFAULT '0'		NOT NULL,
KEY date(date),
KEY site(site),
KEY mbruid(mbruid)) ENGINE=".$DB['type']." CHARSET=UTF8MB4");
db_query($_tmp, $DB_CONNECT);
db_query("OPTIMIZE TABLE ".$table['s_mbrmonth'],$DB_CONNECT);
}

//회원 일별활동
$_tmp = db_query( "select count(*) from ".$table['s_mbrday'], $DB_CONNECT );
if ( !$_tmp ) {
$_tmp = ("

CREATE TABLE ".$table['s_mbrday']." (
date		CHAR(8)			DEFAULT ''		NOT NULL,
site		INT				DEFAULT '0'		NOT NULL,
mbruid			INT				DEFAULT '0'		NOT NULL,
post_num			INT				DEFAULT '0'		NOT NULL,
post_hit			INT				DEFAULT '0'		NOT NULL,
post_likes			INT				DEFAULT '0'		NOT NULL,
post_dislikes			INT				DEFAULT '0'		NOT NULL,
post_comment			INT				DEFAULT '0'		NOT NULL,
follower			INT				DEFAULT '0'		NOT NULL,
KEY date(date),
KEY site(site),
KEY mbruid(mbruid)) ENGINE=".$DB['type']." CHARSET=UTF8MB4");
db_query($_tmp, $DB_CONNECT);
db_query("OPTIMIZE TABLE ".$table['s_mbrday'],$DB_CONNECT);
}

//접속카운트
$_tmp = db_query( "select count(*) from ".$table['s_counter'], $DB_CONNECT );
if ( !$_tmp ) {
$_tmp = ("

CREATE TABLE ".$table['s_counter']." (
uid			INT				PRIMARY KEY		NOT NULL AUTO_INCREMENT,
site		INT				DEFAULT '0'		NOT NULL,
date		CHAR(8)			DEFAULT ''		NOT NULL,
hit			INT				DEFAULT '0'		NOT NULL,
page		INT				DEFAULT '0'		NOT NULL,
KEY site(site),
KEY date(date)) ENGINE=".$DB['type']." CHARSET=UTF8MB4");
db_query($_tmp, $DB_CONNECT);
db_query("OPTIMIZE TABLE ".$table['s_counter'],$DB_CONNECT);
}

//접속레퍼러
$_tmp = db_query( "select count(*) from ".$table['s_referer'], $DB_CONNECT );
if ( !$_tmp ) {
$_tmp = ("

CREATE TABLE ".$table['s_referer']." (
uid			BIGINT			PRIMARY KEY		NOT NULL AUTO_INCREMENT,
site		INT				DEFAULT '0'		NOT NULL,
mbruid		INT				DEFAULT '0'		NOT NULL,
ip			VARCHAR(15)		DEFAULT ''		NOT NULL,
referer		VARCHAR(200)	DEFAULT ''		NOT NULL,
agent		VARCHAR(200)	DEFAULT ''		NOT NULL,
d_regis		VARCHAR(14)		DEFAULT ''		NOT NULL,
KEY site(site),
KEY mbruid(mbruid),
KEY d_regis(d_regis)) ENGINE=".$DB['type']." CHARSET=UTF8MB4");
db_query($_tmp, $DB_CONNECT);
db_query("OPTIMIZE TABLE ".$table['s_referer'],$DB_CONNECT);
}

//브라우져
$_tmp = db_query( "select count(*) from ".$table['s_browser'], $DB_CONNECT );
if ( !$_tmp ) {
$_tmp = ("

CREATE TABLE ".$table['s_browser']." (
uid			INT				PRIMARY KEY		NOT NULL AUTO_INCREMENT,
site		INT				DEFAULT '0'		NOT NULL,
date		CHAR(8)			DEFAULT ''		NOT NULL,
browser		VARCHAR(10)		DEFAULT ''		NOT NULL,
hit			INT				DEFAULT '0'		NOT NULL,
KEY site(site),
KEY date(date),
KEY browser(browser)) ENGINE=".$DB['type']." CHARSET=UTF8MB4");
db_query($_tmp, $DB_CONNECT);
db_query("OPTIMIZE TABLE ".$table['s_browser'],$DB_CONNECT);
}

//내부키워드
$_tmp = db_query( "select count(*) from ".$table['s_inkey'], $DB_CONNECT );
if ( !$_tmp ) {
$_tmp = ("

CREATE TABLE ".$table['s_inkey']." (
uid			INT				PRIMARY KEY		NOT NULL AUTO_INCREMENT,
site		INT				DEFAULT '0'		NOT NULL,
date		CHAR(8)			DEFAULT ''		NOT NULL,
keyword		VARCHAR(50)		DEFAULT ''		NOT NULL,
hit			INT				DEFAULT '0'		NOT NULL,
KEY site(site),
KEY date(date),
KEY keyword(keyword)) ENGINE=".$DB['type']." CHARSET=UTF8MB4");
db_query($_tmp, $DB_CONNECT);
db_query("OPTIMIZE TABLE ".$table['s_inkey'],$DB_CONNECT);
}

//외부키워드
$_tmp = db_query( "select count(*) from ".$table['s_outkey'], $DB_CONNECT );
if ( !$_tmp ) {
$_tmp = ("

CREATE TABLE ".$table['s_outkey']." (
uid			INT				PRIMARY KEY		NOT NULL AUTO_INCREMENT,
site		INT				DEFAULT '0'		NOT NULL,
date		CHAR(8)			DEFAULT ''		NOT NULL,
keyword		VARCHAR(50)		DEFAULT ''		NOT NULL,
naver		INT				DEFAULT '0'		NOT NULL,
nate		INT				DEFAULT '0'		NOT NULL,
daum		INT				DEFAULT '0'		NOT NULL,
yahoo		INT				DEFAULT '0'		NOT NULL,
google		INT				DEFAULT '0'		NOT NULL,
etc			INT				DEFAULT '0'		NOT NULL,
total		INT				DEFAULT '0'		NOT NULL,
KEY site(site),
KEY date(date),
KEY keyword(keyword)) ENGINE=".$DB['type']." CHARSET=UTF8MB4");
db_query($_tmp, $DB_CONNECT);
db_query("OPTIMIZE TABLE ".$table['s_outkey'],$DB_CONNECT);
}

//첨부파일데이터
$_tmp = db_query( "select count(*) from ".$table['s_upload'], $DB_CONNECT );
if ( !$_tmp ) {
$_tmp = ("

CREATE TABLE ".$table['s_upload']." (
uid			INT				PRIMARY KEY		NOT NULL AUTO_INCREMENT,
gid			INT				DEFAULT '0'		NOT NULL,
pid			INT				DEFAULT '0'		NOT NULL,
parent  VARCHAR(45)		DEFAULT ''		NOT NULL,
category	INT				DEFAULT '0'		NOT NULL,
hidden		TINYINT			DEFAULT '0'		NOT NULL,
tmpcode		VARCHAR(20)		DEFAULT ''		NOT NULL,
site		INT				DEFAULT '0'		NOT NULL,
mbruid		INT				DEFAULT '0'		NOT NULL,
fileonly	TINYINT			DEFAULT '0'		NOT NULL,
type		TINYINT			DEFAULT '0'		NOT NULL,
ext			VARCHAR(4)		DEFAULT '0'		NOT NULL,
fserver		TINYINT			DEFAULT '0'		NOT NULL,
host			VARCHAR(150)	DEFAULT ''		NOT NULL,
folder		VARCHAR(250)		DEFAULT ''		NOT NULL,
name		VARCHAR(250)	DEFAULT ''		NOT NULL,
tmpname		VARCHAR(100)	DEFAULT ''		NOT NULL,
size		INT				DEFAULT '0'		NOT NULL,
width		INT				DEFAULT '0'		NOT NULL,
height		INT				DEFAULT '0'		NOT NULL,
alt			VARCHAR(50)		DEFAULT ''		NOT NULL,
caption		TEXT			NOT NULL,
description	TEXT			NOT NULL,
provider	VARCHAR(100)	DEFAULT ''		NOT NULL,
author	VARCHAR(100)	DEFAULT ''		NOT NULL,
src			TEXT			NOT NULL,
linkto		TINYINT			DEFAULT '0'		NOT NULL,
license		TINYINT			DEFAULT '0'		NOT NULL,
down		INT				DEFAULT '0'		NOT NULL,
d_regis		VARCHAR(14)		DEFAULT ''		NOT NULL,
d_update	VARCHAR(14)		DEFAULT ''		NOT NULL,
sync		VARCHAR(250)	DEFAULT ''		NOT NULL,
linkurl		VARCHAR(250)	DEFAULT ''		NOT NULL,
time		VARCHAR(20)		DEFAULT ''		NOT NULL,
duration		INT				DEFAULT '0'		NOT NULL,
tag	  TEXT			NOT NULL,
KEY gid(gid),
KEY parent(parent),
KEY category(category),
KEY tmpcode(tmpcode),
KEY site(site),
KEY mbruid(mbruid),
KEY fileonly(fileonly),
KEY type(type),
KEY ext(ext),
KEY name(name),
KEY provider(provider),
KEY author(author),
KEY duration(duration),
KEY d_regis(d_regis)) ENGINE=".$DB['type']." CHARSET=UTF8MB4");
db_query($_tmp, $DB_CONNECT);
db_query("OPTIMIZE TABLE ".$table['s_upload'],$DB_CONNECT);
}

//첨부파일카테고리데이터
$_tmp = db_query( "select count(*) from ".$table['s_uploadcat'], $DB_CONNECT );
if ( !$_tmp ) {
$_tmp = ("

CREATE TABLE ".$table['s_uploadcat']." (
uid			INT				PRIMARY KEY		NOT NULL AUTO_INCREMENT,
gid			INT				DEFAULT '0'		NOT NULL,
site		INT				DEFAULT '0'		NOT NULL,
mbruid		INT				DEFAULT '0'		NOT NULL,
type		TINYINT			DEFAULT '0'		NOT NULL,
hidden		TINYINT			DEFAULT '0'		NOT NULL,
users		TEXT			NOT NULL,
name		VARCHAR(50)		DEFAULT ''		NOT NULL,
r_num		INT				DEFAULT '0'		NOT NULL,
d_regis		VARCHAR(14)		DEFAULT ''		NOT NULL,
d_update	VARCHAR(14)		DEFAULT ''		NOT NULL,
KEY gid(gid),
KEY site(site),
KEY mbruid(mbruid),
KEY type(type),
KEY hidden(hidden)) ENGINE=".$DB['type']." CHARSET=UTF8MB4");
db_query($_tmp, $DB_CONNECT);
db_query("OPTIMIZE TABLE ".$table['s_uploadcat'],$DB_CONNECT);
}

//댓글데이터
$_tmp = db_query( "select count(*) from ".$table['s_comment'], $DB_CONNECT );
if ( !$_tmp ) {
$_tmp = ("

CREATE TABLE ".$table['s_comment']." (
uid			INT				PRIMARY KEY		NOT NULL,
site		INT				DEFAULT '0'		NOT NULL,
parent		VARCHAR(30)		DEFAULT '0'		NOT NULL,
parentmbr	INT				DEFAULT '0'		NOT NULL,
display		TINYINT			DEFAULT '0'		NOT NULL,
hidden		TINYINT			DEFAULT '0'		NOT NULL,
notice		TINYINT			DEFAULT '0'		NOT NULL,
name		VARCHAR(30)		DEFAULT ''		NOT NULL,
nic			VARCHAR(50)		DEFAULT ''		NOT NULL,
mbruid		INT				DEFAULT '0'		NOT NULL,
id			VARCHAR(16)		DEFAULT ''		NOT NULL,
pw			VARCHAR(250)	DEFAULT ''		NOT NULL,
subject		VARCHAR(200)	DEFAULT ''		NOT NULL,
content		TEXT			NOT NULL,
html		VARCHAR(4)		DEFAULT ''		NOT NULL,
hit			INT				DEFAULT '0'		NOT NULL,
down		INT				DEFAULT '0'		NOT NULL,
oneline		INT				DEFAULT '0'		NOT NULL,
likes		INT				DEFAULT '0'		NOT NULL,
dislikes		INT				DEFAULT '0'		NOT NULL,
report		INT				DEFAULT '0'		NOT NULL,
point		INT				DEFAULT '0'		NOT NULL,
d_regis		VARCHAR(14)		DEFAULT ''		NOT NULL,
d_modify	VARCHAR(14)		DEFAULT ''		NOT NULL,
d_oneline	VARCHAR(14)		DEFAULT ''		NOT NULL,
upload		TEXT			NOT NULL,
ip			VARCHAR(25)	 	DEFAULT ''		NOT NULL,
agent	 	VARCHAR(150)	DEFAULT ''		NOT NULL,
sync		VARCHAR(250)	DEFAULT ''		NOT NULL,
sns			VARCHAR(100)	DEFAULT ''		NOT NULL,
adddata		TEXT			NOT NULL,
KEY site(site),
KEY parent(parent),
KEY parentmbr(parentmbr),
KEY display(display),
KEY hidden(hidden),
KEY notice(notice),
KEY mbruid(mbruid),
KEY subject(subject),
KEY d_regis(d_regis)) ENGINE=".$DB['type']." CHARSET=UTF8MB4");
db_query($_tmp, $DB_CONNECT);
db_query("OPTIMIZE TABLE ".$table['s_comment'],$DB_CONNECT);
}

//한줄의견데이터
$_tmp = db_query( "select count(*) from ".$table['s_oneline'], $DB_CONNECT );
if ( !$_tmp ) {
$_tmp = ("

CREATE TABLE ".$table['s_oneline']." (
uid			INT				PRIMARY KEY		NOT NULL,
site		INT				DEFAULT '0'		NOT NULL,
parent		INT				DEFAULT '0'		NOT NULL,
parentmbr	INT				DEFAULT '0'		NOT NULL,
hidden		TINYINT			DEFAULT '0'		NOT NULL,
name		VARCHAR(30)		DEFAULT ''		NOT NULL,
nic			VARCHAR(30)		DEFAULT ''		NOT NULL,
mbruid		INT				DEFAULT '0'		NOT NULL,
id			VARCHAR(16)		DEFAULT ''		NOT NULL,
content		TEXT			NOT NULL,
html		VARCHAR(4)		DEFAULT ''		NOT NULL,
likes		INT				DEFAULT '0'		NOT NULL,
dislikes		INT				DEFAULT '0'		NOT NULL,
report		INT				DEFAULT '0'		NOT NULL,
point		INT				DEFAULT '0'		NOT NULL,
d_regis		VARCHAR(14)		DEFAULT ''		NOT NULL,
d_modify	VARCHAR(14)		DEFAULT ''		NOT NULL,
ip			VARCHAR(25)	 	DEFAULT ''		NOT NULL,
agent	 	VARCHAR(150)	DEFAULT ''		NOT NULL,
adddata		TEXT			NOT NULL,
KEY site(site),
KEY parent(parent),
KEY parentmbr(parentmbr),
KEY hidden(hidden),
KEY mbruid(mbruid),
KEY d_regis(d_regis)) ENGINE=".$DB['type']." CHARSET=UTF8MB4");
db_query($_tmp, $DB_CONNECT);
db_query("OPTIMIZE TABLE ".$table['s_oneline'],$DB_CONNECT);
}

//평가데이터
$_tmp = db_query( "select count(*) from ".$table['s_opinion'], $DB_CONNECT );
if ( !$_tmp ) {
$_tmp = ("

CREATE TABLE ".$table['s_opinion']." (
uid			INT				PRIMARY KEY		NOT NULL AUTO_INCREMENT,
mbruid	INT				DEFAULT '0'		NOT NULL,
module	VARCHAR(30)		DEFAULT ''		NOT NULL,
entry		INT				DEFAULT '0'		NOT NULL,
opinion	VARCHAR(20)		DEFAULT ''		NOT NULL,
d_regis	VARCHAR(14)		DEFAULT ''		NOT NULL,
KEY mbruid(mbruid),
KEY entry(entry),
KEY d_regis(d_regis)) ENGINE=".$DB['type']." CHARSET=UTF8MB4");
db_query($_tmp, $DB_CONNECT);
db_query("OPTIMIZE TABLE ".$table['s_opinion'],$DB_CONNECT);
}

//일별수량
$_tmp = db_query( "select count(*) from ".$table['s_numinfo'], $DB_CONNECT );
if ( !$_tmp ) {
$_tmp = ("

CREATE TABLE ".$table['s_numinfo']." (
date		CHAR(8)			DEFAULT ''		NOT NULL,
site		INT				DEFAULT '0'		NOT NULL,
visit		INT				DEFAULT '0'		NOT NULL,
login		INT				DEFAULT '0'		NOT NULL,
comment		INT				DEFAULT '0'		NOT NULL,
oneline		INT				DEFAULT '0'		NOT NULL,
rcvtrack	INT				DEFAULT '0'		NOT NULL,
sndtrack	INT				DEFAULT '0'		NOT NULL,
upload		INT				DEFAULT '0'		NOT NULL,
download	INT				DEFAULT '0'		NOT NULL,
mbrjoin		INT				DEFAULT '0'		NOT NULL,
mbrout		INT				DEFAULT '0'		NOT NULL,
KEY date(date),
KEY site(site)) ENGINE=".$DB['type']." CHARSET=UTF8MB4");
db_query($_tmp, $DB_CONNECT);
db_query("OPTIMIZE TABLE ".$table['s_numinfo'],$DB_CONNECT);
}

//태그
$_tmp = db_query( "select count(*) from ".$table['s_tag'], $DB_CONNECT );
if ( !$_tmp ) {
$_tmp = ("

CREATE TABLE ".$table['s_tag']." (
uid			INT				PRIMARY KEY		NOT NULL AUTO_INCREMENT,
site		INT				DEFAULT '0'		NOT NULL,
date		CHAR(8)			DEFAULT ''		NOT NULL,
keyword		VARCHAR(50)		DEFAULT ''		NOT NULL,
hit			INT				DEFAULT '0'		NOT NULL,
KEY site(site),
KEY date(date),
KEY hit(hit),
KEY keyword(keyword)) ENGINE=".$DB['type']." CHARSET=UTF8MB4");
db_query($_tmp, $DB_CONNECT);
db_query("OPTIMIZE TABLE ".$table['s_tag'],$DB_CONNECT);
}

//회원레벨테이블
$_tmp = db_query( "select count(*) from ".$table['s_mbrlevel'], $DB_CONNECT );
if ( !$_tmp ) {
$_tmp = ("

CREATE TABLE ".$table['s_mbrlevel']." (
uid			INT				PRIMARY KEY		NOT NULL AUTO_INCREMENT,
gid			INT				DEFAULT '0'		NOT NULL,
name		VARCHAR(30)		DEFAULT ''		NOT NULL,
num			INT				DEFAULT '0'		NOT NULL,
login		INT				DEFAULT '0'		NOT NULL,
post		INT				DEFAULT '0'		NOT NULL,
comment		INT				DEFAULT '0'		NOT NULL,
KEY gid(gid)) ENGINE=".$DB['type']." CHARSET=UTF8MB4");
db_query($_tmp, $DB_CONNECT);
db_query("OPTIMIZE TABLE ".$table['s_mbrlevel'],$DB_CONNECT);
}
//회원그룹테이블
$_tmp = db_query( "select count(*) from ".$table['s_mbrgroup'], $DB_CONNECT );
if ( !$_tmp ) {
$_tmp = ("

CREATE TABLE ".$table['s_mbrgroup']." (
uid			INT				PRIMARY KEY		NOT NULL AUTO_INCREMENT,
name		VARCHAR(30)		DEFAULT ''		NOT NULL,
gid			TINYINT			DEFAULT '0'		NOT NULL,
num			INT				DEFAULT	'0'		NOT NULL,
KEY gid(gid)) ENGINE=".$DB['type']." CHARSET=UTF8MB4");
db_query($_tmp, $DB_CONNECT);
db_query("OPTIMIZE TABLE ".$table['s_mbrgroup'],$DB_CONNECT);
}
//포인트테이블
$_tmp = db_query( "select count(*) from ".$table['s_point'], $DB_CONNECT );
if ( !$_tmp ) {
$_tmp = ("

CREATE TABLE ".$table['s_point']." (
uid			BIGINT			PRIMARY KEY		NOT NULL AUTO_INCREMENT,
my_mbruid	INT				DEFAULT '0'		NOT NULL,
by_mbruid	INT				DEFAULT '0'		NOT NULL,
price		INT				DEFAULT '0'		NOT NULL,
content		TEXT			NOT NULL,
d_regis		VARCHAR(14)		DEFAULT ''		NOT NULL,
KEY my_mbruid(my_mbruid),
KEY by_mbruid(by_mbruid),
KEY d_regis(d_regis)) ENGINE=".$DB['type']." CHARSET=UTF8MB4");
db_query($_tmp, $DB_CONNECT);
db_query("OPTIMIZE TABLE ".$table['s_point'],$DB_CONNECT);
}
//적립금테이블
$_tmp = db_query( "select count(*) from ".$table['s_cash'], $DB_CONNECT );
if ( !$_tmp ) {
$_tmp = ("

CREATE TABLE ".$table['s_cash']." (
uid			BIGINT			PRIMARY KEY		NOT NULL AUTO_INCREMENT,
my_mbruid	INT				DEFAULT '0'		NOT NULL,
by_mbruid	INT				DEFAULT '0'		NOT NULL,
price		INT				DEFAULT '0'		NOT NULL,
content		TEXT			NOT NULL,
d_regis		VARCHAR(14)		DEFAULT ''		NOT NULL,
KEY my_mbruid(my_mbruid),
KEY by_mbruid(by_mbruid),
KEY d_regis(d_regis)) ENGINE=".$DB['type']." CHARSET=UTF8MB4");
db_query($_tmp, $DB_CONNECT);
db_query("OPTIMIZE TABLE ".$table['s_cash'],$DB_CONNECT);
}
//예치금테이블
$_tmp = db_query( "select count(*) from ".$table['s_money'], $DB_CONNECT );
if ( !$_tmp ) {
$_tmp = ("

CREATE TABLE ".$table['s_money']." (
uid			BIGINT			PRIMARY KEY		NOT NULL AUTO_INCREMENT,
my_mbruid	INT				DEFAULT '0'		NOT NULL,
by_mbruid	INT				DEFAULT '0'		NOT NULL,
price		INT				DEFAULT '0'		NOT NULL,
content		TEXT			NOT NULL,
d_regis		VARCHAR(14)		DEFAULT ''		NOT NULL,
KEY my_mbruid(my_mbruid),
KEY by_mbruid(by_mbruid),
KEY d_regis(d_regis)) ENGINE=".$DB['type']." CHARSET=UTF8MB4");
db_query($_tmp, $DB_CONNECT);
db_query("OPTIMIZE TABLE ".$table['s_money'],$DB_CONNECT);
}
//쪽지테이블
$_tmp = db_query( "select count(*) from ".$table['s_paper'], $DB_CONNECT );
if ( !$_tmp ) {
$_tmp = ("

CREATE TABLE ".$table['s_paper']." (
uid			BIGINT			PRIMARY KEY		NOT NULL AUTO_INCREMENT,
parent		INT				DEFAULT '0'		NOT NULL,
my_mbruid	INT				DEFAULT '0'		NOT NULL,
by_mbruid	INT				DEFAULT '0'		NOT NULL,
inbox		TINYINT			DEFAULT '0'		NOT NULL,
content		TEXT			NOT NULL,
html		VARCHAR(4)		DEFAULT ''		NOT NULL,
upload		TEXT			NOT NULL,
d_regis		VARCHAR(14)		DEFAULT ''		NOT NULL,
d_read		VARCHAR(14)		DEFAULT ''		NOT NULL,
KEY parent(parent),
KEY my_mbruid(my_mbruid),
KEY by_mbruid(by_mbruid),
KEY inbox(inbox),
KEY d_regis(d_regis),
KEY d_read(d_read)) ENGINE=".$DB['type']." CHARSET=UTF8MB4");
db_query($_tmp, $DB_CONNECT);
db_query("OPTIMIZE TABLE ".$table['s_paper'],$DB_CONNECT);
}
//SMS테이블
$_tmp = db_query( "select count(*) from ".$table['s_sms'], $DB_CONNECT );
if ( !$_tmp ) {
$_tmp = ("

CREATE TABLE ".$table['s_sms']." (
uid			  BIGINT			PRIMARY KEY		NOT NULL AUTO_INCREMENT,
site	  	INT				DEFAULT '0'		NOT NULL,
module	  VARCHAR(50)		DEFAULT ''		NOT NULL,
to_mbruid	INT				DEFAULT '0'		NOT NULL,
to_phone	VARCHAR(20)	  DEFAULT ''		NOT NULL,
from_mbruid	INT				DEFAULT '0'		NOT NULL,
from_tel	VARCHAR(20)	  DEFAULT ''		NOT NULL,
type		  TINYINT			DEFAULT '0'		NOT NULL,
subject	  VARCHAR(200)	  DEFAULT ''		NOT NULL,
content		TEXT			NOT NULL,
upload		TEXT			NOT NULL,
d_regis		VARCHAR(14)		DEFAULT ''		NOT NULL,
KEY site(site),
KEY module(module),
KEY to_mbruid(to_mbruid),
KEY to_phone(to_phone),
KEY from_mbruid(from_mbruid),
KEY from_tel(from_tel),
KEY type(type),
KEY d_regis(d_regis)) ENGINE=".$DB['type']." CHARSET=UTF8MB4");
db_query($_tmp, $DB_CONNECT);
db_query("OPTIMIZE TABLE ".$table['s_sms'],$DB_CONNECT);
}
//친구테이블
$_tmp = db_query( "select count(*) from ".$table['s_friend'], $DB_CONNECT );
if ( !$_tmp ) {
$_tmp = ("

CREATE TABLE ".$table['s_friend']." (
uid			BIGINT			PRIMARY KEY		NOT NULL AUTO_INCREMENT,
rel			TINYINT			DEFAULT '0'		NOT NULL,
my_mbruid	INT				DEFAULT '0'		NOT NULL,
by_mbruid	INT				DEFAULT '0'		NOT NULL,
category	VARCHAR(50)		DEFAULT ''		NOT NULL,
d_regis		VARCHAR(14)		DEFAULT ''		NOT NULL,
KEY rel(rel),
KEY my_mbruid(my_mbruid),
KEY by_mbruid(by_mbruid),
KEY d_regis(d_regis)) ENGINE=".$DB['type']." CHARSET=UTF8MB4");
db_query($_tmp, $DB_CONNECT);
db_query("OPTIMIZE TABLE ".$table['s_friend'],$DB_CONNECT);
}
//링크저장테이블
$_tmp = db_query( "select count(*) from ".$table['s_saved'], $DB_CONNECT );
if ( !$_tmp ) {
$_tmp = ("

CREATE TABLE ".$table['s_saved']." (
uid			BIGINT			PRIMARY KEY		NOT NULL AUTO_INCREMENT,
mbruid		INT				DEFAULT '0'		NOT NULL,
module	VARCHAR(30)		DEFAULT ''		NOT NULL,
category	VARCHAR(50)		DEFAULT ''		NOT NULL,
entry  		INT				DEFAULT '0'		NOT NULL,
subject		VARCHAR(200)	DEFAULT ''		NOT NULL,
url			VARCHAR(250)	DEFAULT ''		NOT NULL,
d_regis		VARCHAR(14)		DEFAULT ''		NOT NULL,
KEY mbruid(mbruid),
KEY d_regis(d_regis)) ENGINE=".$DB['type']." CHARSET=UTF8MB4");
db_query($_tmp, $DB_CONNECT);
db_query("OPTIMIZE TABLE ".$table['s_saved'],$DB_CONNECT);
}

//캐릭터테이블
$_tmp = db_query( "select count(*) from ".$table['s_userpic'], $DB_CONNECT );
if ( !$_tmp ) {
$_tmp = ("

CREATE TABLE ".$table['s_userpic']." (
uid			BIGINT			PRIMARY KEY		NOT NULL AUTO_INCREMENT,
mbruid		INT				DEFAULT '0'		NOT NULL,
gid			INT				DEFAULT '0'		NOT NULL,
photo		VARCHAR(100)	DEFAULT ''		NOT NULL,
d_regis		VARCHAR(14)		DEFAULT ''		NOT NULL,
KEY mbruid(mbruid),
KEY d_regis(d_regis)) ENGINE=".$DB['type']." CHARSET=UTF8MB4");
db_query($_tmp, $DB_CONNECT);
db_query("OPTIMIZE TABLE ".$table['s_userpic'],$DB_CONNECT);
}

//SNS테이블
$_tmp = db_query( "select count(*) from ".$table['s_mbrsns'], $DB_CONNECT );
if ( !$_tmp ) {
$_tmp = ("

CREATE TABLE ".$table['s_mbrsns']." (
uid			        BIGINT			PRIMARY KEY		NOT NULL AUTO_INCREMENT,
mbruid		      INT				DEFAULT '0'		NOT NULL,
sns    	        VARCHAR(30)		DEFAULT ''		NOT NULL,
id  		        VARCHAR(100)		DEFAULT ''		NOT NULL,
access_token		VARCHAR(100)	DEFAULT ''		NOT NULL,
refresh_token		VARCHAR(100)	DEFAULT ''		NOT NULL,
expires_in			INT				DEFAULT '0'		NOT NULL,
d_regis		      VARCHAR(14)		DEFAULT ''		NOT NULL,
KEY mbruid(mbruid),
KEY sns(sns),
KEY expires_in(expires_in),
KEY d_regis(d_regis)) ENGINE=".$DB['type']." CHARSET=UTF8MB4");
db_query($_tmp, $DB_CONNECT);
db_query("OPTIMIZE TABLE ".$table['s_mbrsns'],$DB_CONNECT);
}

//로그인 상태유지 토큰
$_tmp = db_query( "select count(*) from ".$table['s_mbrtoken'], $DB_CONNECT );
if ( !$_tmp ) {
$_tmp = ("

CREATE TABLE ".$table['s_mbrtoken']." (
uid   INT    PRIMARY KEY  NOT NULL AUTO_INCREMENT,
memberuid	INT				DEFAULT '0'		NOT NULL,
access_token		VARCHAR(100)	DEFAULT ''		NOT NULL,
expire		INT				DEFAULT '0'		NOT NULL,
KEY memberuid(memberuid)) ENGINE=".$DB['type']." CHARSET=UTF8MB4");
db_query($_tmp, $DB_CONNECT);
db_query("OPTIMIZE TABLE ".$table['s_mbrtoken'],$DB_CONNECT);
}

//회원별 instance-id 토큰
$_tmp = db_query( "select count(*) from ".$table['s_iidtoken'], $DB_CONNECT );
if ( !$_tmp ) {
$_tmp = ("
CREATE TABLE ".$table['s_iidtoken']." (
uid       INT    PRIMARY KEY  NOT NULL AUTO_INCREMENT,
mbruid	  INT				DEFAULT '0'		NOT NULL,
token		  VARCHAR(255)	DEFAULT ''		NOT NULL,
device	  VARCHAR(10)	DEFAULT ''		NOT NULL,
browser	  VARCHAR(10)	DEFAULT ''		NOT NULL,
version	  VARCHAR(10)	DEFAULT ''		NOT NULL,
d_regis	  VARCHAR(14)		DEFAULT ''		NOT NULL,
d_update  VARCHAR(14)		DEFAULT ''		NOT NULL,
KEY device(device),
KEY browser(browser),
KEY version(version),
KEY mbruid(mbruid)) ENGINE=".$DB['type']." CHARSET=UTF8MB4");
db_query($_tmp, $DB_CONNECT);
db_query("OPTIMIZE TABLE ".$table['s_iidtoken'],$DB_CONNECT);
}

//비회원 본인인증 정보
$_tmp = db_query( "select count(*) from ".$table['s_guestauth'], $DB_CONNECT );
if ( !$_tmp ) {
$_tmp = ("
CREATE TABLE ".$table['s_guestauth']." (
uid             INT    PRIMARY KEY  NOT NULL AUTO_INCREMENT,
auth		        TINYINT			DEFAULT '0'		NOT NULL,
email    	      VARCHAR(50)	  DEFAULT ''		NOT NULL,
phone    	      VARCHAR(20)	  DEFAULT ''		NOT NULL,
token		        VARCHAR(100)	DEFAULT ''		NOT NULL,
code		        VARCHAR(30)	  DEFAULT ''		NOT NULL,
d_regis	        VARCHAR(14)		DEFAULT ''		NOT NULL,
ip		          VARCHAR(15)   DEFAULT ''    NOT NULL,
KEY auth(auth)) ENGINE=".$DB['type']." CHARSET=UTF8MB4");
db_query($_tmp, $DB_CONNECT);
db_query("OPTIMIZE TABLE ".$table['s_guestauth'],$DB_CONNECT);
}

//회원 이메일 목록
$_tmp = db_query( "select count(*) from ".$table['s_mbremail'], $DB_CONNECT );
if ( !$_tmp ) {
$_tmp = ("
CREATE TABLE ".$table['s_mbremail']." (
uid			      BIGINT			  PRIMARY KEY		NOT NULL AUTO_INCREMENT,
mbruid		    INT				    DEFAULT '0'		NOT NULL,
email    	    VARCHAR(50)	  DEFAULT ''		NOT NULL,
base		      TINYINT			  DEFAULT '0'		NOT NULL,
backup		    TINYINT			  DEFAULT '0'		NOT NULL,
d_regis		    VARCHAR(14)		DEFAULT ''		NOT NULL,
d_code		    VARCHAR(14)		DEFAULT ''		NOT NULL,
d_verified		VARCHAR(14)		DEFAULT ''		NOT NULL,
KEY mbruid(mbruid),
KEY base(base),
KEY backup(backup),
KEY d_code(d_code),
KEY d_verified(d_verified),
KEY d_regis(d_regis)) ENGINE=".$DB['type']." CHARSET=UTF8MB4");
db_query($_tmp, $DB_CONNECT);
db_query("OPTIMIZE TABLE ".$table['s_mbremail'],$DB_CONNECT);
}

//회원 휴대폰 목록 저장
$_tmp = db_query( "select count(*) from ".$table['s_mbrphone'], $DB_CONNECT );
if ( !$_tmp ) {
$_tmp = ("
CREATE TABLE ".$table['s_mbrphone']." (
uid			      BIGINT			  PRIMARY KEY		NOT NULL AUTO_INCREMENT,
mbruid		    INT				    DEFAULT '0'		NOT NULL,
phone    	    VARCHAR(20)	  DEFAULT ''		NOT NULL,
base		      TINYINT			  DEFAULT '0'		NOT NULL,
backup		    TINYINT			  DEFAULT '0'		NOT NULL,
d_regis		    VARCHAR(14)		DEFAULT ''		NOT NULL,
d_code		    VARCHAR(14)		DEFAULT ''		NOT NULL,
d_verified		VARCHAR(14)		DEFAULT ''		NOT NULL,
KEY mbruid(mbruid),
KEY base(base),
KEY backup(backup),
KEY d_verified(d_verified),
KEY d_code(d_code),
KEY d_regis(d_regis)) ENGINE=".$DB['type']." CHARSET=UTF8MB4");
db_query($_tmp, $DB_CONNECT);
db_query("OPTIMIZE TABLE ".$table['s_mbrphone'],$DB_CONNECT);
}

//회원 배송지 목록
$_tmp = db_query( "select count(*) from ".$table['s_mbrshipping'], $DB_CONNECT );
if ( !$_tmp ) {
$_tmp = ("
CREATE TABLE ".$table['s_mbrshipping']." (
uid			  BIGINT			  PRIMARY KEY		NOT NULL AUTO_INCREMENT,
mbruid	  INT				    DEFAULT '0'		NOT NULL,
label		  VARCHAR(50)	 	DEFAULT ''		NOT NULL,
name      VARCHAR(30)	 	DEFAULT ''		NOT NULL,
tel1		  VARCHAR(20)		DEFAULT ''		NOT NULL,
tel2		  VARCHAR(20)		DEFAULT ''		NOT NULL,
zip			  VARCHAR(20)		DEFAULT ''		NOT NULL,
addr0		  VARCHAR(6)		DEFAULT ''		NOT NULL,
addr1		  VARCHAR(250)	DEFAULT ''		NOT NULL,
addr2		  VARCHAR(250)	DEFAULT ''		NOT NULL,
base		  TINYINT			  DEFAULT '0'		NOT NULL,
last_log	VARCHAR(14)		DEFAULT ''		NOT NULL,
KEY mbruid(mbruid),
KEY label(label),
KEY name(name),
KEY base(base),
KEY last_log(last_log)) ENGINE=".$DB['type']." CHARSET=UTF8MB4");
db_query($_tmp, $DB_CONNECT);
db_query("OPTIMIZE TABLE ".$table['s_mbrshipping'],$DB_CONNECT);
}

//인증코드 저장
$_tmp = db_query( "select count(*) from ".$table['s_code'], $DB_CONNECT );
if ( !$_tmp ) {
$_tmp = ("
CREATE TABLE ".$table['s_code']." (
uid     INT           PRIMARY KEY  NOT NULL AUTO_INCREMENT,
mbruid	INT				    DEFAULT '0'		NOT NULL,
name	  VARCHAR(30)		DEFAULT ''		NOT NULL,
entry  	INT				DEFAULT '0'		NOT NULL,
code		VARCHAR(100)	DEFAULT ''		NOT NULL,
sms   	TINYINT			  DEFAULT '0'		NOT NULL,
email 	TINYINT		  	DEFAULT '0'		NOT NULL,
d_regis	VARCHAR(14)		DEFAULT ''		NOT NULL,
KEY mbruid(mbruid),
KEY name(name),
KEY entry(entry),
KEY email(email),
KEY sms(sms),
KEY d_regis(d_regis)) ENGINE=".$DB['type']." CHARSET=UTF8MB4");
db_query($_tmp, $DB_CONNECT);
db_query("OPTIMIZE TABLE ".$table['s_code'],$DB_CONNECT);
}


//SEO테이블
$_tmp = db_query( "select count(*) from ".$table['s_seo'], $DB_CONNECT );
if ( !$_tmp ) {
$_tmp = ("

CREATE TABLE ".$table['s_seo']." (
uid			INT				PRIMARY KEY		NOT NULL AUTO_INCREMENT,
rel			TINYINT			DEFAULT '0'		NOT NULL,
parent		INT				DEFAULT '0'		NOT NULL,
title		VARCHAR(200)	DEFAULT ''		NOT NULL,
keywords	VARCHAR(200)	DEFAULT ''		NOT NULL,
description	TEXT			DEFAULT ''		NOT NULL,
classification	VARCHAR(200)	DEFAULT ''		NOT NULL,
image_src	TEXT			DEFAULT ''		NOT NULL,
replyto		VARCHAR(50)		DEFAULT ''		NOT NULL,
language	CHAR(2)			DEFAULT ''		NOT NULL,
build		VARCHAR(14)		DEFAULT ''		NOT NULL,
KEY rel(rel),
KEY parent(parent)) ENGINE=".$DB['type']." CHARSET=UTF8MB4");
db_query($_tmp, $DB_CONNECT);
db_query("OPTIMIZE TABLE ".$table['s_seo'],$DB_CONNECT);
}
//확장로그
$_tmp = db_query( "select count(*) from ".$table['s_xtralog'], $DB_CONNECT );
if ( !$_tmp ) {
$_tmp = ("
CREATE TABLE ".$table['s_xtralog']." (
module		VARCHAR(30)		DEFAULT ''		NOT NULL,
parent		INT				DEFAULT '0'		NOT NULL,
down		TEXT			NOT NULL,
score1		TEXT			NOT NULL,
score2		TEXT			NOT NULL,
report		TEXT			NOT NULL,
KEY module(module),
KEY parent(parent)) ENGINE=".$DB['type']." CHARSET=UTF8MB4");
db_query($_tmp, $DB_CONNECT);
db_query("OPTIMIZE TABLE ".$table['s_xtralog'],$DB_CONNECT);
}

//메시지 템플릿
$_tmp = db_query( "select count(*) from ".$table['s_msgdoc'], $DB_CONNECT );
if ( !$_tmp ) {
$_tmp = ("
CREATE TABLE ".$table['s_msgdoc']." (
uid			  INT				PRIMARY KEY		NOT NULL AUTO_INCREMENT,
msgtype	  TINYINT			DEFAULT '0'		NOT NULL,
module	  VARCHAR(30)		DEFAULT ''		NOT NULL,
name		  VARCHAR(50)		DEFAULT ''		NOT NULL,
title 	  VARCHAR(100)		DEFAULT ''		NOT NULL,
message		TEXT			NOT NULL,
referer		VARCHAR(250)	DEFAULT ''		NOT NULL,
button	  VARCHAR(50)		DEFAULT ''		NOT NULL,
html		VARCHAR(4)		DEFAULT ''		NOT NULL,
email		  INT				DEFAULT '0'		NOT NULL,
push		  INT				DEFAULT '0'		NOT NULL,
KEY uid(uid),
KEY msgtype(msgtype),
KEY module(module),

KEY d_read(d_read)) ENGINE=".$DB['type']." CHARSET=UTF8MB4");
db_query($_tmp, $DB_CONNECT);
db_query("OPTIMIZE TABLE ".$table['s_msgdoc'],$DB_CONNECT);
}

//알림데이터
$_tmp = db_query( "select count(*) from ".$table['s_notice'], $DB_CONNECT );
if ( !$_tmp ) {
$_tmp = ("
CREATE TABLE ".$table['s_notice']." (
uid			  CHAR(16)		DEFAULT ''		NOT NULL,
mbruid		INT				DEFAULT '0'		NOT NULL,
site		  INT				DEFAULT '0'		NOT NULL,
frommodule	VARCHAR(30)		DEFAULT ''		NOT NULL,
frommbr		INT				DEFAULT '0'		NOT NULL,
title 	  VARCHAR(100)		DEFAULT ''		NOT NULL,
message		TEXT			NOT NULL,
referer		VARCHAR(250)	DEFAULT ''		NOT NULL,
button	  VARCHAR(50)		DEFAULT ''		NOT NULL,
tag		    VARCHAR(20)		DEFAULT ''		NOT NULL,
d_regis		VARCHAR(14)		DEFAULT ''		NOT NULL,
d_read		VARCHAR(14)		DEFAULT ''		NOT NULL,
email		  INT				DEFAULT '0'		NOT NULL,
push		  INT				DEFAULT '0'		NOT NULL,
KEY uid(uid),
KEY mbruid(mbruid),
KEY site(site),
KEY frommbr(frommbr),
KEY email(email),
KEY push(push),
KEY d_read(d_read)) ENGINE=".$DB['type']." CHARSET=UTF8MB4");
db_query($_tmp, $DB_CONNECT);
db_query("OPTIMIZE TABLE ".$table['s_notice'],$DB_CONNECT);
}

//피드테이블
$_tmp = db_query( "select count(*) from ".$table['s_feed'], $DB_CONNECT );
if ( !$_tmp ) {
$_tmp = ("
CREATE TABLE ".$table['s_feed']." (
uid			BIGINT			PRIMARY KEY		NOT NULL AUTO_INCREMENT,
site		    INT				DEFAULT '0'		NOT NULL,
mbruid		INT				DEFAULT '0'		NOT NULL,
module	VARCHAR(30)		DEFAULT ''		NOT NULL,
category	VARCHAR(50)		DEFAULT ''		NOT NULL,
entry  		INT				DEFAULT '0'		NOT NULL,
display		  TINYINT			DEFAULT '0'		NOT NULL,
hidden		  TINYINT			DEFAULT '0'		NOT NULL,
url			VARCHAR(250)	DEFAULT ''		NOT NULL,
d_regis		VARCHAR(14)		DEFAULT ''		NOT NULL,
KEY mbruid(mbruid),
KEY display(display),
KEY d_regis(d_regis)) ENGINE=".$DB['type']." CHARSET=UTF8MB4");
db_query($_tmp, $DB_CONNECT);
db_query("OPTIMIZE TABLE ".$table['s_feed'],$DB_CONNECT);
}

//히스토리
$_tmp = db_query( "select count(*) from ".$table['s_history'], $DB_CONNECT );
if ( !$_tmp ) {
$_tmp = ("

CREATE TABLE ".$table['s_history']." (
uid			INT				PRIMARY KEY		NOT NULL AUTO_INCREMENT,
site		    INT				DEFAULT '0'		NOT NULL,
mbruid	INT				DEFAULT '0'		NOT NULL,
module	VARCHAR(30)		DEFAULT ''		NOT NULL,
entry		INT				DEFAULT '0'		NOT NULL,
d_regis	VARCHAR(14)		DEFAULT ''		NOT NULL,
date		CHAR(8)			DEFAULT ''		NOT NULL,
KEY mbruid(mbruid),
KEY entry(entry),
KEY d_regis(d_regis)) ENGINE=".$DB['type']." CHARSET=UTF8MB4");
db_query($_tmp, $DB_CONNECT);
db_query("OPTIMIZE TABLE ".$table['s_history'],$DB_CONNECT);
}

//git패치이력
$_tmp = db_query( "select count(*) from ".$table['s_gitlog'], $DB_CONNECT );
if ( !$_tmp ) {
$_tmp = ("

CREATE TABLE ".$table['s_gitlog']." (
uid			INT				PRIMARY KEY		NOT NULL AUTO_INCREMENT,
mbruid	INT				DEFAULT '0'		NOT NULL,
version	VARCHAR(30)		DEFAULT ''		NOT NULL,
remote	VARCHAR(150)		DEFAULT ''		NOT NULL,
command	VARCHAR(100)		DEFAULT ''		NOT NULL,
output		TEXT			NOT NULL,
d_regis	VARCHAR(14)		DEFAULT ''		NOT NULL,
KEY mbruid(mbruid),
KEY remote(remote),
KEY command(command),
KEY d_regis(d_regis)) ENGINE=".$DB['type']." CHARSET=UTF8MB4");
db_query($_tmp, $DB_CONNECT);
db_query("OPTIMIZE TABLE ".$table['s_gitlog'],$DB_CONNECT);
}

?>
