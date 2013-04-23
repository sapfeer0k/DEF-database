<?php

/***************************************************************************
*                                                                          *
*   (c) 2012 Sergei Lomakov sergei@lomakov.net                             *
*                                                                          *
* This  is  commercial  software,  only  users  who have purchased a valid *
* license  and  accept  to the terms of the  License Agreement can install *
* and use this program.                                                    *
*                                                                          *
****************************************************************************
* PLEASE READ THE FULL TEXT  OF THE SOFTWARE  LICENSE   AGREEMENT  IN  THE *
* "copyright.txt" FILE PROVIDED WITH THIS DISTRIBUTION PACKAGE.            *
****************************************************************************/

# Source:
$URL = 'http://rossvyaz.ru/docs/articles/DEF-9x.html';
$DB = 'database.sql';

echo "Starting...\n";
$html = file_get_contents($URL);
$defTable = iconv('cp1251', 'utf-8', $html);
$regex = '';
for($i=0; $i<6; $i++) {
    $regex .= '<td>(.*?)</td>\s+';
}
$row = array();
preg_match_all("%{$regex}%si", $defTable, $results, PREG_SET_ORDER);
$hFile = fopen($DB, 'w');
if (count($results)) {
    foreach($results as $row) {
        unset($row[0]);
        array_walk($row, function(&$e) {
            $e = trim($e);
        });
        fputcsv($hFile, $row);
    }
}
fclose($hFile);
echo "Done\n";
