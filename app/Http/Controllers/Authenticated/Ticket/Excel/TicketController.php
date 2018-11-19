<?php

namespace App\Http\Controllers\Authenticated\Ticket\Excel;

use Illuminate\Support\Facades\View;
use Jenssegers\Agent\Agent;
//use Illuminate\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\Postgres\TicketModel;
use App\Helpers\NumberHelper;

use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet;
use Validator;

class TicketController extends Controller
{
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


    public function ticketDetails($ticket_serial_number, Request $request){
		
        Excel::create("ticket_details_{$ticket_serial_number}", function($objPHPExcel) use ($ticket_serial_number) {
            $authSessionData = Session::get('auth');
            $backoffice_session_id = $authSessionData['backoffice_session_id'];

			$resultCheckTicketDetails = TicketModel::checkTicketDetailsWithSerialNumber($backoffice_session_id, $ticket_serial_number);
			$tickets = $resultCheckTicketDetails['ticket_result'];
			$combinations_result = $resultCheckTicketDetails['combinations_result'];
            $draw_result = $resultCheckTicketDetails['draw_result'];

            $report_title = __("authenticated.Ticket Details");
            $table_header_background_color = '85B1DE';
            $text_black_color = \PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK;
            $text_white_color = \PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE;

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

            $styleHeader = array(
                'alignment' => array(
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER_CONTINUOUS,
                ),
                'font' => array(
                    'bold'  => true,
                    'color' => array('rgb' => 'FFFFFF'),
                    'size'  => 11,
                    'name'  => 'Arial'
                ),
                'fill' => array(
                    'type' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => array('rgb' => '265B8A')
                )
            );

            $styleContent = array(
                'alignment' => array(
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                ),
                'font' => array(
                    'bold'  => true,
                    'color' => array('rgb' => '000000'),
                    'size'  => 11,
                    'name'  => 'Arial'
                ),
                'fill' => array(
                    'type' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => array('rgb' => 'FFFFFF')
                ),
                'borders' => array(
                    'allborders' => array(
                        'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => array('rgb' => '000000')
                    )
                )
            );

            $styleContentNumber = array(
                'alignment' => array(
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
                ),
                'font' => array(
                    'bold'  => true,
                    'color' => array('rgb' => '000000'),
                    'size'  => 11,
                    'name'  => 'Arial'
                ),
                'fill' => array(
                    'type' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => array('rgb' => 'FFFFFF')
                ),
                'borders' => array(
                    'allborders' => array(
                        'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => array('rgb' => '000000')
                    )
                )
            );

            $styleContentBlue = array(
                'font' => array(
                    'bold'  => true,
                    'color' => array('rgb' => '265B8A'),
                    'size'  => 11,
                    'name'  => 'Arial'
                ),
                'fill' => array(
                    'type' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => array('rgb' => 'FFFFFF')
                ),
                'borders' => array(
                    'allborders' => array(
                        'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => array('rgb' => '000000')
                    )
                )
            );

            $objPHPExcel->getDefaultStyle()
				->applyFromArray($styleArray);
            //set first row title
            $objPHPExcel->createSheet();
			$objPHPExcel->getActiveSheet()->setTitle(__("authenticated.Ticket Details"));
            $row_number = 1;
            $objPHPExcel->getActiveSheet()->mergeCells("A{$row_number}:B{$row_number}");

            $objPHPExcel->getActiveSheet()->getStyle("A{$row_number}:B{$row_number}")
                ->applyFromArray($styleHeader);

            //general ticket details -----------------------------------------------------------------------------------
            $objPHPExcel->getActiveSheet()
                ->setCellValue("A{$row_number}", __("authenticated.Ticket Details"));
            //set table header
            $row_number+=2;
            $total_tickets = count($tickets);
            $i = 0;
            $objPHPExcel->getActiveSheet()->getStyle("A{$row_number}:B{$row_number}")
                ->applyFromArray($styleContent);
            $objPHPExcel->getActiveSheet()
                ->setCellValue("A{$row_number}", __("authenticated.Serial Number"))
                ->setCellValue("B{$row_number}", $tickets[0]->serial_number);
            $row_number++;
            $objPHPExcel->getActiveSheet()->getStyle("A{$row_number}:B{$row_number}")
                ->applyFromArray($styleContent);
            $objPHPExcel->getActiveSheet()
                ->setCellValue("A{$row_number}", __("authenticated.Barcode"))
                ->setCellValue("B{$row_number}", $tickets[0]->barcode);
            $row_number++;
            $objPHPExcel->getActiveSheet()->getStyle("A{$row_number}:B{$row_number}")
                ->applyFromArray($styleContent);
            $objPHPExcel->getActiveSheet()
                ->setCellValue("A{$row_number}", __("authenticated.Ticket Created"))
                ->setCellValue("B{$row_number}", $tickets[0]->rec_tmstp);
            $row_number++;
            $objPHPExcel->getActiveSheet()->getStyle("A{$row_number}:B{$row_number}")
                ->applyFromArray($styleContent);
            $objPHPExcel->getActiveSheet()
                ->setCellValue("A{$row_number}", __("authenticated.Created By"))
                ->setCellValue("B{$row_number}", $tickets[0]->created_by);
            $row_number++;
            $objPHPExcel->getActiveSheet()->getStyle("A{$row_number}:B{$row_number}")
                ->applyFromArray($styleContent);
            $objPHPExcel->getActiveSheet()
                ->setCellValue("A{$row_number}", __("authenticated.Jackpot Code"))
                ->setCellValue("B{$row_number}",
                    __('authenticated.Local') . ": " .
                    $tickets[0]->local_jp_code . "  " .
                    __('authenticated.Global') . ": " .
                    $tickets[0]->global_jp_code
                );
            $row_number++;
            $objPHPExcel->getActiveSheet()->getStyle("A{$row_number}:B{$row_number}")
                ->applyFromArray($styleContent);
            $objPHPExcel->getActiveSheet()
                ->setCellValue("A{$row_number}", __("authenticated.First Draw ID / SN"))
                ->setCellValue("B{$row_number}", $tickets[0]->first_draw_id . " / " . $tickets[0]->first_draw_sn);
            $row_number++;
            $objPHPExcel->getActiveSheet()->getStyle("A{$row_number}")
                ->applyFromArray($styleContent);
            $objPHPExcel->getActiveSheet()->getStyle("B{$row_number}")
                ->applyFromArray($styleContentNumber);
            $objPHPExcel->getActiveSheet()
                ->setCellValue("A{$row_number}", __("authenticated.First Draw"))
                ->setCellValue("B{$row_number}", $tickets[0]->first_draw_date_time);
            $objPHPExcel->getActiveSheet()
                ->setCellValue("A{$row_number}", __("authenticated.No. Of Repeat Draws"))
                ->setCellValue("B{$row_number}", $tickets[0]->repeat_draws);
            $row_number++;
            $objPHPExcel->getActiveSheet()->getStyle("A{$row_number}")
                ->applyFromArray($styleContent);
            $objPHPExcel->getActiveSheet()->getStyle("B{$row_number}")
                ->applyFromArray($styleContentNumber);
            $objPHPExcel->getActiveSheet()
                ->setCellValue("A{$row_number}", __("authenticated.Bet Per Draw"))
                ->setCellValue("B{$row_number}", NumberHelper::format_double($tickets[0]->bet_per_draw));
            $row_number++;
            $objPHPExcel->getActiveSheet()->getStyle("A{$row_number}")
                ->applyFromArray($styleContent);
            $objPHPExcel->getActiveSheet()->getStyle("B{$row_number}")
                ->applyFromArray($styleContentNumber);
            $objPHPExcel->getActiveSheet()
                ->setCellValue("A{$row_number}", __("authenticated.Total Bet per ticket"))
                ->setCellValue("B{$row_number}", NumberHelper::format_double($tickets[0]->bet_per_ticket));
            $row_number++;
            $objPHPExcel->getActiveSheet()->getStyle("A{$row_number}")
                ->applyFromArray($styleContent);
            $objPHPExcel->getActiveSheet()->getStyle("B{$row_number}")
                ->applyFromArray($styleContentNumber);
            $objPHPExcel->getActiveSheet()
                ->setCellValue("A{$row_number}", __("authenticated.Possible Win"))
                ->setCellValue("B{$row_number}", NumberHelper::format_double($tickets[0]->possible_win));
            $row_number++;
            $objPHPExcel->getActiveSheet()->getStyle("A{$row_number}")
                ->applyFromArray($styleContent);
            $objPHPExcel->getActiveSheet()->getStyle("B{$row_number}")
                ->applyFromArray($styleContentNumber);
            $objPHPExcel->getActiveSheet()
                ->setCellValue("A{$row_number}", __("authenticated.Maximal Payout"))
                ->setCellValue("B{$row_number}", NumberHelper::format_double($tickets[0]->maximal_payout));
            $row_number++;
            $objPHPExcel->getActiveSheet()->getStyle("A{$row_number}")
                ->applyFromArray($styleContent);
            $objPHPExcel->getActiveSheet()->getStyle("B{$row_number}")
                ->applyFromArray($styleContentNumber);
            $objPHPExcel->getActiveSheet()
                ->setCellValue("A{$row_number}", __("authenticated.Currency"))
                ->setCellValue("B{$row_number}", $tickets[0]->currency);
            $row_number++;
            $objPHPExcel->getActiveSheet()->getStyle("A{$row_number}")
                ->applyFromArray($styleContent);
            $objPHPExcel->getActiveSheet()->getStyle("B{$row_number}")
                ->applyFromArray($styleContentNumber);
            $objPHPExcel->getActiveSheet()
                ->setCellValue("A{$row_number}", __("authenticated.Ticket Status"))
                ->setCellValue("B{$row_number}",  $this->getTicketStatus($tickets[0]->ticket_status));
            $row_number++;
            $objPHPExcel->getActiveSheet()->getStyle("A{$row_number}")
                ->applyFromArray($styleContent);
            $objPHPExcel->getActiveSheet()->getStyle("B{$row_number}")
                ->applyFromArray($styleContentNumber);
            $objPHPExcel->getActiveSheet()
                ->setCellValue("A{$row_number}", __("authenticated.Jackpot Win"))
                ->setCellValue("B{$row_number}", NumberHelper::format_double($tickets[0]->jackpot_win));
            $row_number++;
            $objPHPExcel->getActiveSheet()->getStyle("A{$row_number}")
                ->applyFromArray($styleContent);
            $objPHPExcel->getActiveSheet()->getStyle("B{$row_number}")
                ->applyFromArray($styleContentNumber);
            $objPHPExcel->getActiveSheet()
                ->setCellValue("A{$row_number}", __("authenticated.Win To Pay Out"))
                ->setCellValue("B{$row_number}", NumberHelper::format_double($tickets[0]->win_to_pay_out));
            $row_number++;
            $objPHPExcel->getActiveSheet()->getStyle("A{$row_number}")
                ->applyFromArray($styleContent);
            $objPHPExcel->getActiveSheet()->getStyle("B{$row_number}")
                ->applyFromArray($styleContentNumber);
            $objPHPExcel->getActiveSheet()
                ->setCellValue("A{$row_number}", __("authenticated.Ticket Printed"))
                ->setCellValue("B{$row_number}",  $this->getTicketPrintedStatus($tickets[0]->ticket_printed));
            $row_number++;
            $objPHPExcel->getActiveSheet()->getStyle("A{$row_number}")
                ->applyFromArray($styleContent);
            $objPHPExcel->getActiveSheet()->getStyle("B{$row_number}")
                ->applyFromArray($styleContentNumber);
            $objPHPExcel->getActiveSheet()
                ->setCellValue("A{$row_number}", __("authenticated.Control Preferred Ticket"))
                ->setCellValue("B{$row_number}",  $this->getPreferredControlStatus($tickets[0]->preferred_ticket));
            $row_number++;


            //combination result ---------------------------------------------------------------------------------------
            $row_number = 1;

            $objPHPExcel->getActiveSheet()->mergeCells("D{$row_number}:E{$row_number}");
            $objPHPExcel->getActiveSheet()->mergeCells("D{$row_number}:F{$row_number}");
            $objPHPExcel->getActiveSheet()
                ->setCellValue("D{$row_number}", __("authenticated.Combinations Result"));
            $objPHPExcel->getActiveSheet()->getStyle("D{$row_number}")
                ->applyFromArray($styleHeader);

            $styleTableHeader = array(
                'font' => array(
                    'bold'  => true,
                    'color' => array('rgb' => '000000'),
                    'size'  => 11,
                    'name'  => 'Arial'
                ),
                'fill' => array(
                    'type' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => array('rgb' => '949393')
                ),
                'borders' => array(
                    'allborders' => array(
                        'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => array('rgb' => '000000')
                    )
                )
            );

            $row_number+=2;

            $objPHPExcel->getActiveSheet()->getStyle("D{$row_number}:E{$row_number}")
                ->applyFromArray($styleTableHeader);
            $objPHPExcel->getActiveSheet()->getStyle("F{$row_number}")
                ->applyFromArray($styleTableHeader);
            $objPHPExcel->getActiveSheet()
                ->setCellValue("D{$row_number}", __("authenticated.Combination Type"))
                ->setCellValue("E{$row_number}", __("authenticated.Combination Value"))
                ->setCellValue("F{$row_number}", __("authenticated.Bet"));
            $row_number++;

            foreach ($combinations_result as $c){
                $objPHPExcel->getActiveSheet()->getStyle("D{$row_number}:E{$row_number}")
                    ->applyFromArray($styleContent);
                $objPHPExcel->getActiveSheet()->getStyle("F{$row_number}")
                    ->applyFromArray($styleContentNumber);
                $objPHPExcel->getActiveSheet()
                    ->setCellValue("D{$row_number}", $c->combination_type_name)
                    ->setCellValue("E{$row_number}", $this->getCombinationValue($c->combination_type_id, $c->combination_value))
                    ->setCellValue("F{$row_number}", NumberHelper::format_double($c->bet));
                $row_number++;
            }
            $row_number++;
            $objPHPExcel->getActiveSheet()->getStyle("D{$row_number}:E{$row_number}")
                ->applyFromArray($styleTableHeader);
            $objPHPExcel->getActiveSheet()->getStyle("F{$row_number}")
                ->applyFromArray($styleTableHeader);
            $objPHPExcel->getActiveSheet()
                ->setCellValue("D{$row_number}", "")
                ->setCellValue("E{$row_number}", __('authenticated.Total Bet').":")
                ->setCellValue("F{$row_number}", $tickets[0]->bet_per_ticket);

            //draw results ---------------------------------------------------------------------------------------------
            $row_number = 1;

            $objPHPExcel->getActiveSheet()->mergeCells("H{$row_number}:I{$row_number}");
            $objPHPExcel->getActiveSheet()
                ->setCellValue("H{$row_number}", __("authenticated.Draw Result"));
            $objPHPExcel->getActiveSheet()->getStyle("H{$row_number}")
                ->applyFromArray($styleHeader);
            $row_number+=2;
            foreach ($draw_result as $c){
                $objPHPExcel->getActiveSheet()->getStyle("H{$row_number}:I{$row_number}")
                    ->applyFromArray($styleContentBlue);
                $objPHPExcel->getActiveSheet()
                    ->setCellValue("H{$row_number}", __('authenticated.For Draw ID / SN'))
                    ->setCellValue("I{$row_number}", $c->first_draw_id." / ".$c->first_draw_sn);
                $row_number++;
                $objPHPExcel->getActiveSheet()->getStyle("H{$row_number}:I{$row_number}")
                    ->applyFromArray($styleContent);
                $objPHPExcel->getActiveSheet()
                    ->setCellValue("H{$row_number}", __('authenticated.Draw Time'))
                    ->setCellValue("I{$row_number}", $c->first_draw_date_time);
                $row_number++;
                $objPHPExcel->getActiveSheet()->getStyle("H{$row_number}")
                    ->applyFromArray($styleContent);
                $objPHPExcel->getActiveSheet()->getStyle("I{$row_number}")
                    ->applyFromArray($styleContentNumber);
                $objPHPExcel->getActiveSheet()
                    ->setCellValue("H{$row_number}", __('authenticated.JackPot Win'))
                    ->setCellValue("I{$row_number}", NumberHelper::format_double($c->jackpot_win));
                $row_number++;
                $objPHPExcel->getActiveSheet()->getStyle("H{$row_number}:I{$row_number}")
                    ->applyFromArray($styleContent);
                $objPHPExcel->getActiveSheet()
                    ->setCellValue("H{$row_number}", __('authenticated.Draw Status'))
                    ->setCellValue("I{$row_number}", $this->getDrawStatus($c->draw_status));
                $row_number++;
                $row_number++;
            }

            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);

            //set page setup options
            $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);
            $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
            //page setup margins
            $objPHPExcel->getActiveSheet()->getPageMargins()->setTop(0.5);
            $objPHPExcel->getActiveSheet()->getPageMargins()->setRight(0.35);
            $objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(0.35);
            $objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(0.5);
          }
        )
        ->download('xls');
    }

    public function searchTickets(Request $request){
        $authSessionData = Session::get('auth');
        $backoffice_session_id = $authSessionData['backoffice_session_id'];

        $start_date = $request->query('report_start_date', $authSessionData['report_start_date']);
        $end_date = $request->query('report_end_date', $authSessionData['report_end_date']);

        $ticket_id = $request->query('ticket_id', null);
        $ticket_draw_id = $request->query('draw_id', null);
        $ticket_barcode = $request->query('barcode', null);
        $player_name = $request->query('player_name', null);
        $cashier_name = $request->query('cashier_name', null);
        $ticket_status = $request->query('ticket_status', null);


        if(isset($ticket_id) && strlen($ticket_id) > 0){
            $resultCheckTicketDetails = TicketModel::searchTickets($backoffice_session_id, null, null, null, null,
                null, null, null, $ticket_id
            );
        }else {
            $resultCheckTicketDetails = TicketModel::searchTickets($backoffice_session_id, $ticket_draw_id, $ticket_barcode, $player_name, $cashier_name,
                $start_date, $end_date, $ticket_status, null
            );
        }

        Excel::create("search_tickets", function($objPHPExcel) use ($resultCheckTicketDetails) {

			$tickets = $resultCheckTicketDetails['ticket_result'];

            $report_title = __("authenticated.Search Tickets");
            $table_header_background_color = '85B1DE';
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
			$objPHPExcel->getActiveSheet()->setTitle(__("authenticated.Search Tickets"));
            $row_number = 1;
            $objPHPExcel->getActiveSheet()->mergeCells("A{$row_number}:O{$row_number}");
            $objPHPExcel->getActiveSheet()
                ->setCellValue("A{$row_number}", __("authenticated.Search Tickets"));
            //set table header
            $row_number++;
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue("A{$row_number}", __("authenticated.Ticket ID"))
                ->setCellValue("B{$row_number}", __("authenticated.Draw ID"))
                ->setCellValue("C{$row_number}", __("authenticated.Barcode"))
                ->setCellValue("D{$row_number}", __("authenticated.Date & Time"))
                ->setCellValue("E{$row_number}", __("authenticated.Cashier"))
                ->setCellValue("F{$row_number}", __("authenticated.Player Username"))
                ->setCellValue("G{$row_number}", __("authenticated.Payed Out"))
                ->setCellValue("H{$row_number}", __("authenticated.Ticket Status"))
                ->setCellValue("I{$row_number}", __("authenticated.City"))
                ->setCellValue("J{$row_number}", __("authenticated.Address"))
                ->setCellValue("K{$row_number}", __("authenticated.Commercial Address"))
                ->setCellValue("L{$row_number}", __("authenticated.Language"))
                ->setCellValue("M{$row_number}", __("authenticated.Ticket Printed"))
                ->setCellValue("N{$row_number}", __("authenticated.Number Of Ticket Printed"))
                ->setCellValue("O{$row_number}", __("authenticated.Jackpot Code"))
                ->setCellValue("P{$row_number}", __("authenticated.Jackpot Win"))
            ;
            $row_number++;
            foreach($tickets as $ticket) {
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue("A{$row_number}", $ticket->serial_number)
                    ->setCellValue("B{$row_number}", $ticket->draw_id)
                    ->setCellValue("C{$row_number}", $ticket->barcode)
                    ->setCellValue("D{$row_number}", $ticket->rec_tmstp_formated)
                    ->setCellValue("E{$row_number}", $ticket->cashier)
                    ->setCellValue("F{$row_number}", $ticket->player_username)
                    ->setCellValue("G{$row_number}", $this->getPayedOutStatus($ticket->payed_out))
                    ->setCellValue("H{$row_number}", $this->getTicketStatus($ticket->ticket_status))
                    ->setCellValue("I{$row_number}", $ticket->city)
                    ->setCellValue("J{$row_number}", $ticket->address)
                    ->setCellValue("K{$row_number}", $ticket->commercial_address)
                    ->setCellValue("L{$row_number}", $this->getLanguage($ticket->language))
                    ->setCellValue("M{$row_number}", $this->getTicketPrintedStatus($ticket->ticket_printed))
                    ->setCellValue("N{$row_number}", NumberHelper::convert_integer($ticket->no_of_printings))
                    ->setCellValue("O{$row_number}", __("authenticated.Local") . ":" . $ticket->local_jp_code . "  " . __("authenticated.Global") . ":" . $ticket->global_jp_code)
                    ->setCellValue("P{$row_number}", NumberHelper::convert_double($ticket->jackpot_win))
                ;
                $row_number++;
            }

            // Auto size columns for each worksheet
			$objPHPExcel->setActiveSheetIndex(0);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('A')->setAutoSize(true);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('B')->setAutoSize(true);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('C')->setAutoSize(true);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('D')->setAutoSize(true);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('E')->setAutoSize(true);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('F')->setAutoSize(true);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('G')->setAutoSize(true);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('H')->setAutoSize(true);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('I')->setAutoSize(true);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('J')->setAutoSize(true);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('K')->setAutoSize(true);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('L')->setAutoSize(true);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('M')->setAutoSize(true);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('N')->setAutoSize(true);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('O')->setAutoSize(true);
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('P')->setAutoSize(true);

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
        )
        ->download('xls');
    }

    private function getPayedOutStatus($status){
        if($status == "1"){
            return __("authenticated.Yes");
        }else{
            return __("authenticated.No");
        }
    }

    private function getTicketPrintedStatus($status){
        if($status == "1"){
            return __("authenticated.Yes");
        }else{
            return __("authenticated.No");
        }
    }

    private function getPreferredControlStatus($status){
        if($status == 1){
            return __("authenticated.Control Preferred Ticket Small");
        }
        else if($status == 2){
            return __("authenticated.Control Preferred Ticket Medium");
        }
        else{
            return __("authenticated.Control Preferred Ticket Off");
        }
    }

    private function getCombinationValue($id, $status){
        if ($id == config("constants.sum_first_5") || $id == config("constants.first_ball_hi_low") || $id == config("constants.last_ball_hi_low")) {
            if ($status == 1) {
                return __("authenticated.Lower");
            } else if ($status == 2) {
                return __("authenticated.Higher");
            }else{
                return $status;
            }
        }else if ($id == config("constants.first_ball_even_odd") || $id == config("constants.more_even_odd") || $id == config("constants.last_ball_even_odd")) {
            if ($status == 1) {
                return __("authenticated.Even");
            } else if ($status == 2) {
                return __("authenticated.Odd");
            }else{
                return $status;
            }
        } else {
            return $status;
        }
    }

    private function getDrawStatus($status){
        if($status == -1){
            return __("authenticated.SCHEDULED");
        }elseif($status == 0){
            return __("authenticated.IN PROGRESS");
        }elseif($status == 1){
            return __("authenticated.COMPLETED");
        }else {
            return "";
        }
    }

    private function getTicketStatus($ticket_status){
        if($ticket_status == -1)
            return __("authenticated.DEACTIVATED");
        else if($ticket_status == 0)
            return __("authenticated.RESERVED");
        else if($ticket_status == 1)
            return __("authenticated.PAID-IN");
        else if($ticket_status == 2)
            return __("authenticated.WINNING");
        else if($ticket_status == 3)
            return __("authenticated.WINNING NOT PAID-OUT");
        else if($ticket_status == 4)
            return __("authenticated.PAID-OUT");
        else if($ticket_status == 5)
            return __("authenticated.LOSING");
        else return "";
    }

    private function getLanguage($language){
        if($language == 'en_GB')
            return __("authenticated.English");
        else if($language == 'de_DE')
            return __("authenticated.German");
        else if($language == 'sv_SE')
            return __("authenticated.Swedish");
        else if($language == 'da_DK')
            return __("authenticated.Danish");
        else if($language == 'it_IT')
            return __("authenticated.Italian");
        else if($language == 'ru_RU')
            return __("authenticated.Russian");
        else if($language == 'pl_PL')
            return __("authenticated.Polish");
        else if($language == 'hr_HR')
            return __("authenticated.Croatian");
        else if($language == 'rs_RS')
            return __("authenticated.Serbian");
        else if($language == 'tr_TR')
            return __("authenticated.Turkish");
        else if($language == 'cs_CZ')
            return __("authenticated.Czeck");
        else if($language == 'sq_AL')
            return __("authenticated.Albanian");
        else return __("authenticated.English");
    }
}
