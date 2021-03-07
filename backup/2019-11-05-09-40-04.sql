DROP TABLE IF EXISTS tbl_asset_types;

CREATE TABLE `tbl_asset_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(220) COLLATE utf8_unicode_ci NOT NULL,
  `deleted` int(11) NOT NULL,
  `defaults` int(11) NOT NULL DEFAULT '0',
  `removed_by` int(11) NOT NULL DEFAULT '0',
  `created_at` int(11) DEFAULT NULL,
  `changed_at` int(11) DEFAULT NULL,
  `users_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;




DROP TABLE IF EXISTS tbl_assets;

CREATE TABLE `tbl_assets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `asset_types_id` int(11) NOT NULL,
  `cost` double(10,2) NOT NULL,
  `currencies_id` int(11) NOT NULL,
  `rate` double(16,4) NOT NULL,
  `banks_id` int(11) NOT NULL,
  `useful_age` int(10) DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `home_amount` double(10,2) NOT NULL,
  `deleted` int(11) NOT NULL,
  `removed_by` int(11) NOT NULL DEFAULT '0',
  `created_at` int(11) DEFAULT NULL,
  `changed_at` int(11) DEFAULT NULL,
  `users_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;




DROP TABLE IF EXISTS tbl_backup;

CREATE TABLE `tbl_backup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  `deleted` int(11) NOT NULL,
  `verified` int(11) NOT NULL DEFAULT '1',
  `users_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




DROP TABLE IF EXISTS tbl_bank_exchange;

CREATE TABLE `tbl_bank_exchange` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(40) NOT NULL,
  `source_bank_id` int(11) NOT NULL,
  `destination_banks_id` int(11) NOT NULL,
  `currencies_id` int(11) NOT NULL,
  `des_currencies_id` int(11) NOT NULL,
  `exchange_rate` double(10,8) NOT NULL,
  `amount` double(11,2) NOT NULL,
  `des_amount` double(10,2) NOT NULL,
  `description` text NOT NULL,
  `approved` int(11) NOT NULL DEFAULT '1',
  `home_amount` double(10,2) NOT NULL,
  `des_home_amount` double(10,2) NOT NULL,
  `rate` double(10,8) NOT NULL,
  `des_rate` double(10,8) NOT NULL,
  `deleted` int(11) NOT NULL,
  `removed_by` int(11) NOT NULL DEFAULT '0',
  `verified` int(11) NOT NULL,
  `verified_by` int(11) NOT NULL,
  `check_cash` varchar(40) NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  `changed_at` int(11) DEFAULT NULL,
  `users_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




DROP TABLE IF EXISTS tbl_bank_statement;

CREATE TABLE `tbl_bank_statement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(20) NOT NULL,
  `place` varchar(100) NOT NULL,
  `reference` varchar(100) NOT NULL,
  `transaction_type` int(11) NOT NULL,
  `amount` double(34,2) NOT NULL,
  `banks_id` int(11) NOT NULL,
  `currencies_id` int(11) NOT NULL,
  `rate` double(10,5) DEFAULT NULL,
  `home_amount` double(20,2) NOT NULL,
  `description` text NOT NULL,
  `categories_id` int(11) DEFAULT NULL,
  `sub_categories_id` int(11) DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `removed_by` int(11) NOT NULL DEFAULT '0',
  `created_at` int(11) DEFAULT NULL,
  `changed_at` int(11) DEFAULT NULL,
  `users_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

INSERT INTO tbl_bank_statement VALUES("1","2019-11-03","Services Provider Payment","1","1","20000.00","1","144","1.00000","20000.00","We are paid.","2","","0","0","1572760301","","25"),
("2","2019-11-03","Payment to Service Provider","1","2","190.00","1","144","1.00000","190.00","we are going to do everything","2","","0","0","1572775236","","25"),
("3","2019-11-03","Payment to Service Provider","2","2","120.00","1","144","1.00000","120.00","We are going to do something for you.","2","","0","0","1572776146","","25"),
("4","2019-11-03","Payment to Service Provider","3","2","120.00","1","144","1.00000","120.00","We are going to speak In English my brother","1","","0","0","1572777322","","25"),
("5","2019-11-03","Payment to Service Provider","4","2","120.00","1","144","1.00000","120.00","This is another point which we are going to speak with you","1","","0","0","1572777446","","25"),
("6","2019-11-04","Opening Balance","2","1","20000.00","2","3","0.01320","264.00","a description is the best way to describe everything.","","","0","0","1572842913","","25"),
("7","2019-11-04","Customer Payment Invoice","1","1","900.00","2","3","0.01320","11.88","","2","","0","0","1572849131","","25"),
("8","2019-11-04","Vendor Payment Bill","1","2","40000.00","1","144","1.00000","40000.00","","1","","0","0","1572853100","","25");



DROP TABLE IF EXISTS tbl_banks;

CREATE TABLE `tbl_banks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `category_id` int(11) NOT NULL,
  `date` varchar(20) NOT NULL,
  `opening_balance` double NOT NULL,
  `currencies_id` int(11) NOT NULL,
  `rate` double NOT NULL,
  `home_amount` double NOT NULL,
  `description` text NOT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `defaults` int(11) NOT NULL DEFAULT '0',
  `removed_by` int(11) NOT NULL DEFAULT '0',
  `created_at` int(11) DEFAULT NULL,
  `changed_at` int(11) DEFAULT NULL,
  `users_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

INSERT INTO tbl_banks VALUES("1","Azizi Bank USD","1","2019-11-03","12000","144","1","12000","We are going to describe something","0","0","0","1572757076","","25"),
("2","Azizi Bank - AFA","1","2019-11-04","20000","3","0.0132","264","a description is the best way to describe everything.","0","0","0","1572842913","","25");



DROP TABLE IF EXISTS tbl_banks_category;

CREATE TABLE `tbl_banks_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `users_id` int(11) NOT NULL,
  `verified` int(11) NOT NULL,
  `verified_by` int(11) NOT NULL,
  `deleted` smallint(6) DEFAULT NULL,
  `defaults` int(11) NOT NULL DEFAULT '0',
  `removed_by` int(11) NOT NULL DEFAULT '0',
  `created_at` int(11) DEFAULT NULL,
  `changed_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

INSERT INTO tbl_banks_category VALUES("1","Azizi Bank - 02","25","1","0","0","0","0","1572757057","");



DROP TABLE IF EXISTS tbl_cash_factor;

CREATE TABLE `tbl_cash_factor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(20) NOT NULL,
  `stocks_id` int(11) NOT NULL,
  `currencies_id` int(11) NOT NULL,
  `rate` double(10,2) NOT NULL,
  `banks_id` int(11) NOT NULL,
  `customer_name` varchar(190) NOT NULL,
  `factor_payment` double(20,2) NOT NULL,
  `factor_number` int(11) NOT NULL,
  `home_amount` double(20,2) NOT NULL,
  `description` text NOT NULL,
  `users_id` int(11) NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  `changed_at` int(11) DEFAULT NULL,
  `deleted` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




DROP TABLE IF EXISTS tbl_cash_factor_details;

CREATE TABLE `tbl_cash_factor_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title_bills_id` int(11) NOT NULL,
  `items_id` int(11) NOT NULL,
  `items_unit_id` int(11) NOT NULL,
  `amount` decimal(10,0) NOT NULL,
  `fee` decimal(10,0) NOT NULL,
  `total_amount` decimal(10,0) NOT NULL,
  `description` text NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  `changed_at` int(11) DEFAULT NULL,
  `users_id` int(11) NOT NULL,
  `deleted` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




DROP TABLE IF EXISTS tbl_currencies;

CREATE TABLE `tbl_currencies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) DEFAULT NULL,
  `code` char(3) DEFAULT NULL,
  `deleted` smallint(11) NOT NULL,
  `removed_by` int(11) NOT NULL DEFAULT '0',
  `verified` int(11) NOT NULL DEFAULT '1',
  `users_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_currency_name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=168 DEFAULT CHARSET=utf8;

