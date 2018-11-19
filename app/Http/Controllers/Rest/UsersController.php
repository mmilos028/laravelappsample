<?php

namespace App\Http\Controllers\Rest;

use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

use App\Models\Postgres\AuthUserModel;

class UsersController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    public function listUsers()
    {
        try {
            $result = AuthUserModel::listAllUsers();
            return response()->json([
                "status" => "OK",
                "users" => $result
            ]);
        }catch(QueryException $ex1){
            return view("/auth/login")
            ->with("error_message", "QueryException: " . $ex1->getMessage());
        }catch(\PDOException $ex2){
            return view("/auth/login")
            ->with("error_message", "PDOException: " . $ex2->getMessage());
        }catch(\RuntimeException $ex3){
            return view("/auth/login")
            ->with("error_message", "RuntimeException: " . $ex3->getMessage());
        }catch(\Exception $ex4){
            return view("/auth/login")
            ->with("error_message", "Exception: " . $ex4->getMessage());
        }
    }
}
