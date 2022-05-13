<?php namespace Lazurmedia\Mgok\Classes;

require './plugins/lazurmedia/mgok/libraries/PhpSpreadsheet/vendor/autoload.php';

use Db;
use Redirect;
use Response;
use Lazurmedia\Mgok\Models\Users;
use Lazurmedia\Mgok\Models\Journal;
use Lazurmedia\Mgok\Models\Schedule;

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
    $writer->setPreCalculateFormulas(false);
    $fileName = $writer->save($csvPath);
    return Response::download($csvPath, $fileName)->deleteFileAfterSend(true);
  }

  public static function exportJournal($table)
  {
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->getStyle("A1:F1")->getFont()->setBold(true);
    $sheet->setCellValue('A1', 'Класс');
    $sheet->setCellValue('B1', 'Предмет');
    $sheet->setCellValue('C1', 'ФИО');
    $sheet->setCellValue('D1', 'Оценка');
    $sheet->setCellValue('E1', 'Дата');
    $sheet->setCellValue('F1', 'Номер урока');

    $journals = Journal::all();
    $index = 1;
    foreach($journals as $journal) {
      ++$index;
      $sheet->setCellValue("A$index", $journal->class);
      $sheet->setCellValue("B$index", $journal->subject);
      $sheet->setCellValue("C$index", $journal->student);
      $sheet->setCellValue("D$index", $journal->mark);
      $sheet->setCellValue("E$index", $journal->date);
      $sheet->setCellValue("F$index", $journal->number_lesson);
    }


    $writer = new Xlsx($spreadsheet);
    $csvPath = 'plugins/lazurmedia/mgok/controllers/export.xlsx';
    $fileName = $writer->save($csvPath);
    return Response::download($csvPath, $fileName)->deleteFileAfterSend(true);
  }

  public static function exportLessons(){
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->getStyle("A1:F1")->getFont()->setBold(true);
    $sheet->setCellValue('A1', 'Номер урока');
    $sheet->setCellValue('B1', 'Предмет');
    $sheet->setCellValue('C1', 'Время начала');
    $sheet->setCellValue('D1', 'Время окончания');
    $sheet->setCellValue('E1', 'Кабинет');
    $sheet->setCellValue('F1', 'Учитель');
    $sheet->setCellValue('G1', 'День недели');
    $sheet->setCellValue('H1', 'Класс');
    $sheet->setCellValue('I1', 'Чётность');
    $sheet->setCellValue('K1', 'Адрес');

    $lessons = Schedule::all();
    $index = 1;
    foreach($lessons as $lesson) {
      ++$index;
      $sheet->setCellValue("A$index", $lesson->number_lesson);
      $sheet->setCellValue("B$index", $lesson->lesson_name);
      $sheet->setCellValue("C$index", $lesson->time_from);
      $sheet->setCellValue("D$index", $lesson->time_to);
      $sheet->setCellValue("E$index", $lesson->cabinet);
      $sheet->setCellValue("F$index", $lesson->teacher);
      $sheet->setCellValue("G$index", $lesson->day_of_week);
      $sheet->setCellValue("H$index", $lesson->class);
      $sheet->setCellValue("I$index", $lesson->parity);
      $sheet->setCellValue("K$index", $lesson->address);
    }

    $writer = new Xlsx($spreadsheet);
    $csvPath = 'plugins/lazurmedia/mgok/controllers/export.xlsx';
    $fileName = $writer->save($csvPath);
    return Response::download($csvPath, $fileName)->deleteFileAfterSend(true);
  }
}