INSERT INTO tbl_currencies VALUES("1","Andorran Peseta","ADP","1","0","1","1"),
("2","United Arab Emirates Dirham","AED","0","0","1","1"),
("3","Afghanistan Afghani","AFA","0","0","1","1"),
("4","Albanian Lek","ALL","1","0","1","1"),
("5","Netherlands Antillian Guilder","ANG","1","0","1","1"),
("6","Angolan Kwanza","AOK","1","0","1","1"),
("7","Argentine Peso","ARS","1","0","1","1"),
("9","Australian Dollar","AUD","1","0","1","1"),
("10","Aruban Florin","AWG","1","0","1","1"),
("11","Barbados Dollar","BBD","1","0","1","1"),
("12","Bangladeshi Taka","BDT","1","0","1","1"),
("14","Bulgarian Lev","BGN","1","0","1","1"),
("15","Bahraini Dinar","BHD","1","0","1","1"),
("16","Burundi Franc","BIF","1","0","1","1"),
("17","Bermudian Dollar","BMD","1","0","1","1"),
("18","Brunei Dollar","BND","1","0","1","1"),
("19","Bolivian Boliviano","BOB","1","0","1","1"),
("20","Brazilian Real","BRL","1","0","1","1"),
("21","Bahamian Dollar","BSD","1","0","1","1"),
("22","Bhutan Ngultrum","BTN","1","0","1","1"),
("23","Burma Kyat","BUK","1","0","1","1"),
("24","Botswanian Pula","BWP","1","0","1","1"),
("25","Belize Dollar","BZD","1","0","1","1"),
("26","Canadian Dollar","CAD","1","0","1","1"),
("27","Swiss Franc","CHF","1","0","1","1"),
("28","Chilean Unidades de Fomento","CLF","1","0","1","1"),
("29","Chilean Peso","CLP","1","0","1","1"),
("30","Yuan (Chinese) Renminbi","CNY","1","0","1","1"),
("31","Colombian Peso","COP","1","0","1","1"),
("32","Costa Rican Colon","CRC","1","0","1","1"),
("33","Czech Republic Koruna","CZK","1","0","1","1"),
("34","Cuban Peso","CUP","1","0","1","1"),
("35","Cape Verde Escudo","CVE","1","0","1","1"),
("36","Cyprus Pound","CYP","1","0","1","1"),
("40","Danish Krone","DKK","1","0","1","1"),
("41","Dominican Peso","DOP","1","0","1","1"),
("42","Algerian Dinar","DZD","1","0","1","1"),
("43","Ecuador Sucre","ECS","1","0","1","1"),
("44","Egyptian Pound","EGP","1","0","1","1"),
("45","Estonian Kroon (EEK)","EEK","1","0","1","1"),
("46","Ethiopian Birr","ETB","1","0","1","1"),
("47","Euro","EUR","0","0","1","1"),
("49","Fiji Dollar","FJD","1","0","1","1"),
("50","Falkland Islands Pound","FKP","1","0","1","1"),
("52","British Pound","GBP","1","0","1","1"),
("53","Ghanaian Cedi","GHC","1","0","1","1"),
("54","Gibraltar Pound","GIP","1","0","1","1"),
("55","Gambian Dalasi","GMD","1","0","1","1"),
("56","Guinea Franc","GNF","1","0","1","1"),
("58","Guatemalan Quetzal","GTQ","1","0","1","1"),
("59","Guinea-Bissau Peso","GWP","1","0","1","1"),
("60","Guyanan Dollar","GYD","1","0","1","1"),
("61","Hong Kong Dollar","HKD","1","0","1","1"),
("62","Honduran Lempira","HNL","1","0","1","1"),
("63","Haitian Gourde","HTG","1","0","1","1"),
("64","Hungarian Forint","HUF","1","0","1","1"),
("65","Indonesian Rupiah","IDR","1","0","1","1"),
("66","Irish Punt","IEP","1","0","1","1"),
("67","Israeli Shekel","ILS","1","0","1","1"),
("68","Indian Rupee","INR","1","0","1","1"),
("69","Iraqi Dinar","IQD","1","0","1","1"),
("70","Iranian Rial","IRR","1","0","1","1"),
("73","Jamaican Dollar","JMD","1","0","1","1"),
("74","Jordanian Dinar","JOD","1","0","1","1"),
("75","Japanese Yen","JPY","1","0","1","1"),
("76","Kenyan Schilling","KES","1","0","1","1"),
("77","Kampuchean (Cambodian) Riel","KHR","1","0","1","1"),
("78","Comoros Franc","KMF","1","0","1","1"),
("79","North Korean Won","KPW","1","0","1","1"),
("80","(South) Korean Won","KRW","1","0","1","1"),
("81","Kuwaiti Dinar","KWD","1","0","1","1"),
("82","Cayman Islands Dollar","KYD","1","0","1","1"),
("83","Lao Kip","LAK","1","0","1","1"),
("84","Lebanese Pound","LBP","1","0","1","1"),
("85","Sri Lanka Rupee","LKR","1","0","1","1"),
("86","Liberian Dollar","LRD","1","0","1","1"),
("87","Lesotho Loti","LSL","1","0","1","1"),
("89","Libyan Dinar","LYD","1","0","1","1"),
("90","Moroccan Dirham","MAD","1","0","1","1"),
("91","Malagasy Franc","MGF","1","0","1","1"),
("92","Mongolian Tugrik","MNT","1","0","1","1"),
("93","Macau Pataca","MOP","1","0","1","1"),
("94","Mauritanian Ouguiya","MRO","1","0","1","1"),
("95","Maltese Lira","MTL","1","0","1","1"),
("96","Mauritius Rupee","MUR","1","0","1","1"),
("97","Maldive Rufiyaa","MVR","1","0","1","1"),
("98","Malawi Kwacha","MWK","1","0","1","1"),
("99","Mexican Peso","MXP","1","0","1","1"),
("100","Malaysian Ringgit","MYR","1","0","1","1"),
("101","Mozambique Metical","MZM","1","0","1","1"),
("102","Namibian Dollar","NAD","1","0","1","1"),
("103","Nigerian Naira","NGN","1","0","1","1"),
("104","Nicaraguan Cordoba","NIO","1","0","1","1"),
("105","Norwegian Kroner","NOK","1","0","1","1"),
("106","Nepalese Rupee","NPR","1","0","1","1"),
("107","New Zealand Dollar","NZD","1","0","1","1"),
("108","Omani Rial","OMR","1","0","1","1"),
("109","Panamanian Balboa","PAB","1","0","1","1"),
("110","Peruvian Nuevo Sol","PEN","1","0","1","1"),
("111","Papua New Guinea Kina","PGK","1","0","1","1"),
("112","Philippine Peso","PHP","1","0","1","1"),
("113","Pakistan Rupee","PKR","0","0","1","1"),
("114","Polish Zloty","PLN","1","0","1","1"),
("116","Paraguay Guarani","PYG","1","0","1","1"),
("117","Qatari Rial","QAR","1","0","1","1"),
("118","Romanian Leu","RON","1","0","1","1"),
("119","Rwanda Franc","RWF","1","0","1","1"),
("120","Saudi Arabian Riyal","SAR","1","0","1","1"),
("121","Solomon Islands Dollar","SBD","1","0","1","1"),
("122","Seychelles Rupee","SCR","1","0","1","1"),
("123","Sudanese Pound","SDP","1","0","1","1"),
("124","Swedish Krona","SEK","1","0","1","1"),
("125","Singapore Dollar","SGD","1","0","1","1"),
("126","St. Helena Pound","SHP","1","0","1","1"),
("127","Sierra Leone Leone","SLL","1","0","1","1"),
("128","Somali Schilling","SOS","1","0","1","1"),
("129","Suriname Guilder","SRG","1","0","1","1"),
("130","Sao Tome and Principe Dobra","STD","1","0","1","1"),
("131","Russian Ruble","RUB","1","0","1","1"),
("132","El Salvador Colon","SVC","1","0","1","1"),
("133","Syrian Potmd","SYP","1","0","1","1"),
("134","Swaziland Lilangeni","SZL","1","0","1","1"),
("135","Thai Baht","THB","1","0","1","1"),
("136","Tunisian Dinar","TND","1","0","1","1"),
("137","Tongan Paanga","TOP","1","0","1","1"),
("138","East Timor Escudo","TPE","1","0","1","1"),
("139","Turkish Lira","TRY","1","0","1","1"),
("140","Trinidad and Tobago Dollar","TTD","1","0","1","1"),
("141","Taiwan Dollar","TWD","1","0","1","1"),
("142","Tanzanian Schilling","TZS","1","0","1","1"),
("143","Uganda Shilling","UGX","1","0","1","1"),
("144","US Dollar","USD","0","0","1","1"),
("145","Uruguayan Peso","UYU","1","0","1","1"),
("146","Venezualan Bolivar","VEF","1","0","1","1"),
("147","Vietnamese Dong","VND","1","0","1","1"),
("148","Vanuatu Vatu","VUV","1","0","1","1"),
("149","Samoan Tala","WST","1","0","1","1"),
("150","CommunautÃƒÂ© FinanciÃƒÂ¨re Africaine BEAC, Francs","XAF","1","0","1","1"),
("151","Silver, Ounces","XAG","1","0","1","1"),
("152","Gold, Ounces","XAU","1","0","1","1"),
("153","East Caribbean Dollar","XCD","1","0","1","1"),
("154","International Monetary Fund (IMF) Special Drawing Rights","XDR","1","0","1","1"),
("155","CommunautÃƒÂ© FinanciÃƒÂ¨re Africaine BCEAO - Francs","XOF","1","0","1","1"),
("156","Palladium Ounces","XPD","1","0","1","1"),
("157","Comptoirs FranÃƒÂ§ais du Pacifique Francs","XPF","1","0","1","1"),
("158","Platinum, Ounces","XPT","1","0","1","1"),
("159","Democratic Yemeni Dinar","YDD","1","0","1","1"),
("160","Yemeni Rial","YER","1","0","1","1"),
("161","New Yugoslavia Dinar","YUD","1","0","1","1"),
("162","South African Rand","ZAR","1","0","1","1"),
("163","Zambian Kwacha","ZMK","1","0","1","1"),
("164","Zaire Zaire","ZRZ","1","0","1","1"),
("165","Zimbabwe Dollar","ZWD","1","0","1","1"),
("166","Slovak Koruna","SKK","1","0","1","1"),
("167","Armenian Dram","AMD","1","0","1","1");



