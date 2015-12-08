<?php
/**
 * Created by PhpStorm.
 * User: ZyManch
 * Date: 28.06.14
 * Time: 21:27
 */
class BankCommand extends CConsoleCommand {

    public $aliases = array(

    );

    public function run($args) {
        $oldBanks = $this->_getOldBanks();
        $newBanks = $this->_getNewBankData();
        if (sizeof($newBanks) < 500) {
            print 'Very low bank count:'.sizeof($newBanks);
            return;
        }
        foreach ($newBanks as $newBank) {
            $license = $newBank['license'];
            if (isset($oldBanks[$license])) {
                $this->_updateBank($oldBanks[$license],$newBank);
                unset($oldBanks[$license]);
            } else {
                $this->_createNewBank($newBank);
            }
        }
        foreach ($oldBanks as $oldBank) {
            $this->_deleteBank($oldBank);
        }
    }

    protected function _getNewBankData() {
        $fileName = 'http://www.banki.ru/banks/ratings/export.php';
        $csv = file($fileName);
        $rows = array_slice($csv, 4);
        $result = array();
        foreach ($rows as $row) {
            $row = explode(';',$row);
            if (sizeof($row) == 9) {
                $result[] = array(
                    'pos' => intval($row[0]),
                    'title' => iconv('CP1251','UTF-8',trim($row[2])),
                    'license' => intval($row[3]),
                    'money' => str_replace(array(' ',','),array('','.'),$row[5]),
                );
            }

        }
        return $result;
    }

    /**
     * @return Bank[]
     */
    protected function _getOldBanks() {
        return Bank::model()->findAll(array(
            'index' => 'license'
        ));
    }

    protected function _updateBank(Bank $bank, $newData) {
        $bank->title = $newData['title'];
        $bank->position = $newData['pos'];
        $bank->license = $newData['license'];
        $bank->save();
    }

    protected function _deleteBank(Bank $bank) {
        $bank->delete();
    }

    protected function _createNewBank($bank) {
        $model = new Bank();
        $model->title = $bank['title'];
        $model->position = $bank['pos'];
        $model->license = $bank['license'];
        $model->save();
    }


}