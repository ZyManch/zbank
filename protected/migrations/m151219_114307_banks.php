<?php

class m151219_114307_banks extends EDbMigration
{
	public function up()
	{
        $this->update('bank',array(
            'url'=>'http://www.vtb.ru'
        ),'title="ВТБ"');
        $this->update('bank',array(
            'url'=>'http://www.gazprombank.ru',
            'name' => 'gazprom'
        ),'title="Газпромбанк"');
        $this->update('bank',array(
            'url'=>'http://www.vtb24.ru',
            'name' => 'vtb24'
        ),'title="ВТБ 24"');
	}

}