DROP TABLE IF EXISTS tbl_currency_rate;

CREATE TABLE `tbl_currency_rate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(40) COLLATE utf16_persian_ci NOT NULL,
  `rate` double(10,4) NOT NULL,
  `currencies_id` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  `deleted` smallint(11) NOT NULL DEFAULT '0',
  `removed_by` int(11) DEFAULT '0',
  `verified` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf16 COLLATE=utf16_persian_ci;

INSERT INTO tbl_currency_rate VALUES("1","02/04/2019","76.0500","144","15","0","0","1"),
("2","02/04/2019","1.0000","3","11","0","0","1"),
("3","07/04/2019","76.9000","144","22","0","0","1"),
("4","2019-05-01","1.0000","144","22","0","0","1"),
("5","2019-05-01","0.0132","3","22","0","0","1"),
("6","2019-07-06","1.0000","144","25","0","0","1"),
("7","2019-07-06","0.8700","47","25","0","0","1"),
("8","2019-10-20","0.0064","113","25","0","0","1");



DROP TABLE IF EXISTS tbl_customer_bill_details;

CREATE TABLE `tbl_customer_bill_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title_bills_id` int(11) NOT NULL,
  `items_id` int(11) NOT NULL,
  `items_unit_id` int(11) NOT NULL,
  `amount` decimal(10,0) NOT NULL,
  `fee` decimal(10,0) NOT NULL,
  `stocks_id` int(11) DEFAULT NULL,
  `total_amount` decimal(10,0) NOT NULL,
  `description` text NOT NULL,
  `users_id` int(11) NOT NULL,
  `deleted` int(11) NOT NULL,
  `removed_by` int(11) NOT NULL DEFAULT '0',
  `created_at` int(11) DEFAULT NULL,
  `changed_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

INSERT INTO tbl_customer_bill_details VALUES("1","1","2","1","300","23","2","6900","this is a test for everyone.","25","0","0","1572849131","");



DROP TABLE IF EXISTS tbl_customer_bill_title;

CREATE TABLE `tbl_customer_bill_title` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(20) NOT NULL,
  `customers_id` int(11) NOT NULL,
  `currencies_id` int(11) NOT NULL,
  `rate` double NOT NULL,
  `factor_number` varchar(50) NOT NULL,
  `banks_id` int(11) NOT NULL,
  `factor_price` decimal(10,0) NOT NULL,
  `factor_payment` decimal(10,0) NOT NULL,
  `description` text NOT NULL,
  `due_date` varchar(60) NOT NULL,
  `status_movement` int(11) NOT NULL DEFAULT '0',
  `home_amount` double(10,2) NOT NULL,
  `home_amount_total_factor_price` double(14,2) NOT NULL,
  `users_id` int(11) NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  `changed_at` int(11) DEFAULT NULL,
  `deleted` int(11) NOT NULL,
  `removed_by` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

INSERT INTO tbl_customer_bill_title VALUES("1","2019-11-04","2","3","0.0132","2134","2","6900","900","","2019-11-04","1","11.88","91.08","25","1572849131","","0","0");



DROP TABLE IF EXISTS tbl_customer_categories;

CREATE TABLE `tbl_customer_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `users_id` int(11) NOT NULL,
  `deleted` int(11) DEFAULT NULL,
  `defaults` int(11) NOT NULL DEFAULT '0',
  `removed_by` int(11) NOT NULL DEFAULT '0',
  `created_at` int(11) DEFAULT NULL,
  `changed_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

INSERT INTO tbl_customer_categories VALUES("1","بسی","25","0","0","0","1572781207",""),
("2","Chines","25","0","0","0","1572842269",""),
("3","Japanes","25","0","0","0","1572842473","");



DROP TABLE IF EXISTS tbl_customer_payment;

