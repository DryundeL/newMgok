<?php namespace Lazurmedia\Mgok\Classes;

require './plugins/lazurmedia/mgok/libraries/PhpSpreadsheet/vendor/autoload.php';

use Db;
use Redirect;
use Response;
use Lazurmedia\Mgok\Models\Users;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class Export
{
  public static function export($table)
  {
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $users = Users::all();

    $writer = new Xlsx($spreadsheet);
    $fileName = $writer->save('users.xlsx');
    return Response::download($csvPath, $fileName)->deleteFileAfterSend(true);
  }
}