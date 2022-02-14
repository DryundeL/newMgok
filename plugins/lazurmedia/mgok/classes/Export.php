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
    $sheet->getStyle("A1:E1")->getFont()->setBold(true);
    $sheet->setCellValue('A1', 'Логин');
    $sheet->setCellValue('B1', 'Пароль');
    $sheet->setCellValue('C1', 'ФИО');
    $sheet->setCellValue('D1', 'Класс');
    $sheet->setCellValue('E1', 'Дата рождения');
    $sheet->setCellValue('F1', 'Роль');
    $sheet->setCellValue('G1', 'Доступ к КЭК');

    $users = Users::all();
    foreach($users as $index => $user) {
      ++$index;
      $sheet->setCellValue("A$index", $user->login);
      $sheet->setCellValue("B$index", $user->password);
      $sheet->setCellValue("C$index", $user->full_name);
      $sheet->setCellValue("D$index", $user->class);
      $sheet->setCellValue("E$index", $user->date_of_birth);
      $sheet->setCellValue("F$index", $user->role);
      $sheet->setCellValue("G$index", $user->access);
    }


    $writer = new Xlsx($spreadsheet);
    $csvPath = 'plugins/lazurmedia/mgok/controllers/export.xlsx';
    $fileName = $writer->save($csvPath);
    return Response::download($csvPath, $fileName)->deleteFileAfterSend(true);
  }
}