CREATE TABLE `tbl_customer_payment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(40) NOT NULL,
  `customers_id` int(11) NOT NULL,
  `currencies_id` int(11) NOT NULL,
  `amount` double(20,2) NOT NULL,
  `rate` double(10,2) NOT NULL,
  `banks_id` int(11) NOT NULL,
  `factor_number` varchar(45) NOT NULL,
  `description` text NOT NULL,
  `payment_type` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `reference_id` int(11) DEFAULT NULL,
  `home_amount` double(25,2) NOT NULL,
  `users_id` int(11) NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  `changed_at` int(11) DEFAULT NULL,
  `deleted` int(11) NOT NULL,
  `removed_by` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

INSERT INTO tbl_customer_payment VALUES("1","2019-11-04","2","3","900.00","0.01","2","2134","","1","0","1","11.88","25","1572849131","","0","0");



DROP TABLE IF EXISTS tbl_customer_statement;

CREATE TABLE `tbl_customer_statement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(20) NOT NULL,
  `place` varchar(100) NOT NULL,
  `reference` varchar(100) NOT NULL,
  `transaction_type` int(11) NOT NULL,
  `amount` double NOT NULL,
  `customers_id` int(11) NOT NULL,
  `currencies_id` int(11) NOT NULL,
  `rate` double NOT NULL,
  `home_amount` double NOT NULL,
  `description` text NOT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `created_at` int(11) DEFAULT NULL,
  `changed_at` int(11) DEFAULT NULL,
  `users_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

INSERT INTO tbl_customer_statement VALUES("1","2019-11-04","Customer Opening Balance","1","2","200","1","144","1","200","We are going to do something for yourself.","0","1572842303","","25"),
("2","2019-11-04","Customer Opening Balance","2","2","2000","2","3","0.0132","26.4","He is living in Herat","0","1572842512","","25"),
("3","2019-11-04","Total Customer Factor Amount","1","2","6900","2","3","0.0132","91.08","","0","1572849131","","25"),
("4","2019-11-04","Customer Payment","1","1","900","2","3","0.0132","11.88","","0","1572849131","","25");



DROP TABLE IF EXISTS tbl_customers;

CREATE TABLE `tbl_customers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `contact` varchar(45) NOT NULL,
  `opening_balance` double NOT NULL,
  `currencies_id` int(11) NOT NULL,
  `rate` double(10,2) NOT NULL,
  `home_amount` double NOT NULL,
  `address` text NOT NULL,
  `customer_type` int(11) NOT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `defaults` int(11) NOT NULL DEFAULT '0',
  `removed_by` int(11) NOT NULL DEFAULT '0',
  `created_at` int(11) DEFAULT NULL,
  `changed_at` int(11) DEFAULT NULL,
  `users_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

INSERT INTO tbl_customers VALUES("1","2019-11-04","Abdul Karim","abdulKarim@gmail.com","200","144","1.00","200","We are going to do something for yourself.","2","0","0","0","1572842303","","25"),
("2","2019-11-04","Abdul Tawab","0700435527","2000","3","0.01","26.4","He is living in Herat","3","0","0","0","1572842512","","25");



DROP TABLE IF EXISTS tbl_dealer_statement;

CREATE TABLE `tbl_dealer_statement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(20) NOT NULL,
  `place` varchar(100) NOT NULL,
  `reference` varchar(100) NOT NULL,
  `transaction_type` int(11) NOT NULL,
  `amount` double NOT NULL,
  `dealers_id` int(11) NOT NULL,
  `currencies_id` int(11) NOT NULL,
  `rate` double NOT NULL,
  `home_amount` double NOT NULL,
  `description` text NOT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `created_at` int(11) DEFAULT NULL,
  `changed_at` int(11) DEFAULT NULL,
  `users_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




DROP TABLE IF EXISTS tbl_dealer_transaction;

CREATE TABLE `tbl_dealer_transaction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(40) NOT NULL,
  `due_date` varchar(200) NOT NULL,
  `dealers_id` int(11) NOT NULL,
  `currencies_id` int(11) NOT NULL,
  `amount` decimal(20,0) NOT NULL,
  `rate` double NOT NULL,
  `banks_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `type` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `home_amount` double NOT NULL,
  `check_cash` varchar(50) NOT NULL,
  `users_id` int(11) NOT NULL,
  `approved` int(11) NOT NULL DEFAULT '1',
  `status` int(11) NOT NULL DEFAULT '0',
  `request_type` int(11) NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  `changed_at` int(11) DEFAULT NULL,
  `deleted` int(11) NOT NULL,
  `removed_by` int(11) NOT NULL DEFAULT '0',
  `verified` int(11) NOT NULL,
  `verified_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




DROP TABLE IF EXISTS tbl_dealers;

CREATE TABLE `tbl_dealers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `family` varchar(100) NOT NULL,
  `contact` varchar(45) NOT NULL,
  `currencies_id` int(11) NOT NULL,
  `address` text NOT NULL,
  `request_type` int(11) NOT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `defaults` int(11) NOT NULL DEFAULT '0',
  `removed_by` int(11) NOT NULL DEFAULT '0',
  `created_at` int(11) DEFAULT NULL,
  `changed_at` int(11) DEFAULT NULL,
  `users_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




DROP TABLE IF EXISTS tbl_expense_categories;

CREATE TABLE `tbl_expense_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `users_id` int(11) NOT NULL,
  `deleted` smallint(6) DEFAULT NULL,
  `defaults` int(11) NOT NULL DEFAULT '0',
  `removed_by` int(11) NOT NULL DEFAULT '0',
  `created_at` int(11) DEFAULT NULL,
  `changed_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




DROP TABLE IF EXISTS tbl_expense_equipments;

CREATE TABLE `tbl_expense_equipments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(50) NOT NULL,
  `items_id` int(11) NOT NULL,
  `stocks_id` int(11) DEFAULT NULL,
  `items_unit_id` int(11) NOT NULL,
  `amount` double(10,2) NOT NULL,
  `fee` double(10,2) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `description` text NOT NULL,
  `users_id` int(11) NOT NULL,
  `deleted` int(11) NOT NULL,
  `removed_by` int(11) NOT NULL DEFAULT '0',
  `created_at` int(11) DEFAULT NULL,
  `changed_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

INSERT INTO tbl_expense_equipments VALUES("1","2019-10-31","1","2","3","100.00","0.00","0.00","","25","0","0","1572517190","");



DROP TABLE IF EXISTS tbl_expense_types;

CREATE TABLE `tbl_expense_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `expense_categories_id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `users_id` int(11) NOT NULL,
  `deleted` smallint(6) DEFAULT NULL,
  `defaults` int(11) DEFAULT '0',
  `removed_by` int(11) NOT NULL DEFAULT '0',
  `created_at` int(11) DEFAULT NULL,
  `changed_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




DROP TABLE IF EXISTS tbl_expenses;

CREATE TABLE `tbl_expenses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(100) NOT NULL,
  `expense_category_id` int(11) NOT NULL,
  `expense_type_id` int(11) NOT NULL,
  `amount` double(10,2) NOT NULL,
  `currencies_id` int(11) NOT NULL,
  `rate` double(10,6) NOT NULL,
  `banks_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `document` text NOT NULL,
  `home_amount` double(10,2) NOT NULL,
  `users_id` int(11) NOT NULL,
  `deleted` smallint(6) DEFAULT '0',
  `removed_by` int(11) NOT NULL DEFAULT '0',
  `created_at` int(11) DEFAULT NULL,
  `changed_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




DROP TABLE IF EXISTS tbl_income_categories;

CREATE TABLE `tbl_income_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `users_id` int(11) NOT NULL,
  `deleted` smallint(6) DEFAULT NULL,
  `defaults` int(11) NOT NULL DEFAULT '0',
  `removed_by` int(11) NOT NULL DEFAULT '0',
  `created_at` int(11) DEFAULT NULL,
  `changed_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




DROP TABLE IF EXISTS tbl_income_types;

CREATE TABLE `tbl_income_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `income_categories_id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `users_id` int(11) NOT NULL,
  `deleted` smallint(6) DEFAULT NULL,
  `defaults` int(11) NOT NULL DEFAULT '0',
  `removed_by` int(11) NOT NULL DEFAULT '0',
  `created_at` int(11) DEFAULT NULL,
  `changed_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




DROP TABLE IF EXISTS tbl_incomes;

CREATE TABLE `tbl_incomes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(100) NOT NULL,
  `income_category_id` int(11) NOT NULL,
  `income_type_id` int(11) NOT NULL,
  `amount` double(10,2) NOT NULL,
  `currencies_id` int(11) NOT NULL,
  `rate` double(10,2) NOT NULL,
  `banks_id` int(11) NOT NULL,
  `incomers_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `home_amount` double(10,2) NOT NULL,
  `users_id` int(11) NOT NULL,
  `deleted` smallint(6) DEFAULT NULL,
  `removed_by` int(11) NOT NULL DEFAULT '0',
  `created_at` int(11) DEFAULT NULL,
  `changed_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




DROP TABLE IF EXISTS tbl_item_categories;

CREATE TABLE `tbl_item_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `users_id` int(11) NOT NULL,
  `deleted` int(6) DEFAULT '0',
  `removed_by` int(11) NOT NULL DEFAULT '0',
  `defaults` int(11) NOT NULL DEFAULT '0',
  `created_at` int(11) DEFAULT NULL,
  `changed_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

INSERT INTO tbl_item_categories VALUES("1","Chines","25","0","0","0","1572495770",""),
("2","Japanes","25","0","0","0","1572495772","1572495787"),
("3","Spanish","25","0","0","0","1572495796",""),
("4","sdfsd","25","0","0","0","1572506278",""),
("5","Yes","25","0","0","0","1572506352","");



DROP TABLE IF EXISTS tbl_item_units;

