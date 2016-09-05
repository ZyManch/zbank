<?php
/**
 * Created by PhpStorm.
 * User: ZyManch
 * Date: 19.12.2015
 * Time: 15:10
 */
class BranchDetectorXls extends BranchDetectorAbstract {

    /** @var PHPExcel_Worksheet  */
    protected $_sheet;

    protected $_uniqueFieldName = 'name';

    /** @var Bank  */
    protected $_bank;

    protected $_startFromRow = 0;


    public function __construct(Bank $bank, $url) {
        $this->_bank = $bank;
        $tmpFile = Yii::app()->cache->cachePath.$bank->name.'.xls';
        if (!file_exists($tmpFile)) {
            file_put_contents($tmpFile, file_get_contents($url));
        }
        print 'd';
        $objPHPExcel = PHPExcel_IOFactory::load($tmpFile);
        $this->_sheet = $objPHPExcel->getActiveSheet();
    }

    protected function _getValue($name, $row) {
        return $this->_getCellValue($name, $row);
    }

    public function setUniqueFieldName($fieldName) {
        $this->_uniqueFieldName  = $fieldName;
        return $this;
    }

    public function setStartFrom($row) {
        $this->_startFromRow = $row;
        return $this;
    }


    public function run() {
        $row = $this->_startFromRow;
        print 'p';
        $branches = $this->_getBranches();
        print 'b';
        while ($name = $this->_getName($row)) {
            $phones = $this->_getPhones($row);
            $work = $this->_getWork($row);

            $city = $this->_getCity($row);
            $street = $this->_getStreet($row);
            $house = $this->_getHouse($row);
            $address = $this->_getAddress($row);
            if (!$address) {
                $address = trim($street.','.$house,', ');
            } else if (!$city) {
                $address = $this->_replaceText(
                    array(
                        ', ' => ',',
                        'поселок' => 'п.',
                        'пос.' => 'п.',
                        'дер.' => 'д.'
                    ),
                    trim(preg_replace('#([0-9]{6})#','',$address))
                );
                $parts = explode(',',$address);
                while (isset($parts[0]) && !in_array(mb_substr($parts[0],0,2),array('г.','п.','д.'))) {
                    array_shift($parts);
                }
                if (!$parts) {
                    if (!$this->_canSkipAddress($address)) {
                        print "\naddress?:".$address;
                    }
                    $row++;
                    continue;
                }
                $cityName = array_shift($parts);
                $city = City::getCityByName($cityName);
                $address = implode(',',$parts);
            }
            $values = array(
                'bank_id' => $this->_bank->id,
                'name' => $name,
                'city_id' => $city->id,
                'address' => trim($address,' ,'),
                'phones' => trim($phones),
                'working_hours' => $work
            );
            $uniqueValue = $values[$this->_uniqueFieldName];
            if (isset($branches[$uniqueValue])) {
                $branch = $branches[$uniqueValue];
                unset($branches[$uniqueValue]);
            } else {
                $branch = new BankBranch();
                $pos = Yii::app()->geocoder->addressToPos($city->title.','.$values['address']);
                if ($pos) {
                    $branch->longitude = $pos[0];
                    $branch->latitude = $pos[1];
                }
            }
            $branch->attributes = $values;
            $branch->save(false);
            $row++;
            print '+';
        }
        foreach ($branches as $branch) {
            $branch->delete();
            print '-';
        }
        return true;
    }

    protected function _replaceText($replaces, $text) {
        foreach ($replaces as $key => $value) {
            $text = implode($value, mb_split($key, $text));
        }
        return $text;
    }

    protected function _canSkipAddress($address) {
        $texts = array('автодорог','территория','промбаза');
        foreach ($texts as $text) {
            if (mb_stripos($address,$text)!==false) {
                return true;
            }
        }
        return false;
    }


    protected function _getCellValue($col, $row) {
        $value = $this->_sheet->getCellByColumnAndRow($col, $row)->getFormattedValue();
        return $value;
        //return trim(iconv('windows-1251','utf-8',$value));
    }

    /**
     * @return BankBranch[]
     */
    protected function _getBranches() {
        return BankBranch::model()->findAll(array(
            'params'    => array(':bank'=>$this->_bank->id),
            'condition' => 'bank_id=:bank',
            'index'     => $this->_uniqueFieldName
        ));
    }

}