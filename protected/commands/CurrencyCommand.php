<?php
/**
 * Created by PhpStorm.
 * User: ZyManch
 * Date: 28.06.14
 * Time: 21:27
 */
class CurrencyCommand extends CConsoleCommand {


    public function actionIndex($bank = null) {
        foreach ($this->_getBanks($bank) as $bank) {
            p('Process "'.$bank->name.'" bank:');
            $bank->updateBankCurrency();
            print "ok\n";
        }
    }

    /**
     * @return Bank[]
     */
    protected function _getBanks($bank) {
        return Bank::model()->findAll(array(
            'condition' => $bank ? 'name="'.$bank.'"' : 'name is not null'
        ));
    }



}