CREATE TABLE `tbl_item_units` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NOT NULL,
  `users_id` int(11) NOT NULL,
  `deleted` int(11) DEFAULT '0',
  `defaults` int(11) NOT NULL DEFAULT '0',
  `removed_by` int(11) NOT NULL DEFAULT '0',
  `created_at` int(11) DEFAULT NULL,
  `changed_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

INSERT INTO tbl_item_units VALUES("1","Kg","25","0","0","0","1572495804",""),
("2","gr","25","1","0","25","1572495807",""),
("3","Unit","25","0","0","0","1572495812",""),
("4","Yes","25","1","0","25","1572503789",""),
("5","Of Course","25","1","0","25","1572503837","");



DROP TABLE IF EXISTS tbl_items;

CREATE TABLE `tbl_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(69) NOT NULL,
  `name` varchar(100) NOT NULL,
  `item_units_id` int(11) NOT NULL,
  `stocks_id` int(11) NOT NULL,
  `item_type` int(11) NOT NULL DEFAULT '0',
  `item_categories_id` int(11) NOT NULL,
  `minimum` varchar(120) NOT NULL,
  `opening_balance` double(15,2) NOT NULL,
  `description` text NOT NULL,
  `deleted` int(11) NOT NULL,
  `defaults` int(11) NOT NULL DEFAULT '0',
  `removed_by` int(11) NOT NULL DEFAULT '0',
  `created_at` int(11) DEFAULT NULL,
  `changed_at` int(11) DEFAULT NULL,
  `users_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

INSERT INTO tbl_items VALUES("1","2019-10-31","Cup","3","2","2","2","20","2000.00","We are going to describe everything for you.","0","0","0","2147483647","","25"),
("2","2019-10-31","Product Item","1","2","2","1","100","190.00","description","0","0","0","2147483647","","25");



DROP TABLE IF EXISTS tbl_login_details;

CREATE TABLE `tbl_login_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `users_id` int(11) NOT NULL,
  `login_date` int(11) DEFAULT NULL,
  `last_seen_visit` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf16 COLLATE=utf16_persian_ci;

INSERT INTO tbl_login_details VALUES("1","25","1572502099","1572502099"),
("2","25","1572502208","1572502208"),
("3","25","1572502310","1572502310"),
("4","25","1572502590","1572502590"),
("5","25","1572503516","1572503516"),
("6","25","1572666700","1572666700"),
("7","25","1572755391","1572755391"),
("8","25","1572839734","1572839734"),
("9","25","1572929706","1572929706");



DROP TABLE IF EXISTS tbl_positions;

CREATE TABLE `tbl_positions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) COLLATE utf8_persian_ci NOT NULL,
  `deleted` int(11) NOT NULL,
  `removed_by` int(11) NOT NULL DEFAULT '0',
  `verified` int(11) NOT NULL DEFAULT '1',
  `verified_by` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  `description` text COLLATE utf8_persian_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  `changed_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;




DROP TABLE IF EXISTS tbl_production_details;

CREATE TABLE `tbl_production_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title_productions_id` int(11) NOT NULL,
  `items_id` int(11) NOT NULL,
  `items_unit_id` int(11) NOT NULL,
  `amount` decimal(10,0) NOT NULL,
  `stocks_id` int(11) DEFAULT NULL,
  `description` text NOT NULL,
  `users_id` int(11) NOT NULL,
  `deleted` int(11) NOT NULL,
  `removed_by` int(11) NOT NULL DEFAULT '0',
  `created_at` int(11) DEFAULT NULL,
  `changed_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




DROP TABLE IF EXISTS tbl_production_title;

CREATE TABLE `tbl_production_title` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(20) NOT NULL,
  `items_id` int(11) NOT NULL,
  `stocks_id` int(11) NOT NULL,
  `items_unit_id` int(11) NOT NULL,
  `pure_amount` double(25,2) NOT NULL,
  `impure_amount` double(25,2) NOT NULL,
  `production_line` varchar(40) NOT NULL,
  `users_id` int(11) NOT NULL,
  `deleted` int(11) NOT NULL,
  `removed_by` int(11) NOT NULL DEFAULT '0',
  `created_at` int(11) DEFAULT NULL,
  `changed_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




DROP TABLE IF EXISTS tbl_safe_box;

CREATE TABLE `tbl_safe_box` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `date` varchar(20) NOT NULL,
  `currencies_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `owners_id` int(11) NOT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `verified` int(11) NOT NULL DEFAULT '1',
  `removed_by` int(11) NOT NULL DEFAULT '0',
  `created_at` int(11) DEFAULT NULL,
  `changed_at` int(11) DEFAULT NULL,
  `users_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




DROP TABLE IF EXISTS tbl_safe_box_statement;

CREATE TABLE `tbl_safe_box_statement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(20) NOT NULL,
  `safe_box_id` int(11) NOT NULL,
  `transaction_type` int(11) NOT NULL,
  `amount` double(10,2) NOT NULL,
  `description` text NOT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `verified` int(11) NOT NULL DEFAULT '1',
  `removed_by` int(11) NOT NULL DEFAULT '0',
  `created_at` int(11) DEFAULT NULL,
  `changed_at` int(11) DEFAULT NULL,
  `users_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




DROP TABLE IF EXISTS tbl_salvage_equipments;

CREATE TABLE `tbl_salvage_equipments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(50) NOT NULL,
  `items_id` int(11) NOT NULL,
  `stocks_id` int(11) DEFAULT NULL,
  `items_unit_id` int(11) NOT NULL,
  `amount` double(10,2) NOT NULL,
  `description` text NOT NULL,
  `users_id` int(11) NOT NULL,
  `deleted` int(11) NOT NULL,
  `removed_by` int(11) NOT NULL DEFAULT '0',
  `created_at` int(11) DEFAULT NULL,
  `changed_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




DROP TABLE IF EXISTS tbl_service_categories;

CREATE TABLE `tbl_service_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `users_id` int(11) NOT NULL,
  `deleted` smallint(6) DEFAULT NULL,
  `defaults` int(11) NOT NULL DEFAULT '0',
  `removed_by` int(11) NOT NULL DEFAULT '0',
  `created_at` int(11) DEFAULT NULL,
  `changed_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

INSERT INTO tbl_service_categories VALUES("1","Building","25","0","0","0","1572759092",""),
("2","plumbin","25","0","0","0","1572773903",""),
("3","plumbing - 02","25","0","0","0","1572781659","");



DROP TABLE IF EXISTS tbl_service_payment;

CREATE TABLE `tbl_service_payment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(40) NOT NULL,
  `service_provider_id` int(11) NOT NULL,
  `service_transactions_id` int(11) NOT NULL,
  `currencies_id` int(11) NOT NULL,
  `amount` double(20,2) NOT NULL,
  `rate` double(10,4) NOT NULL,
  `banks_id` int(11) NOT NULL,
  `factor_number` varchar(45) NOT NULL,
  `description` text NOT NULL,
  `payment_type` int(11) NOT NULL,
  `home_amount` double(25,2) NOT NULL,
  `users_id` int(11) NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  `changed_at` int(11) DEFAULT NULL,
  `deleted` int(11) NOT NULL,
  `removed_by` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

INSERT INTO tbl_service_payment VALUES("1","2019-11-03","1","0","144","20000.00","1.0000","1","1","We are paid.","2","20000.00","25","1572760301","","0","0"),
("2","2019-11-03","2","1","144","190.00","1.0000","1","","we are going to do everything","1","190.00","25","1572775236","","0","0"),
("3","2019-11-03","2","2","144","120.00","1.0000","1","","We are going to do something for you.","1","120.00","25","1572776146","","0","0"),
("4","2019-11-03","1","3","144","120.00","1.0000","1","","We are going to speak In English my brother","1","120.00","25","1572777322","","0","0"),
("5","2019-11-03","1","4","144","120.00","1.0000","1","","This is another point which we are going to speak with you","1","120.00","25","1572777446","","0","0");



DROP TABLE IF EXISTS tbl_service_provider;

CREATE TABLE `tbl_service_provider` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `service_provider_type_id` int(11) NOT NULL,
  `contact` varchar(45) NOT NULL,
  `opening_balance` double NOT NULL,
  `currencies_id` int(11) NOT NULL,
  `rate` double NOT NULL,
  `address` text NOT NULL,
  `transaction_type` int(11) NOT NULL DEFAULT '0',
  `home_amount` double(25,2) NOT NULL,
  `users_id` int(11) NOT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `defaults` int(11) NOT NULL DEFAULT '0',
  `removed_by` int(11) NOT NULL DEFAULT '0',
  `created_at` int(11) DEFAULT NULL,
  `changed_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

