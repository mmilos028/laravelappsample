<?php

namespace App\Http\Controllers\Authenticated\Player\Excel;

use Illuminate\Support\Facades\View;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
//use App\Models\Postgres\PlayerModel;
use App\Models\Postgres\UserModel;
use App\Helpers\NumberHelper;

use Maatwebsite\Excel\Facades\Excel;

class PlayerController extends Controller
{

    private $excelColumns = array(
        "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z",
        "AA", "AB", "AC", "AD", "AE", "AF", "AG", "AH", "AI", "AJ", "AK", "AL", "AM", "AN", "AO", "AP", "AQ", "AR", "AS", "AT", "AU", "AV", "AW", "AX", "AY", "AZ",
        "BA", "BB", "BC", "BD", "BE", "BF", "BG", "BH", "BI", "BJ", "BK", "BL", "BM", "BN", "BO", "BP", "BQ", "BR", "BS", "BT", "BU", "BV", "BW", "BX", "BY", "BZ",
        "CA", "CB", "CC", "CD", "CE", "CF", "CG", "CH", "CI", "CJ", "CK", "CL", "CM", "CN", "CO", "CP", "CQ", "CR", "CS", "CT", "CU", "CV", "CW", "CX", "CY", "CZ",
        "DA", "DB", "DC", "DD", "DE", "DF", "DG", "DH", "DI", "DJ", "DK", "DL", "DM", "DN", "DO", "DP", "DQ", "DR", "DS", "DT", "DU", "DV", "DW", "DX", "DY", "DZ",
        "EA", "EB", "EC", "ED", "EE", "EF", "EG", "EH", "EI", "EJ", "EK", "EL", "EM", "EN", "EO", "EP", "EQ", "ER", "ES", "ET", "EU", "EV", "EW", "EX", "EY", "EZ",
    );

    public function __construct()
    {
        $agent = new Agent();
        if ($agent->isMobile()) {
            $this->layout = View::make('layouts.mobile_layout');
        }
        if ($agent->isTablet()) {
            $this->layout = View::make('layouts.desktop_layout');
        } else {
            $this->layout = View::make('layouts.desktop_layout');
        }
    }

    public function listPlayersExcel(Request $request){
      Excel::create('list_players', function($objPHPExcel) {
        $authSessionData = Session::get('auth');
        $backoffice_session_id = $authSessionData['backoffice_session_id'];

        //$resultListPlayers = PlayerModel::listPlayers($backoffice_session_id);
        $resultListPlayers = UserModel::listPlayersByType($backoffice_session_id, config("constants.PLAYER_TYPE_ID"));

        $report_title = "List Players";
        $table_header_background_color = \PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE;
        $text_black_color = \PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK;
        $text_white_color = \PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE;

        $objPHPExcel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $objPHPExcel->getProperties()->setCreator("")
                ->setLastModifiedBy("")
                ->setTitle($report_title)
                ->setSubject($report_title)
                ->setDescription($report_title)
                ->setKeywords("")
                ->setCategory("");
            $styleArray = array(
                'font'  => array(
                'size'  => 11,
                'name'  => 'Arial'
            ));
            $objPHPExcel->getDefaultStyle()
            ->applyFromArray($styleArray);
            //set first row title
            $row_number = 1;
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells("A{$row_number}:G{$row_number}");
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue("A{$row_number}", $report_title);
            $objPHPExcel->getActiveSheet()->getStyle("A{$row_number}:A{$row_number}")->applyFromArray(
                array(
                    'fill' => array(
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => array('argb' => $table_header_background_color)
                    ),
                    'font' => array(
                        'name' => 'Arial',
                        'color' => array(
                            'argb' => $text_black_color
                        ),
                        'bold'  => true
                    ),
                    'alignment' => array(
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    )
                )
            )->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            //set table header
            $row_number++;
            $objPHPExcel->getActiveSheet()->getStyle("A{$row_number}:G{$row_number}")->applyFromArray(
                array(
                    'fill' => array(
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => array('argb' => $table_header_background_color)
                    ),
                    'font' => array(
                        'name' => 'Arial',
                        'color' => array(
                            'argb' => $text_black_color
                        ),
                        'bold'  => true
                    ),
                    'alignment' => array(
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    )
                )
            )->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue("A{$row_number}", __("authenticated.Username"))
                ->setCellValue("B{$row_number}", __("authenticated.Parent Entity"))
                ->setCellValue("C{$row_number}", __("authenticated.First Name"))
                ->setCellValue("D{$row_number}", __("authenticated.Last Name"))
                ->setCellValue("E{$row_number}", __("authenticated.Credits"))
                ->setCellValue("F{$row_number}", __("authenticated.Currency"))
                ->setCellValue("G{$row_number}", __("authenticated.Status"))
            ;
            //print table values of report
            //filtering rows on report
            $objPHPExcel->setActiveSheetIndex(0)->setAutoFilter("A{$row_number}:G{$row_number}");
            $row_number++;

            foreach($resultListPlayers['list_users'] as $player) {
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue("A{$row_number}", $player->username)
                    ->setCellValue("B{$row_number}", $player->parent_name)
                    ->setCellValue("C{$row_number}", $player->first_name)
                    ->setCellValue("D{$row_number}", $player->last_name)
                    ->setCellValue("E{$row_number}", NumberHelper::convert_double($player->credits))
                    ->setCellValue("F{$row_number}", $player->currency)
                    ->setCellValue("G{$row_number}", ($player->subject_state == "1") ? __("authenticated.Active") : __("authenticated.Inactive") )
                ;

                $objPHPExcel->getActiveSheet()->getStyle("E{$row_number}:E{$row_number}")->applyFromArray(
                    array(
                        'alignment' => array(
                            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
                        ),
                    )
                );
                $objPHPExcel->getActiveSheet()->getStyle("A{$row_number}:G{$row_number}")
                    ->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $row_number++;
            }

            // Auto size columns for each worksheet
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('A')->setAutoSize(true);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('B')->setAutoSize(true);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('C')->setAutoSize(true);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('D')->setAutoSize(true);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('E')->setAutoSize(true);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('F')->setAutoSize(true);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('G')->setAutoSize(true);

            //set page setup options
            $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);
            $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
            //page setup margins
            $objPHPExcel->getActiveSheet()->getPageMargins()->setTop(0.5);
            $objPHPExcel->getActiveSheet()->getPageMargins()->setRight(0.35);
            $objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(0.35);
            $objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(0.5);
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . $report_title . '.xls"');
            header('Cache-Control: max-age=0');
            header('Cache-Control: max-age=1');
            header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
            header ('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
            header ('Cache-Control: cache, must-revalidate');
            header ('Pragma: public');
            $objWriter = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($objPHPExcel);
            $objWriter->save('php://output');
            exit;
          }
        )->download('xls');
    }


}
