<?php

class m151219_092434_branch_name extends EDbMigration
{
	public function up(){
        $this->execute(
            'ALTER TABLE  `bank_branch` ADD  `name` VARCHAR( 150 ) NULL DEFAULT NULL AFTER  `id`'
        );
	}

	public function down()	{
		$this->dropColumn('bank_branch','name');
	}

}