INSERT INTO tbl_service_provider VALUES("1","2019-11-03","Ghoor Band","1","0700435527","2000","144","1","Herat - 64 metra","2","2000.00","25","0","0","0","1572759241",""),
("2","2019-11-03","company","2","0700435527","2000","144","1","We are going to describe something for everyone.","1","2000.00","25","0","0","0","1572775091","");



DROP TABLE IF EXISTS tbl_service_provider_statement;

CREATE TABLE `tbl_service_provider_statement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(20) NOT NULL,
  `place` varchar(100) NOT NULL,
  `reference` varchar(100) NOT NULL,
  `transaction_type` int(11) NOT NULL,
  `amount` double NOT NULL,
  `service_provider_id` int(11) NOT NULL,
  `currencies_id` int(11) NOT NULL,
  `rate` double NOT NULL,
  `home_amount` double NOT NULL,
  `description` text NOT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `created_at` int(11) DEFAULT NULL,
  `changed_at` int(11) DEFAULT NULL,
  `users_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

INSERT INTO tbl_service_provider_statement VALUES("1","2019-11-03","Opening Balance of Service Provider","1","2","2000","1","144","1","2000","Herat - 64 metra","0","1572759241","","25"),
("2","2019-11-03","Services Provider Payment","1","1","20000","1","144","1","20000","We are paid.","0","1572760301","","25"),
("3","2019-11-03","Opening Balance of Service Provider","2","2","2000","2","144","1","2000","We are going to describe something for everyone.","0","1572775091","","25"),
("4","2019-11-03","Total Service Amount","1","1","200","2","144","1","200","we are going to do everything","0","1572775236","","25"),
("5","2019-11-03","Service Payment","1","2","190","2","144","1","190","we are going to do everything","0","1572775236","","25"),
("6","2019-11-03","Total Service Amount","2","1","200","2","144","1","200","We are going to do something for you.","0","1572776146","","25"),
("7","2019-11-03","Service Payment","2","2","120","2","144","1","120","We are going to do something for you.","0","1572776146","","25"),
("8","2019-11-03","Total Service Amount","3","1","2000","1","144","1","2000","We are going to speak In English my brother","0","1572777322","","25"),
("9","2019-11-03","Service Payment","3","2","120","1","144","1","120","We are going to speak In English my brother","0","1572777322","","25"),
("10","2019-11-03","Total Service Amount","4","1","200","1","144","1","200","This is another point which we are going to speak with you","0","1572777446","","25"),
("11","2019-11-03","Service Payment","4","2","120","1","144","1","120","This is another point which we are going to speak with you","0","1572777446","","25");



DROP TABLE IF EXISTS tbl_service_transaction;

CREATE TABLE `tbl_service_transaction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(40) NOT NULL,
  `service_provider_id` int(11) NOT NULL,
  `banks_id` int(11) NOT NULL,
  `currencies_id` int(11) NOT NULL,
  `rate` double NOT NULL,
  `amount` decimal(20,0) NOT NULL,
  `payment_amount` double(25,2) NOT NULL,
  `description` text NOT NULL,
  `employee_id` int(11) NOT NULL,
  `home_amount` double NOT NULL,
  `check_cash` varchar(50) NOT NULL,
  `users_id` int(11) NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  `changed_at` int(11) DEFAULT NULL,
  `deleted` int(11) NOT NULL,
  `removed_by` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

INSERT INTO tbl_service_transaction VALUES("1","2019-11-03","2","1","144","1","200","190.00","we are going to do everything","0","200","","25","1572775236","","0","0"),
("2","2019-11-03","2","1","144","1","200","120.00","We are going to do something for you.","0","200","","25","1572776146","","0","0"),
("3","2019-11-03","1","1","144","1","2000","120.00","We are going to speak In English my brother","0","2000","","25","1572777322","","0","0"),
("4","2019-11-03","1","1","144","1","200","120.00","This is another point which we are going to speak with you","0","200","","25","1572777446","","0","0");



DROP TABLE IF EXISTS tbl_staff;

CREATE TABLE `tbl_staff` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `family` varchar(100) NOT NULL,
  `contact` varchar(45) NOT NULL,
  `ssn` varchar(30) NOT NULL,
  `job_type` varchar(45) NOT NULL,
  `opening_balance` double NOT NULL,
  `unit` int(11) NOT NULL,
  `rate` double NOT NULL,
  `home_amount` double NOT NULL,
  `address` text NOT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `removed_by` int(11) NOT NULL DEFAULT '0',
  `verified` int(11) NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  `changed_at` int(11) DEFAULT NULL,
  `users_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




DROP TABLE IF EXISTS tbl_stock_balance;

CREATE TABLE `tbl_stock_balance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `items_id` int(11) NOT NULL,
  `stocks_id` int(11) NOT NULL,
  `amount` double(15,2) NOT NULL,
  `users_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

INSERT INTO tbl_stock_balance VALUES("1","1","2","1900.00","25"),
("2","2","2","90.00","25"),
("3","1","1","400.00","25");



DROP TABLE IF EXISTS tbl_stock_statement;

CREATE TABLE `tbl_stock_statement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(20) NOT NULL,
  `place` varchar(100) NOT NULL,
  `reference` varchar(100) NOT NULL,
  `transaction_type` int(11) NOT NULL,
  `amount` double(34,2) NOT NULL,
  `stocks_id` int(11) NOT NULL,
  `items_id` int(11) NOT NULL DEFAULT '0',
  `description` text NOT NULL,
  `categories_id` int(11) DEFAULT NULL,
  `sub_categories_id` int(11) DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `removed_by` int(11) NOT NULL DEFAULT '0',
  `created_at` int(11) DEFAULT NULL,
  `changed_at` int(11) DEFAULT NULL,
  `users_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

INSERT INTO tbl_stock_statement VALUES("1","2019-10-31","Opening Balance Item","1","1","2000.00","2","1","We are going to describe everything for you.","","","0","0","1572516725","","25"),
("2","2019-10-31","Expense Equipments","1","2","100.00","2","1","","","","0","0","1572517190","","25"),
("3","2019-10-31","Opening Balance Item","2","1","190.00","2","2","description","","","0","0","1572517253","","25"),
("4","2019-11-04","Sell Customer Items","1","2","300.00","2","2","this is a test for everyone.","","","0","0","1572849131","","25"),
("5","2019-11-04","Buy Vendors Items","1","1","200.00","2","2","description is neccessary","","","0","0","1572853100","","25"),
("6","2019-11-04","Buy Vendors Items","2","1","400.00","1","1","Clinic is here, we are not more emotional.","","","0","0","1572853100","","25");



DROP TABLE IF EXISTS tbl_stock_transaction;

CREATE TABLE `tbl_stock_transaction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(40) NOT NULL,
  `source_stocks_id` int(11) NOT NULL,
  `items_id` int(11) NOT NULL,
  `transfer_amount` double(11,2) NOT NULL,
  `destination_stocks_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `deleted` int(11) NOT NULL,
  `removed_by` int(11) NOT NULL DEFAULT '0',
  `created_at` int(11) DEFAULT NULL,
  `changed_at` int(11) DEFAULT NULL,
  `users_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




DROP TABLE IF EXISTS tbl_stocks;

CREATE TABLE `tbl_stocks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `removed_by` int(11) NOT NULL DEFAULT '0',
  `created_at` int(11) DEFAULT NULL,
  `changed_at` int(11) DEFAULT NULL,
  `users_id` int(11) NOT NULL,
  `defaults` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

