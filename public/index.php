<?php
/**
 * Created by PhpStorm.
 * User: vanditha
 * Date: 10/2/18
 * Time: 6:41 PM
 */

main::initiate('members.csv');

class main {

    private $view;

    static public function initiate($members){

        $listFile = readFile::getMembersList($members);
        $table = tableView::generateTable($listFile);
        $page = new bootstrapPage($table);
    }

}

class readFile {

    public static function getMembersList($members){

        $memberslistFile = fopen($members,"r");

        $listHeader = array();

        $count = 0;

        while(! feof($memberslistFile))
        {
            $list = fgetcsv($memberslistFile);
            if($count == 0) {
                $listHeader = $list;
            } else {
                $listFile[] = new listing($listHeader, $list);
            }
            $count++;
        }

        fclose($memberslistFile);
        return $listFile;

    }

}

class listing {

    public function __construct(Array $listHeader = null, $value = null )
    {
        $list = array_combine($listHeader, $value);

        foreach ($list as $property => $value) {
            $this->{$property} = $value;
        }
    }

}

class tableView {

    public static function generateTable($listFile) {

        $count = 0;
        $view = '<table class="table table-striped">';
        foreach ($listFile as $data) {

            if($count == 0) {
                $view .= '<tr>';
                $array = (array) $data;
                $fields = array_keys($array);
                foreach($fields as $key=>$value){
                    $view .= '<th>' .htmlspecialchars($value) . '</th>';
                }
                $view .= '</tr>';
            }
            $view .= '<tr>';
            $array = (array) $data;
            $values = array_values($array);
            foreach($values as $key=>$value){
                $view .= '<td>' .htmlspecialchars($value) . '</td>';
            }
            $view .= '</tr>';
            $count++;
        }
        $view .= '</table>';
        return $view;
    }

}

class bootstrapPage{

    public function __construct($table) {
        $view = '';
        $view = '<!DOCTYPE html><html><head>
          <meta name="viewport" content="width=device-width, initial-scale=1">
          <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
          <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
          <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        </head><body><div class="container">';
        $view .= $table;
        $view .= '</div></body></html>';
        echo $view;
    }

}