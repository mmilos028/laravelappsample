<?php

namespace App\Models\Postgres;

use Illuminate\Support\Facades\DB;

use App\Helpers\ErrorHelper;

class TicketModel
{

    private static $DEBUG = false;

    public static function payTable(){
        try{
            $payTableProcessed = array();
            $coefficientsProcessed = array();

            $i = 0;
            foreach (ORDER_OF_DRAWN_BALL as $order){
                $payTableProcessed[$i]["ORDER_OF_DRAWN_BALL"] = $order;
                $i++;
            }
            $i = 0;
            foreach (QUOTA as $quota){
                $payTableProcessed[$i]["QUOTA"] = $quota;
                $i++;
            }
            $i = 0;
            foreach (ORDER_OF_DRAWN_BALL_2 as $order){
                $payTableProcessed[$i]["ORDER_OF_DRAWN_BALL_2"] = $order;
                $i++;
            }
            $i = 0;
            foreach (QUOTA_2 as $quota){
                $payTableProcessed[$i]["QUOTA_2"] = $quota;
                $i++;
            }
            $i = 0;
            foreach (ORDER_OF_DRAWN_BALL_3 as $order){
                $payTableProcessed[$i]["ORDER_OF_DRAWN_BALL_3"] = $order;
                $i++;
            }
            $i = 0;
            foreach (QUOTA_3 as $quota){
                $payTableProcessed[$i]["QUOTA_3"] = $quota;
                $i++;
            }
            $i = 0;
            foreach (COEFFICIENTS as $coefficient){
                $coefficientsProcessed[$i]["name"] = $coefficient["name"];
                $coefficientsProcessed[$i]["value"] = $coefficient["value"];
                $i++;
            }
            $i = 0;

            return [
                "status" => "OK",
                "payTable" => $payTableProcessed,
                "coefficients" => $coefficientsProcessed
            ];

        }catch(\PDOException $ex1){
            ErrorHelper::writeError($ex1, $ex1);
            return [
                "status" => "NOK"
            ];
        }catch(\Exception $ex2){
            ErrorHelper::writeError($ex2, $ex2);
            return [
                "status" => "NOK"
            ];
        }
    }
    public static function checkTicketDetailsWithBarcode($backoffice_session_id, $ticket_barcode){
        try{

            if(self::$DEBUG){
                $message = "TicketModel::checkTicketDetailsWithBarcode >>> SELECT tomboladb.tombola.get_temp_ticket_details_from_barcode(:p_session_id = {$backoffice_session_id}, :p_ticket_barcode = {$ticket_barcode}, 'cur_result_out', 'cur_combinations_out')";
                ErrorHelper::writeInfo($message, $message);
            }

            DB::connection('pgsql')->beginTransaction();
            $statement_string = 'SELECT * from tomboladb.tombola.get_temp_ticket_details_from_barcode(:p_session_id, :p_ticket_barcode)';

            $fn_result = DB::connection('pgsql')->select($statement_string,
                array(
                    'p_session_id'=>$backoffice_session_id,
                    'p_ticket_barcode'=>$ticket_barcode
                )
            );

            $cursor_name1 = $fn_result[0]->cur_result_out;
            $cur_result1 = DB::connection('pgsql')->select("fetch all in {$cursor_name1}");

            $cursor_name2 = $fn_result[0]->cur_combinations_out;
            $cur_result2 = DB::connection('pgsql')->select("fetch all in {$cursor_name2}");

            DB::connection('pgsql')->commit();

            return [
                "status" => "OK",
                "ticket_result"=>$cur_result1,
                "combinations_result"=>$cur_result2
            ];
        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "TicketModel::checkTicketDetailsWithBarcode(backoffice_session_id = {$backoffice_session_id}, ticket_barcode={$ticket_barcode}) <br />\n\n",
                "tomboladb.tombola.get_temp_ticket_details_from_barcode(:p_session_id = {$backoffice_session_id}, :p_ticket_barcode = {$ticket_barcode}) <br />\n\n",
                $ex1->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK"
            ];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "TicketModel::checkTicketDetailsWithBarcode(backoffice_session_id = {$backoffice_session_id}, ticket_barcode={$ticket_barcode}) <br />\n\n",
                "tomboladb.tombola.get_temp_ticket_details_from_barcode(:p_session_id = {$backoffice_session_id}, :p_ticket_barcode = {$ticket_barcode}) <br />\n\n",
                $ex2->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK"
            ];
        }
    }

    /**
     * @param $backoffice_session_id
     * @param $ticket_id
     * @return array
     */
    public static function checkTicketDetailsWithTicketId($backoffice_session_id, $ticket_id){
        try{

            if(self::$DEBUG){
                $message = "TicketModel::checkTicketDetailsWithSerialNumber >>> SELECT tomboladb.tombola.get_ticket_details(:p_session_id = {$backoffice_session_id},:p_ticket_id_in = {$ticket_id}, 'cur_result_out', 'cur_combinations_out')";
                ErrorHelper::writeInfo($message, $message);
            }

            DB::connection('pgsql')->beginTransaction();
            $statement_string = 'SELECT * from tomboladb.tombola.get_ticket_details(:p_session_id, :p_ticket_id_in)';

            $fn_result = DB::connection('pgsql')->select($statement_string,
                array(
                    'p_session_id' => $backoffice_session_id,
                    'p_ticket_id_in'=>$ticket_id
                )
            );
            $cursor_name1 = $fn_result[0]->cur_result_out;
            $cur_result1 = DB::connection('pgsql')->select("fetch all in {$cursor_name1}");

            $cursor_name2 = $fn_result[0]->cur_combinations_out;
            $cur_result2 = DB::connection('pgsql')->select("fetch all in {$cursor_name2}");

            DB::connection('pgsql')->commit();

            return [
                "status" => "OK",
                "ticket_result"=>$cur_result1,
                "combinations_result"=>$cur_result2
            ];
        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "TicketModel::checkTicketDetailsWithTicketId(backoffice_session_id = {$backoffice_session_id}, ticket_id={$ticket_id}) <br />\n\n",
                "tomboladb.tombola.get_ticket_details(:p_session_id = {$backoffice_session_id},:p_ticket_id_in = {$ticket_id}, 'cur_result_out', 'cur_combinations_out') <br />\n\n",
                $ex1->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK"
            ];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "TicketModel::checkTicketDetailsWithTicketId(backoffice_session_id = {$backoffice_session_id}, ticket_id={$ticket_id}) <br />\n\n",
                "tomboladb.tombola.get_ticket_details(:p_session_id = {$backoffice_session_id},:p_ticket_id_in = {$ticket_id}, 'cur_result_out', 'cur_combinations_out') <br />\n\n",
                $ex2->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK"
            ];
        }
    }

    /**
     * @param $backoffice_session_id
     * @param $ticket_serial_number
     * @return array
     */
    public static function checkTicketDetailsWithSerialNumber($backoffice_session_id, $ticket_serial_number){
        try{

            if(self::$DEBUG){
                $message = "TicketModel::checkTicketDetailsWithSerialNumber >>> SELECT tomboladb.core.report_ticket_sn_details(:p_session_id = {$backoffice_session_id}, :p_ticket_serial_number = {$ticket_serial_number}, 'cur_result_out', 'cur_combinations_out')";
                ErrorHelper::writeInfo($message, $message);
            }

            DB::connection('pgsql')->beginTransaction();
            $statement_string = 'SELECT * from tomboladb.core.report_ticket_sn_details(:p_session_id, :p_ticket_serial_number)';

            $fn_result = DB::connection('pgsql')->select($statement_string,
                array(
                    'p_session_id'=>$backoffice_session_id,
                    'p_ticket_serial_number'=>$ticket_serial_number
                )
            );

            $cursor_name1 = $fn_result[0]->cur_result_out;
            $cur_result1 = DB::connection('pgsql')->select("fetch all in {$cursor_name1}");

            $cursor_name2 = $fn_result[0]->cur_combinations_out;
            $cur_result2 = DB::connection('pgsql')->select("fetch all in {$cursor_name2}");

            $cursor_name3 = $fn_result[0]->cur_draw_details;
            $cur_result3 = DB::connection('pgsql')->select("fetch all in {$cursor_name3}");

            DB::connection('pgsql')->commit();

            return [
                "status" => "OK",
                "ticket_result"=>$cur_result1,
                "combinations_result"=>$cur_result2,
                "draw_result"=>$cur_result3
            ];
        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "TicketModel::checkTicketDetailsWithSerialNumber(backoffice_session_id = {$backoffice_session_id}, ticket_serial_number={$ticket_serial_number}) <br />\n\n",
                "tomboladb.core.report_ticket_sn_details(:p_session_id = {$backoffice_session_id}, :p_ticket_serial_number = {$ticket_serial_number}, 'cur_result_out', 'cur_combinations_out') <br />\n\n",
                $ex1->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK"
            ];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "TicketModel::checkTicketDetailsWithSerialNumber(backoffice_session_id = {$backoffice_session_id}, ticket_serial_number={$ticket_serial_number}) <br />\n\n",
                "tomboladb.core.report_ticket_sn_details(:p_session_id = {$backoffice_session_id}, :p_ticket_serial_number = {$ticket_serial_number}, 'cur_result_out', 'cur_combinations_out') <br />\n\n",
                $ex2->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK"
            ];
        }
    }

    /**
     * @param $draw_ids
     * @return array
     */
    public static function checkTicketDetailsWithDrawId($draw_id){
        try{

            if(self::$DEBUG){
                $message = "TicketModel::checkTicketDetailsWithDrawId >>> SELECT tomboladb.tombola.get_tickets_for_draw(:p_draw_id_in = {$draw_id}, 'cur_result_out')";
                ErrorHelper::writeInfo($message, $message);
            }

            DB::connection('pgsql')->beginTransaction();
            $statement_string = 'SELECT * from tomboladb.tombola.get_tickets_for_draw(:p_draw_id_in)';

            $fn_result = DB::connection('pgsql')->select($statement_string,
                array( 'p_draw_id_in'=>$draw_id )
            );
            $cursor_name = $fn_result[0]->cur_result_out;

            $cur_result = DB::connection('pgsql')->select("fetch all in {$cursor_name}");

            DB::connection('pgsql')->commit();

            return [
                "status" => "OK",
                "ticket_result"=>$cur_result
            ];
        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "TicketModel::checkTicketDetailsWithDrawId(draw_id={$draw_id}) <br />\n\n",
                "tomboladb.tombola.get_tickets_for_draw(:p_draw_id_in = {$draw_id}, 'cur_result_out') <br />\n\n",
                $ex1->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "ticket_result" => null
            ];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "TicketModel::checkTicketDetailsWithDrawId(draw_id={$draw_id}) <br />\n\n",
                "tomboladb.tombola.get_tickets_for_draw(:p_draw_id_in = {$draw_id}, 'cur_result_out') <br />\n\n",
                $ex2->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "ticket_result" => null
            ];
        }
    }

    /**
     * @param $backoffice_session_id
     * @return array
     */
    public static function listAllTickets($backoffice_session_id){
        try{

            if(self::$DEBUG){
                $message = "TicketModel::listAllTickets >>> SELECT tomboladb.tombola.list_all_tickets(:p_session_id_in = {$backoffice_session_id}, 'cur_result_out')";
                ErrorHelper::writeInfo($message, $message);
            }

            DB::connection('pgsql')->beginTransaction();
            $statement_string = "SELECT * from tomboladb.tombola.list_all_tickets(:p_session_id_in)";

            $fn_result = DB::connection('pgsql')->select($statement_string,
                array( 'p_session_id_in'=>$backoffice_session_id )
            );
            $cursor_name = $fn_result[0]->cur_result_out;

            $cur_result = DB::connection('pgsql')->select("fetch all in {$cursor_name}");
            //$cur_result = DB::connection('pgsql')->select("fetch all in cur_result_out");

            DB::connection('pgsql')->commit();

            return [
                "status" => "OK",
                "ticket_result"=>$cur_result
            ];
        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "TicketModel::listAllTickets(backoffice_session_id={$backoffice_session_id}) <br />\n\n",
                "tomboladb.tombola.list_all_tickets(:p_session_id_in = {$backoffice_session_id}, 'cur_result_out') <br />\n\n",
                $ex1->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "ticket_result" => null
            ];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "TicketModel::listAllTickets(backoffice_session_id={$backoffice_session_id}) <br />\n\n",
                "tomboladb.tombola.list_all_tickets(:p_session_id_in = {$backoffice_session_id}, 'cur_result_out') <br />\n\n",
                $ex2->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "ticket_result" => null
            ];
        }
    }

    /**
     * @param $backoffice_session_id
     * @return array
     */
    public static function listAnonymousTickets($backoffice_session_id){
        try{

            if(self::$DEBUG){
                $message = "TicketModel::listAnonymousTickets >>> SELECT tomboladb.tombola.list_all_tickets_anonymus(:p_session_id_in = {$backoffice_session_id}, 'cur_result_out')";
                ErrorHelper::writeInfo($message, $message);
            }

            DB::connection('pgsql')->beginTransaction();
            $statement_string = 'SELECT * from tomboladb.tombola.list_all_tickets_anonymus(:p_session_id_in)';

            $fn_result = DB::connection('pgsql')->select($statement_string,
                array( 'p_session_id_in'=>$backoffice_session_id )
            );
            $cursor_name = $fn_result[0]->cur_result_out;

            $cur_result = DB::connection('pgsql')->select("fetch all in {$cursor_name}");

            DB::connection('pgsql')->commit();

            return [
                "status" => "OK",
                "ticket_result"=>$cur_result
            ];
        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "TicketModel::listAnonymousTickets(backoffice_session_id={$backoffice_session_id}) <br />\n\n",
                "tomboladb.tombola.list_all_tickets_anonymus(:p_session_id_in = {$backoffice_session_id}, 'cur_result_out') <br />\n\n",
                $ex1->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "ticket_result" => null
            ];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "TicketModel::listAnonymousTickets(backoffice_session_id={$backoffice_session_id}) <br />\n\n",
                "tomboladb.tombola.list_all_tickets_anonymus(:p_session_id_in = {$backoffice_session_id}, 'cur_result_out') <br />\n\n",
                $ex2->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "ticket_result" => null
            ];
        }
    }

    /**
     * @param $backoffice_session_id
     * @return array
     */
    public static function listTemporaryTickets($backoffice_session_id){
        try{

            if(self::$DEBUG){
                $message = "TicketModel::listTemporaryTickets >>> SELECT tomboladb.tombola.list_all_temp_tickets(:p_session_id_in = {$backoffice_session_id}, 'cur_result_out')";
                ErrorHelper::writeInfo($message, $message);
            }

            DB::connection('pgsql')->beginTransaction();
            $statement_string = 'SELECT * from tomboladb.tombola.list_all_temp_tickets(:p_session_id_in)';

            $fn_result = DB::connection('pgsql')->select($statement_string,
                array(
                    'p_session_id_in'=>$backoffice_session_id
                )
            );
            $cursor_name = $fn_result[0]->cur_result_out;

            $cur_result = DB::connection('pgsql')->select("fetch all in {$cursor_name}");

            DB::connection('pgsql')->commit();

            return [
                "status" => "OK",
                "ticket_result"=>$cur_result
            ];
        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "TicketModel::listTemporaryTickets(backoffice_session_id={$backoffice_session_id}) <br />\n\n",
                "tomboladb.tombola.list_all_temp_tickets(:p_session_id_in = {$backoffice_session_id}, 'cur_result_out') <br />\n\n",
                $ex1->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "ticket_result" => null
            ];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "TicketModel::listTemporaryTickets(backoffice_session_id={$backoffice_session_id}) <br />\n\n",
                "tomboladb.tombola.list_all_temp_tickets(:p_session_id_in = {$backoffice_session_id}, 'cur_result_out') <br />\n\n",
                $ex2->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "ticket_result" => null
            ];
        }
    }

    /**
     * @param $backoffice_session_id
     * @param $ticket_draw_id
     * @param $ticket_barcode
     * @param $player_name
     * @param $cashier_name
     * @param $start_date
     * @param $end_date
     * @param $ticket_status
     * @param $ticket_id
     * @return array
     */
    public static function searchTickets($backoffice_session_id, $ticket_draw_id = null, $ticket_barcode = null,
      $player_name = null, $cashier_name = null, $start_date = null, $end_date = null, $ticket_status = null, $ticket_id = null
    ){
        if(self::$DEBUG){
            $message = "TicketModel::searchTickets >>> SELECT tomboladb.tombola.search_tickets(:p_session_id_in = {$backoffice_session_id},
              :p_ticket_serial_number = {$ticket_id}, :p_draw_serial_number = {$ticket_draw_id}, :p_ticket_barcode = {$ticket_barcode}, :p_player_name = {$player_name}, :p_cashier_name = {$cashier_name},
              :p_start_date = {$start_date}, :p_end_date = {$end_date}, :p_ticket_status = {$ticket_status}, 'cur_result_out')";
            ErrorHelper::writeInfo($message, $message);
        }
       try{
            DB::connection('pgsql')->beginTransaction();
            $statement_string = 'SELECT * from tomboladb.tombola.search_tickets(:p_session_id_in, :p_ticket_serial_number, :p_draw_serial_number, :p_ticket_barcode, :p_player_name, :p_cashier_name, :p_start_date, :p_end_date, :p_ticket_status)';

            $fn_result = DB::connection('pgsql')->select($statement_string,
                array(
                    'p_session_id_in' => $backoffice_session_id,
                    'p_ticket_serial_number' => $ticket_id,
                    'p_draw_serial_number' => $ticket_draw_id,
                    'p_ticket_barcode' => $ticket_barcode,
                    'p_player_name' => $player_name,
                    'p_cashier_name' => $cashier_name,
                    'p_start_date' => $start_date,
                    'p_end_date' => $end_date,
                    'p_ticket_status' => $ticket_status,
                )
            );
            $cursor_name = $fn_result[0]->cur_result_out;

            $cur_result = DB::connection('pgsql')->select("fetch all in {$cursor_name}");

            DB::connection('pgsql')->commit();

            return [
                "status" => "OK",
                "ticket_result"=>$cur_result
            ];
        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "TicketModel::searchTickets(backoffice_session_id={$backoffice_session_id}, ticket_draw_id={$ticket_draw_id}, ticket_barcode={$ticket_barcode},
                  player_name={$player_name}, cashier_name={$cashier_name}, start_date={$start_date}, end_date={$end_date}, ticket_status={$ticket_status}, ticket_id={$ticket_id} ) <br />\n\n",
                "tomboladb.tombola.search_tickets(:p_session_id_in = {$backoffice_session_id},
                :p_ticket_serial_number = {$ticket_id}, :p_draw_serial_number = {$ticket_draw_id}, :p_ticket_barcode = {$ticket_barcode}, :p_player_name = {$player_name}, :p_cashier_name = {$cashier_name},
                :p_start_date = {$start_date}, :p_end_date = {$end_date}, :p_ticket_status = {$ticket_status}, 'cur_result_out') <br />\n\n",
                $ex1->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "ticket_result" => null
            ];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "TicketModel::searchTickets(backoffice_session_id={$backoffice_session_id}, ticket_draw_id={$ticket_draw_id}, ticket_barcode={$ticket_barcode},
                  player_name={$player_name}, cashier_name={$cashier_name}, start_date={$start_date}, end_date={$end_date}, ticket_status={$ticket_status}, ticket_id={$ticket_id} ) <br />\n\n",
                "tomboladb.tombola.search_tickets(:p_session_id_in = {$backoffice_session_id},
                :p_ticket_serial_number = {$ticket_id}, :p_draw_serial_number = {$ticket_draw_id}, :p_ticket_barcode = {$ticket_barcode}, :p_player_name = {$player_name}, :p_cashier_name = {$cashier_name},
                :p_start_date = {$start_date}, :p_end_date = {$end_date}, :p_ticket_status = {$ticket_status}, 'cur_result_out') <br />\n\n",
                $ex2->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "ticket_result" => null
            ];
        }
    }

    /**
     * @param $backoffice_session_id
     * @return array
     */
    public static function listTicketStatuses($backoffice_session_id){
        try{

            if(self::$DEBUG){
                $message = "TicketModel::listTicketStatuses(backoffice_session_id = {$backoffice_session_id}) >>> SELECT core.list_ticket_statuses('cur_result_out')";
                ErrorHelper::writeInfo($message, $message);
            }

            DB::connection('pgsql')->beginTransaction();
            $statement_string = "SELECT * from core.list_ticket_statuses( )";

            $fn_result = DB::connection('pgsql')->select($statement_string);
            $cursor_name = $fn_result[0]->cur_result_out;

            $cur_result = DB::connection('pgsql')->select("fetch all in {$cursor_name}");

            DB::connection('pgsql')->commit();

            return [
                "status" => "OK",
                "ticket_statuses"=>$cur_result
            ];
        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "TicketModel::listTicketStatuses(backoffice_session_id={$backoffice_session_id}) <br />\n\n",
                "core.list_ticket_statuses( ) <br />\n\n",
                $ex1->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "ticket_statuses" => null
            ];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "TicketModel::listTicketStatuses(backoffice_session_id={$backoffice_session_id}) <br />\n\n",
                "core.list_ticket_statuses( ) <br />\n\n",
                $ex2->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "ticket_statuses" => null
            ];
        }
    }
	
	/**
     * @param $backoffice_session_id
     * @param $ticket_id
     * @return array
     */
    public static function temporaryToRealTicket($backoffice_session_id, $ticket_id){
        try{

            if(self::$DEBUG){
                $message = "TicketModel::temporaryToRealTicket >>> select tomboladb.tombola.temp_to_real(:p_session_id = {$backoffice_session_id}, :p_temp_order_number_in = {$ticket_id})";
                ErrorHelper::writeInfo($message, $message);
            }

            DB::connection('pgsql')->beginTransaction();
            $statement_string = 'SELECT * from tomboladb.tombola.temp_to_real(:p_session_id, :p_temp_order_number_in)';

            $fn_result = DB::connection('pgsql')->select($statement_string,
                array(
                    'p_session_id' => $backoffice_session_id,
                    'p_temp_order_number_in'=>$ticket_id
                )
            );

            DB::connection('pgsql')->commit();

            return [
                "status" => "OK"                
            ];
        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "TicketModel::temporaryToRealTicket(backoffice_session_id={$backoffice_session_id}, ticket_id={$ticket_id}) <br />\n\n",
                "tomboladb.tombola.temp_to_real(:p_session_id = {$backoffice_session_id}, :p_temp_order_number_in = {$ticket_id}) <br />\n\n",
                $ex1->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK"
            ];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "TicketModel::temporaryToRealTicket(backoffice_session_id={$backoffice_session_id}, ticket_id={$ticket_id}) <br />\n\n",
                "tomboladb.tombola.temp_to_real(:p_session_id = {$backoffice_session_id}, :p_temp_order_number_in = {$ticket_id}) <br />\n\n",
                $ex2->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK"
            ];
        }
    }
	
	/**
     * @param $backoffice_session_id
     * @param $ticket_id
     * @return array
     */
    public static function ticketDetails($backoffice_session_id, $ticket_id){
        try{

            if(self::$DEBUG){
                $message = "TicketModel::ticketDetails >>> SELECT tomboladb.tombola.get_ticket_details(:p_session_id = {$backoffice_session_id}, :p_ticket_id_in = {$ticket_id}, 'cur_result_out', 'cur_combinations_out')";
                ErrorHelper::writeInfo($message, $message);
            }

            DB::connection('pgsql')->beginTransaction();
            $statement_string = 'SELECT * from tomboladb.tombola.get_ticket_details(:p_session_id, :p_ticket_id_in)';

            $fn_result = DB::connection('pgsql')->select($statement_string,
                array(
                    'p_session_id'=>$backoffice_session_id,
                    'p_ticket_id_in'=>$ticket_id
                )
            );

            $cursor_name1 = $fn_result[0]->cur_result_out;
            $cur_result1 = DB::connection('pgsql')->select("fetch all in {$cursor_name1}");

            $cursor_name2 = $fn_result[0]->cur_combinations_out;
            $cur_result2 = DB::connection('pgsql')->select("fetch all in {$cursor_name2}");

            DB::connection('pgsql')->commit();

            return [
                "status" => "OK",
                "ticket_result"=>$cur_result1,
                "combinations_result"=>$cur_result2
            ];
        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "TicketModel::ticketDetails(backoffice_session_id={$backoffice_session_id}, ticket_id={$ticket_id}) <br />\n\n",
                "tomboladb.tombola.get_ticket_details(:p_session_id = {$backoffice_session_id}, :p_ticket_id_in = {$ticket_id}, 'cur_result_out', 'cur_combinations_out') <br />\n\n",
                $ex1->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK"
            ];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "TicketModel::ticketDetails(backoffice_session_id={$backoffice_session_id}, ticket_id={$ticket_id}) <br />\n\n",
                "tomboladb.tombola.get_ticket_details(:p_session_id = {$backoffice_session_id}, :p_ticket_id_in = {$ticket_id}, 'cur_result_out', 'cur_combinations_out') <br />\n\n",
                $ex2->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK"
            ];
        }
    }
	
	/**
     * @param $backoffice_session_id
     * @return array
     */
    public static function listWinsForTicket($backoffice_session_id, $ticket_id) {
        try{

            if(self::$DEBUG){
                $message = "TicketModel::listWinsForTicket(backoffice_session_id = {$backoffice_session_id}, ticket_id = {$ticket_id}) >>> SELECT tombola.list_wins_for_ticket(:p_ticket_id_in = {$ticket_id}, 'cur_result_out')";
                ErrorHelper::writeInfo($message, $message);
            }

            DB::connection('pgsql')->beginTransaction();
            $statement_string = "SELECT * from tombola.list_wins_for_ticket(:p_ticket_id_in)";

            $fn_result = DB::connection('pgsql')->select($statement_string,
				array(
                    'p_ticket_id_in'=>$ticket_id
                )
			);
            $cursor_name = $fn_result[0]->cur_result_out;

            $cur_result = DB::connection('pgsql')->select("fetch all in {$cursor_name}");

            DB::connection('pgsql')->commit();

            return [
                "status" => "OK",
                "list_wins_for_ticket"=>$cur_result
            ];
        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "TicketModel::listWinsForTicket(backoffice_session_id={$backoffice_session_id}, ticket_id={$ticket_id}) <br />\n\n",
                "tombola.list_wins_for_ticket(:p_ticket_id_in = {$ticket_id}, 'cur_result_out') <br />\n\n",
                $ex1->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "list_wins_for_ticket" => null
            ];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "TicketModel::listWinsForTicket(backoffice_session_id={$backoffice_session_id}, ticket_id={$ticket_id}) <br />\n\n",
                "tombola.list_wins_for_ticket(:p_ticket_id_in = {$ticket_id}, 'cur_result_out') <br />\n\n",
                $ex2->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK",
                "list_wins_for_ticket" => null
            ];
        }
    }

    public static function checkPreferredButtonVisibility($backoffice_session_id, $logged_user_id, $affiliate_id, $barcode){
        try{

            if(self::$DEBUG){
                $message = "TicketModel::checkPreferredButtonVisibility(backoffice_session_id = {$backoffice_session_id}, logged_user_id = {$logged_user_id}, affiliate_id = {$affiliate_id}, barcode = {$barcode}) >>> 
                tomboladb.core.get_preferred_btn_visibility(:p_session_id = {$backoffice_session_id}, :p_logged_in_subject_id = {$logged_user_id}, :p_aff_id = {$affiliate_id}, :p_barcode = {$barcode}, :p_enabled_preferred_button_out)";
                ErrorHelper::writeInfo($message, $message);
            }

            DB::connection('pgsql')->beginTransaction();
            $statement_string = 'SELECT * from tomboladb.core.get_preferred_btn_visibility(:p_session_id, :p_logged_in_subject_id, :p_aff_id, :p_barcode)';

            $fn_result = DB::connection('pgsql')->select($statement_string,
                array(
                    'p_session_id' => $backoffice_session_id,
                    'p_logged_in_subject_id' => $logged_user_id,
                    'p_aff_id' => $affiliate_id,
                    'p_barcode' => $barcode,
                )
            );

            DB::connection('pgsql')->commit();

            return [
                "status" => "OK",
                "enabled_preferred_button_out" => $fn_result[0]->p_enable_preferred_button_out,
            ];
        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "TicketModel::checkPreferredButtonVisibility(backoffice_session_id = {$backoffice_session_id}, logged_user_id = {$logged_user_id}, affiliate_id = {$affiliate_id}, barcode = {$barcode}) <br />\n\n",
                "tomboladb.core.get_preferred_btn_visibility(:p_session_id = {$backoffice_session_id}, :p_logged_in_subject_id = {$logged_user_id}, :p_aff_id = {$affiliate_id}, :p_barcode = {$barcode}, :p_enabled_preferred_button_out) <br />\n\n",
                $ex1->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK"
            ];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "TicketModel::checkPreferredButtonVisibility(backoffice_session_id = {$backoffice_session_id}, logged_user_id = {$logged_user_id}, affiliate_id = {$affiliate_id}, barcode = {$barcode}) <br />\n\n",
                "tomboladb.core.get_preferred_btn_visibility(:p_session_id = {$backoffice_session_id}, :p_logged_in_subject_id = {$logged_user_id}, :p_aff_id = {$affiliate_id}, :p_barcode = {$barcode}, :p_enabled_preferred_button_out) <br />\n\n",
                $ex2->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK"
            ];
        }
    }

    public static function setPreferredTicket($backoffice_session_id, $logged_user_id, $affiliate_id, $barcode, $preferred_value){
        try{

            if(self::$DEBUG){
                $message = "TicketModel::setPreferredTicket(backoffice_session_id = {$backoffice_session_id}, logged_user_id = {$logged_user_id}, affiliate_id = {$affiliate_id}, barcode = {$barcode}, preferred_value = {$preferred_value}) >>> 
                tomboladb.core.set_preferred_ticket(:p_session_id = {$backoffice_session_id}, :p_logged_in_subject_id = {$logged_user_id}, :p_aff_id = {$affiliate_id}, :p_barcode = {$barcode}, :p_preferred_value = {$preferred_value}, :p_draw_id, :p_status_out)";
                ErrorHelper::writeInfo($message, $message);
            }

            DB::connection('pgsql')->beginTransaction();
            $statement_string = 'SELECT * from tomboladb.core.set_preferred_ticket(:p_session_id, :p_logged_in_subject_id, :p_aff_id, :p_barcode, :p_preferred_value)';

            $fn_result = DB::connection('pgsql')->select($statement_string,
                array(
                    'p_session_id' => $backoffice_session_id,
                    'p_logged_in_subject_id' => $logged_user_id,
                    'p_aff_id' => $affiliate_id,
                    'p_barcode' => $barcode,
                    'p_preferred_value' => $preferred_value
                )
            );

            DB::connection('pgsql')->commit();

            return [
                "status" => "OK",
                "draw_id_out" => $fn_result[0]->p_draw_id,
                "status_out" => $fn_result[0]->p_status_out,
            ];
        }catch(\PDOException $ex1){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "TicketModel::setPreferredTicket(backoffice_session_id = {$backoffice_session_id}, logged_user_id = {$logged_user_id}, affiliate_id = {$affiliate_id}, barcode = {$barcode}, preferred_value = {$preferred_value}) <br />\n\n",
                "tomboladb.core.set_preferred_ticket(:p_session_id = {$backoffice_session_id}, :p_logged_in_subject_id = {$logged_user_id}, :p_aff_id = {$affiliate_id}, :p_barcode = {$barcode}, :p_preferred_value = {$preferred_value}, :p_draw_id, :p_status_out) <br />\n\n",
                $ex1->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK"
            ];
        }catch(\Exception $ex2){
            DB::connection('pgsql')->rollBack();
            $message = implode(" ", [
                "TicketModel::setPreferredTicket(backoffice_session_id = {$backoffice_session_id}, logged_user_id = {$logged_user_id}, affiliate_id = {$affiliate_id}, barcode = {$barcode}, preferred_value = {$preferred_value}) <br />\n\n",
                "tomboladb.core.set_preferred_ticket(:p_session_id = {$backoffice_session_id}, :p_logged_in_subject_id = {$logged_user_id}, :p_aff_id = {$affiliate_id}, :p_barcode = {$barcode}, :p_preferred_value = {$preferred_value}, :p_draw_id, :p_status_out) <br />\n\n",
                $ex2->getMessage(),
            ]);
            ErrorHelper::writeError($message, $message);
            return [
                "status" => "NOK"
            ];
        }
    }
}