INSERT INTO tbl_stocks VALUES("1","Zone - 02","We are going to speak English","0","0","1572509383","","25","0"),
("2","Zone -03","We are going to home Inshallah","0","0","1572509670","","25","0"),
("3","sdfsd","sdfs","1","25","1572509853","","25","0"),
("4","sdfsd","sdfsd","1","25","1572509943","","25","0"),
("5","sdf","sdfd","1","25","1572510017","","25","0");



DROP TABLE IF EXISTS tbl_users;

CREATE TABLE `tbl_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `family` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(70) NOT NULL,
  `password` varchar(250) NOT NULL,
  `photo` varchar(388) NOT NULL,
  `user_type` int(11) NOT NULL,
  `position_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `finance` int(11) NOT NULL DEFAULT '0',
  `finance_manager` int(11) NOT NULL,
  `remove` int(11) NOT NULL DEFAULT '0',
  `approve` int(11) DEFAULT '0',
  `addForm` int(11) NOT NULL DEFAULT '0',
  `subcontractors_approve` int(11) NOT NULL,
  `super_approve` int(11) DEFAULT '0',
  `subcontractors_id` int(11) NOT NULL,
  `edit` int(11) NOT NULL DEFAULT '0',
  `remove_report` int(11) NOT NULL DEFAULT '0',
  `edit_report` int(11) NOT NULL DEFAULT '0',
  `deleted` smallint(6) NOT NULL,
  `removed_by` int(11) NOT NULL DEFAULT '0',
  `verified` int(11) NOT NULL DEFAULT '1',
  `created_at` int(11) DEFAULT NULL,
  `changed_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;

INSERT INTO tbl_users VALUES("11","Sohaib","Raoufy","Sohaib","-----------.786@gmail.com","Mzk1MDRhMTlmMzk4MGUzODM4MWUxYTA2Zjg2ZmQxZjdiMjJmZDZlYWZiODVjNTE0YTI5OTJlOTJmZGRjOGY5MA==","../uploads/6aa4632f-814a-4c0d-85bf-0124b20871fe470.JPG","1002","0","0","1","1","1","0","1","0","0","0","0","1","1","0","0","1","1551906634","1556696158"),
("12","Engineer Faisal","Raufi","Ahmad Faisal","a.sami.sadiqi2017@gmail.com","NTk5NDQ3MWFiYjAxMTEyYWZjYzE4MTU5ZjZjYzc0YjRmNTExYjk5ODA2ZGE1OWIzY2FmNWE5YzE3M2NhY2ZjNQ==","../uploads/67d5fbe2-1ae0-4034-88a6-f3f2064d6815254.JPG","1002","3","0","0","0","1","1","1","0","0","0","1","0","0","0","0","1","1551906634","1556425966"),
("14","Mohammad Ismail","Noorkhail","Noorkhail","a.sami.sadiqi2017@gmail.com","Yzg0Y2MxNDYzYjI2NTBhOTQ3NzY0NmVhY2FhMWI5NTU0MDNiNmJkNDVmYWZiMTg4ZThiNzI3MGU4M2ViNzYxYQ==","../uploads/noorkhil144.PNG","1002","4","0","0","0","0","1","1","0","0","0","0","0","0","0","0","1","1551935925","1551935925"),
("15","Azizullah","jan","azizullah","-----------.786@gmail.com","NWVmNjIwMmMzMTE5NTRhMjY2MDE0Yjk1NmFlZjUxMGViNjFhODkyYTkxMmU3ZDE2NGZmNTVjYTQwYTExZGJiOA==","../uploads/Tulips286.jpg","1002","6","0","1","1","1","0","1","0","0","0","1","0","0","0","0","1","1551939099","2147483647"),
("16","Saed Ismail","Amiri","amiri","-----------.786@gmail.com","YWE5NDVlNmU3ZTdjNGRhYTU0NDhlN2I0OWI0YzBiMzQzNDhiMzJkZjQ5NGJhMWMxNTk1Nzg4ODEzY2Q4OTE4NQ==","../uploads/pp253.jpg","1001","2","0","0","0","1","0","1","0","1","0","1","0","0","0","0","1","1551946134","1551946134"),
("21","Eng Bahman","Sarwary","sarwary","a.sami.sadiqi2017@gmail.com","OWFlYTVjNjM0ZjcxMGYyY2E3MzIxMmFhMzFhOTNmZjVjOWEyNzYyNWQ0YzI1Nzc4MTY3ZGY2N2Q5YTFjNjg3Yw==","../uploads/Hydrangeas397.jpg","1002","5","0","0","0","1","1","1","0","0","0","1","0","0","0","0","1","1551906634","1556080308"),
("22","Abdul Sami","Sadiqi","sadiqi","sadiqi@yahoo.com","YmMwNmVlZTQ5NDUxYjQxZGRjNzk4ZDM3MjkwNDFmMTYzYjYyYjJkZmViMGY1NGU3NjBhZjZkNmEwM2EyODFmNQ==","../uploads/Capture452.PNG","1001","0","0","0","0","1","0","1","0","1","0","1","1","1","0","0","1","1551906634","1556189121"),
("23","Eng Mohammad Maruf","Sharifzada","Sharifzada","Maruf.Sharifzada@assistconsultans.com","OWJhYTRkOTkxNGI0N2FmZGI3Y2NhNjA4ODI4ZDgwYTEyNmQ2NGMyNWI2NWVkOTRmNTBjMjRjN2UyZjZhYmM5YQ==","../uploads/Seminar Banner292.jpg","1002","1","0","0","0","0","1","1","0","0","0","0","0","0","0","0","1","1551936321","1551939099"),
("24","Mansoor","Afzali","Mansoor","mansoorafzali009@gmail.com","YWZlM2U3ODg0MjlmN2ZjYTRkNWM5OTQ2NTkxNDI1ZDRjZWZkNzc1Y2Y3Y2FlNGQ4ZDU4MzBmYmQxZDAwNTU1Nw==","../uploads/IMG_0372487.JPG","1002","7","1","0","0","1","0","1","0","0","0","1","0","0","0","0","1","1551948963","1556080436"),
("25","Abdul Sami2","","sadiqi2","azizi@gmail.com","NDkwMzkwYTVkZmIwMWNmNWIxN2VjNjVhNmYwNjZjMzg3ODQyOGRjMGRiZTMwMzExMzFlMGJhOWQ2ODM1ZGIwYg==","../uploads/69740775_2341712862545045_8440527832416780288_n361.jpg","1002","6","0","1","1","1","0","1","0","0","0","1","1","1","0","0","1","1555232502","1568521722"),
("26","Jahanzeb","Nangyal","Jahanzeb@nangyal","jahanzaib.jaji@gmail.com","NDk5ZTRkOGYwZWU3MWJjZGU4NzljN2E3YWY0NDZlNGNmYTYxNTZjOGI0ZjRjYjc2NWUxZTM0YTI4NDcwYjQyMg==","../uploads/57703290_2425773260800848_4475623670693232640_n404.jpg","1002","7","1","0","0","1","0","1","0","0","0","1","0","0","0","0","1","1556080863","1556081124"),
("27","Ahmad Farzad","Amiri","FarzadAmiri","aftab.soft.ltd@gmail.com","ZjlhMmQ0MTdhY2IwMzcyODc3ODY3OGU1MTRlZWU0MmEzYjBiMWZlYmUwYjliZTM1NWU3MDBlNTY4NmIxNTlhZg==","../uploads/IMG_5262431.JPG","1003","3","0","0","0","0","0","1","0","0","0","1","1","1","0","0","1","1556471295","1556477297"),
("28","Allahdad","Kakar","akakar","","NzQxNDU2ZDIxN2Y5MjU4ZDMxYTg3ZDhjNGNlN2NjOTBjNjBmZGMyZTQyYjgzYzY2OTk3MWQ0ZWU4OTU3MDBmOQ==","../uploads/Lighthouse377.jpg","1002","0","0","0","0","0","0","1","0","0","0","1","0","1","0","0","1","1556777257","0"),
("29","Safiullah","karimi","karimi","","ZjI5YjVjZDEyMmYwY2ViOTc0NzNkNjI5NGVkMTJmMjFlYTE0ZDE1ZWIyZGMwYmYwMzAxNDE2NDg0ZmQ5ZjFhMw==","../uploads/upload176.","1002","0","0","0","0","0","0","1","0","0","0","0","0","1","0","0","1","1556778232","1560595213"),
("30","Mojeeb","Noori","mojeeb","mojeeb.noori0@gmial.com","MzUxNWFmODA5MzkzYTg5NGYxOGI2YjAxYWM2M2E1ZTg1ZmEzYjFkM2U4ZTMzYmI3Njk1Yzk0NmY2YTA2MGY4Mg==","../uploads/Penguins157.jpg","1002","0","1","0","0","0","0","1","0","0","0","1","0","0","0","0","1","1556947279","0"),
("31","Tamim","Alawi","tamim","tamim.alawi@assistconsultants.com","ZTgxY2RjNTVjOTRmMGFiMDZmNTYzYTBkNjQ5NDZmZjJlNzNkM2ZjZmNlNmNkNzc5ZTZhYjRlODBkNzJiYzc2Mg==","../uploads/Lighthouse375.jpg","1003","0","0","0","0","0","0","1","0","0","0","0","0","1","0","0","1","1556950179","0"),
("32","Abdul Rauf","Haidary","haidary","internal.audit@assistconsultants.com","M2IwNWU2MmUzYTg3NmU0NWI2NzY1ZTExOTU0MTk4Y2Q0OTUyZDQ2NWMwNjI0YmIxNGVhZTFkYzNmZGVjNDgzOQ==","../uploads/32f5017b-8868-444a-a5a5-2c81354e2e5c206.jpg","1002","8","0","0","0","1","1","1","0","0","0","1","0","0","0","0","1","1560408878","1560592679"),
("33","Raamin","Sadaat","ramin","ramin.sadat2000@gmail.com","MTJhNTk2MjMyY2ZmNjBkYzdiYmEyNzRhY2E5NzZlNDFmMmJkMmZmN2IxOWJmMjFlYWNjYzIzNWFlM2RjNzUxNg==","../uploads/B612_20181008_152717_968[1]25.jpg","1003","9","0","0","1","0","0","1","0","0","0","1","1","1","0","0","1","1561186240","1561203151");



DROP TABLE IF EXISTS tbl_vendor_bill_details;

CREATE TABLE `tbl_vendor_bill_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title_bills_id` int(11) NOT NULL,
  `items_id` int(11) NOT NULL,
  `stocks_id` int(11) DEFAULT NULL,
  `items_unit_id` int(11) NOT NULL,
  `amount` double(10,2) NOT NULL,
  `fee` double(10,2) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `description` text NOT NULL,
  `users_id` int(11) NOT NULL,
  `deleted` int(11) NOT NULL,
  `removed_by` int(11) NOT NULL DEFAULT '0',
  `created_at` int(11) DEFAULT NULL,
  `changed_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

