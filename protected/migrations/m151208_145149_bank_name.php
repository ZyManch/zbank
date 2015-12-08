<?php

class m151208_145149_bank_name extends EDbMigration {
    public function up() {
        $this->execute('ALTER TABLE  `bank` ADD  `name` VARCHAR( 128 ) NULL DEFAULT NULL AFTER  `id` ');
        $this->execute('ALTER TABLE  `bank` ADD  `url` VARCHAR( 128 ) NULL DEFAULT NULL AFTER  `title` ');
        $this->execute('ALTER TABLE  `bank_branch` ADD  `working_hours` TEXT NULL DEFAULT NULL AFTER  `longitude`');
    }

    public function down() {
        $this->dropColumn('bank', 'name');
        $this->dropColumn('bank', 'url');
        $this->dropColumn('bank_branch', 'working_hours');
    }
}