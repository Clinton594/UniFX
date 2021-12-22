<?php
$query11 = "CREATE TABLE IF NOT EXISTS accounts (
 id int(10) NOT NULL AUTO_INCREMENT,
 user_id int(10) NOT NULL,
 plan int(11) NOT NULL,
 roi float NOT NULL DEFAULT 0.0,
 amount int(11) NOT NULL DEFAULT 0,
 capital int(11) NOT NULL DEFAULT 0,
 name varchar(50) NOT NULL,
 identify varchar(50) NOT NULL DEFAULT 'investment',
 duration varchar(50) NOT NULL DEFAULT '6 Months',
 reoccur varchar(50) NOT NULL DEFAULT '7 Days',
 reinvested double NOT NULL DEFAULT 0,
 status tinyint(2) NOT NULL DEFAULT 0,
 date_created datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
 last_topup datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
 next_unlock datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
 PRIMARY KEY (id)
) ";

$query12 = "CREATE TABLE IF NOT EXISTS transaction (
 id int(10) NOT NULL AUTO_INCREMENT,
 user_id int(11) NOT NULL DEFAULT 0,
 tx_no varchar(250) NOT NULL,
 tx_type varchar(50) NOT NULL,
 account_id int(10) DEFAULT 0,
 amount double NOT NULL,
 description varchar(100) NOT NULL,
 paid_into varchar(250) DEFAULT NULL,
 snapshot varchar(250) DEFAULT NULL,
 account_details varchar(250) DEFAULT NULL,
 temp varchar(250) DEFAULT NULL,
 status int(10) NOT NULL DEFAULT 0,
 date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
 PRIMARY KEY (id)
)";

$query8 = "CREATE TABLE IF NOT EXISTS coins (
  id int(10) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (id),
  symbol varchar(5) DEFAULT NULL,
  name varchar(50) DEFAULT NULL,
  logo varchar(250) DEFAULT NULL,
  coin_id varchar(50) DEFAULT '0',
  wallet varchar(250) DEFAULT NULL,
  network varchar(250) DEFAULT NULL,
  qr_code varchar(250) DEFAULT NULL,
  withdrawal tinyint DEFAULT 0,
  date_created datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ";
