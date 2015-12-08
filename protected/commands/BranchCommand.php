<?php
/**
 * Created by PhpStorm.
 * User: ZyManch
 * Date: 28.06.14
 * Time: 21:27
 */
class BranchCommand extends CConsoleCommand {


    public function run($args) {
        foreach ($this->_getBanks() as $bank) {
            $bank->updateBankInformation();
        }
    }

    /**
     * @return Bank[]
     */
    protected function _getBanks() {
        return Bank::model()->findAll(array(
            'condition' => 'name is not null'
        ));
    }



}