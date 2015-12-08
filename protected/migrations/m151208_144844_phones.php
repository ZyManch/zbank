<?php

class m151208_144844_phones extends EDbMigration
{
	public function up()
	{
        $this->execute('ALTER TABLE  `bank_branch` ADD  `phones` TEXT NOT NULL AFTER  `address`');
	}

	public function down()
	{
		$this->dropColumn('bank_branch','phones');
	}

}