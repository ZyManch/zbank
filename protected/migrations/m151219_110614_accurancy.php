<?php

class m151219_110614_accurancy extends EDbMigration
{
	public function up() {
        $this->execute(
            'ALTER TABLE  `bank_currency`
            CHANGE  `sale_price`  `sale_price` DECIMAL( 8, 5 ) UNSIGNED NOT NULL ,
            CHANGE  `buy_price`  `buy_price` DECIMAL( 8, 5 ) UNSIGNED NOT NULL');
	}

	public function down() {
        $this->execute(
            'ALTER TABLE  `bank_currency`
            CHANGE  `sale_price`  `sale_price` DECIMAL( 8, 2 ) UNSIGNED NOT NULL ,
            CHANGE  `buy_price`  `buy_price` DECIMAL( 8, 2 ) UNSIGNED NOT NULL');
	}

}