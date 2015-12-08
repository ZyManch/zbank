<?php

class m151208_144255_license extends EDbMigration
{
	public function up()
	{
        $this->createIndex('license','bank','license',true);
	}

	public function down()
	{
		$this->dropIndex('license','bank');
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}