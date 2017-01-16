<?php


$tables = array(
    'follows' => array(
                'id' => 'INT NOT NULL AUTO_INCREMENT PRIMARY KEY' ,
                'user_to' => 'INT NOT NULL' ,
                'user_by' => 'INT NOT NULL' ,
                'date' => 'INT NOT NULL'
		),
    
            
    's3_temp_uploads' => array(
                'id' => 'INT NOT NULL AUTO_INCREMENT PRIMARY KEY' ,
                's3_key' => 'TEXT NOT NULL' ,
                'date' => 'INT NOT NULL',
                'user_id' => 'INT NOT NULL'
		),
            
            
    'favorites' => array(
                'id' => 'INT NOT NULL AUTO_INCREMENT PRIMARY KEY' ,
                'user_id' => 'INT NOT NULL' ,
                'item_id' => 'INT NOT NULL' ,
                'date' => 'INT NOT NULL'
		),
            
            
    'views' => array(
                'id' => 'INT NOT NULL AUTO_INCREMENT PRIMARY KEY' ,
                'post_id' => 'INT NOT NULL' ,
                'views' => 'INT NOT NULL DEFAULT 0',
                'hour' => 'INT NOT NULL'
		),
                    
    
    'notifications' => array(
                'id' => 'INT NOT NULL AUTO_INCREMENT PRIMARY KEY' ,
                'user_id' => 'INT NOT NULL' ,
                'key' => 'varchar(50) NOT NULL' ,
                'value' => 'VARCHAR(200) NOT NULL',
                'date' => 'INT NOT NULL',
                'read' => 'INT NOT NULL DEFAULT "0"'
		),
            
            
    'c_ratings' => array(
                'id' => 'INT NOT NULL AUTO_INCREMENT PRIMARY KEY' ,
                'active_id' => 'INT NOT NULL' ,
                'rate_by' => 'INT NOT NULL' ,
                'rate_to' => 'INT NOT NULL' ,
                'date' => 'datetime NOT NULL DEFAULT "0000-00-00 00:00:00"',
                'communication_rating' => 'INT NOT NULL' ,
                'artwork_rating' => 'INT NOT NULL'
		),
            
            
    'd_ratings' => array(
                'id' => 'INT NOT NULL AUTO_INCREMENT PRIMARY KEY' ,
                'rate_key' => 'VARCHAR(50) NOT NULL' ,
                'user_rate_key' => 'VARCHAR(50) NOT NULL' ,
                'download_id' => 'INT NOT NULL' ,
                'score_type' => 'VARCHAR(50) NOT NULL' ,
                'user_id' => 'INT NOT NULL' ,
                'user_role_id' => 'INT NOT NULL' ,
                'score' => 'FLOAT(3,2) NOT NULL'
		),
            
            
    'd_authors' => array(
                'id' => 'INT NOT NULL AUTO_INCREMENT PRIMARY KEY' ,
                'download_id' => 'INT NOT NULL' ,
                'user_id' => 'INT NOT NULL' ,
                'sales' => 'INT NOT NULL DEFAULT "0"',
                'revenue' => 'DECIMAL(20,2) NOT NULL DEFAULT "0"',
                'income' => 'DECIMAL(20,2) NOT NULL DEFAULT "0"',
                'dated_stats' => 'longtext NULL'
		),
            
            
    'post_reports' => array(
                'id' => 'INT NOT NULL AUTO_INCREMENT PRIMARY KEY' ,
                'post_id' => 'INT NOT NULL' ,
                'reported_by' => 'INT NOT NULL' ,
                'reasons' => 'varchar(200) NOT NULL',
                'time' => 'INT NOT NULL'
		),
    
    
    
    'confirm_keys' => array(
                'id' => 'INT NOT NULL AUTO_INCREMENT PRIMARY KEY' ,
                'user_id' => 'INT NOT NULL' ,
                'user_key' => 'varchar(200) NOT NULL',
                'valid_till' => 'INT NOT NULL' ,
                'type' => 'varchar(100) NOT NULL'
		),
    
    'payment_checks' => array(
                'id' => 'INT NOT NULL AUTO_INCREMENT PRIMARY KEY' ,
                'user_id' => 'INT NOT NULL' ,
                'year' => 'YEAR(4) NOT NULL',
                'month' => 'TINYINT(2) NOT NULL',
                'amount'  => 'DECIMAL(20,2) NOT NULL',
                'check_id' => 'VARCHAR(100) NOT NULL',
                'check_date' => 'date NULL',
                'add_date' => 'INT NOT NULL',
                'remaining' => 'DECIMAL(20,2) NOT NULL',
		),
    
    
    
    'dated_stats' => array(
                'id' => 'INT NOT NULL AUTO_INCREMENT PRIMARY KEY' ,
                'type' => 'VARCHAR(50) NOT NULL' ,
                'date' => 'VARCHAR(20) NOT NULL',
                'object' => 'VARCHAR(50) NOT NULL',
                'object_id'  => 'VARCHAR(50) NOT NULL',
                'stat_name' => 'VARCHAR(50) NOT NULL',
                'stat_value'  => 'VARCHAR(250) NOT NULL'
		)
    
    
);