INSERT INTO tbl_vendor_bill_details VALUES("1","1","2","2","1","200.00","90.00","18000.00","description is neccessary","25","0","0","1572853100",""),
("2","1","1","1","3","400.00","80.00","32000.00","Clinic is here, we are not more emotional.","25","0","0","1572853100","");



DROP TABLE IF EXISTS tbl_vendor_bill_title;

CREATE TABLE `tbl_vendor_bill_title` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(20) NOT NULL,
  `vendors_id` int(11) NOT NULL,
  `currencies_id` int(11) NOT NULL,
  `rate` double NOT NULL,
  `factor_number` varchar(50) NOT NULL,
  `banks_id` int(11) NOT NULL,
  `factor_price` double(20,2) NOT NULL,
  `factor_payment` double(20,2) NOT NULL,
  `description` text NOT NULL,
  `home_amount` double(16,2) NOT NULL,
  `home_amount_factor_price` double(16,2) NOT NULL,
  `users_id` int(11) NOT NULL,
  `deleted` int(11) NOT NULL,
  `removed_by` int(11) NOT NULL DEFAULT '0',
  `created_at` int(11) DEFAULT NULL,
  `changed_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

INSERT INTO tbl_vendor_bill_title VALUES("1","2019-11-04","1","144","1","9879","1","50000.00","40000.00","","40000.00","50000.00","25","0","0","1572853100","");



DROP TABLE IF EXISTS tbl_vendor_categories;

CREATE TABLE `tbl_vendor_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `users_id` int(11) NOT NULL,
  `deleted` smallint(6) DEFAULT NULL,
  `removed_by` int(11) NOT NULL DEFAULT '0',
  `created_at` int(11) DEFAULT NULL,
  `changed_at` int(11) DEFAULT NULL,
  `defaults` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

INSERT INTO tbl_vendor_categories VALUES("1","Chines","25","1","25","1572778286","","0"),
("2","Chines","25","0","0","1572779291","","0"),
("3","Chines","25","0","0","1572780389","","0"),
("4","دصث","25","0","0","1572781019","","0");



DROP TABLE IF EXISTS tbl_vendor_payment;

CREATE TABLE `tbl_vendor_payment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(40) NOT NULL,
  `vendors_id` int(11) NOT NULL,
  `reference_id` int(11) DEFAULT '0' COMMENT 'factor title id ',
  `currencies_id` int(11) NOT NULL,
  `amount` double(20,2) NOT NULL,
  `rate` double NOT NULL,
  `banks_id` int(11) NOT NULL,
  `factor_number` varchar(45) NOT NULL,
  `description` text NOT NULL,
  `payment_type` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `home_amount` double NOT NULL,
  `users_id` int(11) NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  `changed_at` int(11) DEFAULT NULL,
  `deleted` int(11) NOT NULL,
  `removed_by` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

INSERT INTO tbl_vendor_payment VALUES("1","2019-11-04","1","1","144","40000.00","1","1","9879","","1","0","40000","25","1572853100","","0","0");



DROP TABLE IF EXISTS tbl_vendor_statement;

CREATE TABLE `tbl_vendor_statement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(40) NOT NULL,
  `place` varchar(100) NOT NULL,
  `reference` varchar(100) NOT NULL,
  `transaction_type` int(11) NOT NULL,
  `amount` double(25,2) NOT NULL,
  `vendors_id` int(11) NOT NULL,
  `currencies_id` int(11) NOT NULL,
  `rate` double(10,3) NOT NULL,
  `home_amount` double(25,2) NOT NULL,
  `description` text NOT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `removed_by` int(11) NOT NULL DEFAULT '0',
  `created_at` int(11) DEFAULT NULL,
  `changed_at` int(11) DEFAULT NULL,
  `users_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

INSERT INTO tbl_vendor_statement VALUES("1","2019-11-04","Opening Balance of Vendor","1","1","2000.00","1","144","1.000","2000.00","This is a test for everyone which we are going to do lots of work for u.","0","0","1572852914","","25"),
("2","2019-11-04","Total Vendor Factor Price","1","1","50000.00","1","144","1.000","50000.00","","0","0","1572853100","","25"),
("3","2019-11-04","Vendor Payment","1","2","40000.00","1","144","1.000","40000.00","","0","0","1572853100","","25");



DROP TABLE IF EXISTS tbl_vendors;

CREATE TABLE `tbl_vendors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `vendor_type` int(11) NOT NULL,
  `contact` varchar(150) NOT NULL,
  `currencies_id` int(11) NOT NULL,
  `opening_balance` double(25,2) NOT NULL,
  `rate` double(10,3) NOT NULL,
  `address` text NOT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `defaults` int(11) DEFAULT '0',
  `removed_by` int(11) NOT NULL DEFAULT '0',
  `home_amount` double(25,2) NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  `changed_at` int(11) DEFAULT NULL,
  `users_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

INSERT INTO tbl_vendors VALUES("1","2019-11-04","Salmaiyar","3","0700435527","144","2000.00","1.000","This is a test for everyone which we are going to do lots of work for u.","0","0","0","2000.00","1572852914","","25");



