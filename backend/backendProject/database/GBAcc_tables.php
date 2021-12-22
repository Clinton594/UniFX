<?php

$query1 = "CREATE table IF NOT EXISTS company_info (
	id int unsigned not null auto_increment,
	primary key (id),
	name varchar(250) null,
	logo_ref text null,
	website varchar(250) null,
	email varchar(250) null,
	phone varchar(15) null,
	address varchar(250) null,
	other text null,
	slider text DEFAULT NULL,
	branches text
)";

$query2 = "CREATE table if not exists roles (
	id int unsigned not null auto_increment,
	primary key (id),
	transcid varchar(50),
	rolename varchar(255),
	roledesc text DEFAULT NULL,
	clientid int
)";

$query3 = "CREATE table if not exists activitylog (
	id int(11) unsigned not null auto_increment,
	primary key (id),
	user_id int(50),
	action varchar(250),
	type varchar(10) default 'admin',
	location varchar(250),
	location_id varchar(50),
	description varchar(250),
	date DATETIME NULL DEFAULT CURRENT_TIMESTAMP
)";

$query4 = "CREATE table if not exists users (
	id int unsigned not null auto_increment,
	primary key (id),
	first_name varchar(50) default null,
	last_name varchar(50) default null,
	email varchar(50) default null,
	picture_ref varchar(250) default null,
	username varchar(50) default null,
	country varchar(15) default null,
	phone varchar(15) default null,
	password text not null,
	gender varchar(2) default null,
	wallet text default null,
	balance double NOT NULL DEFAULT 0,
	terra double NOT NULL DEFAULT '0.0000',
	type tinyint default 0,
	status tinyint default 0,
	role tinyint default 0,
	access_level tinyint default 0,
	kyc_status tinyint default 0,
	kyc_identity varchar(250) default null,
	date DATETIME NULL DEFAULT CURRENT_TIMESTAMP
)";

$query5 = "CREATE table if not exists content (
	id int unsigned not null auto_increment,
	primary key (id),
	title varchar(250),
	body longtext DEFAULT NULL,
	image text DEFAULT NULL,
	url varchar(250),
	unique key (url),
	category varchar(250),
	parent varchar(250),
	label varchar(250),
	business varchar(250),
	auto varchar(250),
	view varchar(250),
	product varchar(250),
	product_desc text,
	type text DEFAULT NULL,
	status int(11) default 0,
	no_of_views int(11) default 0,
	user_id int(50) default 0,
	author int(50) NULL,
	date_uploaded DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
	date_updated DATETIME NULL DEFAULT CURRENT_TIMESTAMP
)";

$query6 = "CREATE TABLE IF NOT EXISTS referral (
 id int unsigned not null auto_increment,
 primary key (id),
 referral_id int(50) default 0,
 referred_id int(50) default 0,
 status tinyint NOT NULL DEFAULT 0,
 amount double NOT NULL DEFAULT 0,
 date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
)";
$query7 = "CREATE table if not exists conversation (
	id int unsigned not null auto_increment,
	primary key (id),
	post_id int(50) NULL,
	user_id int(50) NULL,
	parent_message int(11) NULL,
	title varchar(250) NULL,
	message text DEFAULT NULL,
	type varchar(250) NULL,
	user_name varchar(250) NULL,
	time DATETIME NULL DEFAULT CURRENT_TIMESTAMP
	)";
