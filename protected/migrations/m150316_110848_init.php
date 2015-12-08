<?php

class m150316_110848_init extends EDbMigration
{
    protected $_alreadyDropped = array();

	public function up() {

        $this->createTable('bank', array(
            'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
			'title' => 'varchar(256) NOT NULL',
			'license' => 'int(11) DEFAULT NULL',
			'position' => 'int(10) unsigned NOT NULL',
			'status' => 'enum("Active","Deleted") NOT NULL DEFAULT "Active"',
            'PRIMARY KEY (`id`)'
        ), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=742');

        $this->createTable('bank_branch', array(
      		'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
			'bank_id' => 'int(10) unsigned NOT NULL',
			'city_id' => 'int(10) unsigned NOT NULL',
			'address' => 'text NOT NULL',
			'latitude' => 'decimal(10,6) NOT NULL',
			'longitude' => 'decimal(10,6) NOT NULL',
			'status' => 'enum("Active","Deleted") NOT NULL DEFAULT "Active"',
            'PRIMARY KEY (`id`)',
            'KEY `bank_id` (`bank_id`)',
            'KEY `city_id` (`city_id`)'
        ), 'ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1');


        $this->createTable('bank_currency', array(
      		'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
			'bank_id' => 'int(10) unsigned NOT NULL',
			'currency_id' => 'int(10) unsigned NOT NULL',
			'sale_price' => 'decimal(8,2) unsigned NOT NULL',
			'buy_price' => 'decimal(8,2) unsigned NOT NULL',
            'PRIMARY KEY (`id`)',
            'KEY `bank_id` (`bank_id`)',
            'KEY `currency_id` (`currency_id`)'
        ), 'ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1') ;


        $this->createTable('city', array(
      		'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
			'title' => 'varchar(128) NOT NULL',
			'latitude' => 'decimal(10,6) NOT NULL',
			'longitude' => 'decimal(10,6) NOT NULL',
            'PRIMARY KEY (`id`)'
        ), 'ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1') ;

        $this->createTable('currency', array(
      		'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
			'title' => 'varchar(128) NOT NULL',
			'sign' => 'varchar(5) DEFAULT NULL',
			'status' => 'enum("Active","Deleted") NOT NULL DEFAULT "Active"',
            'PRIMARY KEY (`id`)'
        ), 'ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1') ;

        $this->addForeignKey('bank_branch_ibfk_1','bank_branch','bank_id','bank','id','CASCADE','CASCADE');
        $this->addForeignKey('bank_branch_ibfk_2','bank_branch','city_id','city','id','CASCADE','CASCADE');
        $this->addForeignKey('bank_currency_ibfk_1','bank_currency','bank_id','bank','id','CASCADE','CASCADE');
        $this->addForeignKey('bank_currency_ibfk_2','bank_currency','currency_id','currency','id','CASCADE','CASCADE');

	}

	public function down() {
        $step = 0;
        while ($this->_dropTables() && $step < 20) {
            $step++;
        }
	}

    protected function _dropTables() {
        $tables = array(
            'bank',
            'bank_branch',
            'bank_currency',
            'city',
            'currency'
        );
        $deleted = 0;
        foreach ($tables as $table) {
            if ($this->dropTable($table)) {
                $deleted++;
            }
        }
        return $deleted;
    }

    public function dropTable($table) {
        if (in_array($table,$this->_alreadyDropped)) {
            return false;
        }
        try {
            parent::dropTable($table);
            $this->_alreadyDropped[] = $table;
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}