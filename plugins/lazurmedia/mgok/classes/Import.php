<?php namespace Lazurmedia\Mgok\Classes;

require './plugins/lazurmedia/mgok/libraries/PhpSpreadsheet/vendor/autoload.php';

use Db;
use Redirect;
use Lazurmedia\Mgok\Models\Users;
use Lazurmedia\Mgok\Models\Schedule;
use Lazurmedia\Mgok\Models\Journal;
use Lazurmedia\Mgok\Models\AddictionalLessons;
use Lazurmedia\Mgok\Classes\Schedule as ScheduleClass;
use Lazurmedia\Mgok\Controllers\AddictionalLessons as ControllersAddictionalLessons;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class Import 
{
  public static function import($table) {
    $reader = IOFactory::createReader("Xlsx");
    $reader->setReadDataOnly(true); 
    $reader->setReadEmptyCells(false);
    $spreadsheet = $reader->load("./plugins/lazurmedia/mgok/controllers/_import.xlsx");
    $sheet = $spreadsheet->getActiveSheet();
    $rows = [];
    foreach ($sheet->getRowIterator() AS $row) {
      $cellIterator = $row->getCellIterator();
      $cellIterator->setIterateOnlyExistingCells(FALSE); // This loops through all cells,
      $cells = [];
      foreach ($cellIterator as $index => $cell) {
        $cells[] = $cell->getValue();

        if ($table === 'users' && $index === 'F') break;
        if ($table === 'lessons' && $index === 'J') break;
        if ($table === 'journal' && $index === 'F') break;
        if ($table === 'addictional' && $index === 'G') break;
      }

      $rows[] = $cells;
    }

    switch($table) {
      case 'users':
        self::importUser($rows);
        break;
      case 'lessons':
        self::importLessons($rows);
        break;
      case 'journal':
        self::importJournal($rows);
        break;
      case 'addictional':
        self::importAddictional($rows);
        break;
    }

    return Redirect::refresh();
  }

  private static function importJournal($rows) {
    //Journal::truncate();
    foreach($rows as $index => $array) {
      // skip first row, it's titles
      if ($index === 0) continue; 

      if ($array[4]) {
        $date = $array[4];
      }
      else {
        $date = NULL;
      }
      
      $journal = new Journal;
      $journal->class = $array[0];
      $journal->subject = $array[1];
      $journal->student = $array[2];
      $journal->mark = $array[3];
      $journal->date = $date;
      $journal->number_lesson = $array[5];      
      $journal->save();
    }
  }

  private static function importAddictional($rows) 
  {
    AddictionalLessons::truncate();
    foreach($rows as $index => $array) {
      // skip first row, it's titles
      if ($index === 0) continue; 

      $addictional = new AddictionalLessons;
      $addictional->name_lesson = $array[0];
      $addictional->date_lesson = $array[1];
      $addictional->student = $array[2];
      $addictional->mark = $array[3];
      $addictional->class = $array[4];
      $addictional->subject = $array[5];
      $addictional->unique_id = $array[6];
  
      $addictional->save();
    }

  }

  private static function importUser($rows) {
    // Db::table('lazurmedia_mgok_users')->where('id', '>', 13)->delete();
    foreach($rows as $index => $array) {
      // skip first row, it's titles
      if ($index === 0) continue; 

      // skip row if the record is not full
      for ($i=0; $i<6; $i++) {
        if ($i === 3 || $i === 4) continue;
        if ($array[$i] == NULL) continue;
      }

      // skip row if the login is already exist
      $user = Users::where('login', $array[0])->first();
      if(isset($user->id)) continue;
      
      // create record in db
      if ($array[4])
        $date = Date::excelToDateTimeObject($array[4]);
      else 
        $date = NULL;

      $user = new Users;
      $user->login          = $array[0];
      $user->password       = $array[1];
      $user->full_name      = $array[2];
      $user->class          = $array[3];
      $user->date_of_birth  = $date;
      $user->role           = $array[5];
      $user->save();
    }
  }

  private static function importLessons($row) {
    // Db::table('lazurmedia_mgok_schedule')->where('id', '>', 12)->delete();
    foreach($row as $index => $array) {
      // skip first row, it's titles
      if ($index === 0) continue; 

      // create record in db
      $lesson = new Schedule;
      $lesson->number_lesson  = $array[0];
      $lesson->lesson_name    = $array[1];
      $lesson->time_from      = gmdate("H:i", Date::excelToTimestamp($array[2]));
      $lesson->time_to        = gmdate("H:i", Date::excelToTimestamp($array[3]));
      $lesson->cabinet        = $array[4];
      $lesson->teacher        = $array[5];
      $lesson->day_of_week    = $array[6];
      $lesson->class          = $array[7];
      $lesson->parity         = $array[8];
      $lesson->address        = $array[9];
      $lesson->save();
    }
  }
}
?>