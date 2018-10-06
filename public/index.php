<?php
/**
 * Created by PhpStorm.
 * User: vanditha
 * Date: 10/2/18
 * Time: 6:41 PM
 */

main::initiate('members.csv');

class main {

            static public function initiate($members){

            $listfile = readFile::getMembersList($members);

        }

}

class readFile {

    public static function getMembersList($members){

        $memberslistFile = fopen($members,"r");

        $listHeader = array();

        $count = 0;

        while(! feof($memberslistFile))
        {

            $lists = fgetcsv($memberslistFile);
            if($count == 0) {
                $listHeader = $lists;
                echo $listHeader[0];
            }
            $count++;

        }

        fclose($memberslistFile);
        return $lists;

    }

}





















