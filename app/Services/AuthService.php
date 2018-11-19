<?php

namespace App\Services;

use App\Models\Postgres\AuthModel;

/**
 * Class AuthService
 * @package App\Services
 */
class AuthService
{

    /****
     * XML
     * Request example:
     * <?xml version="1.0" encoding="UTF-8" ?>
        <request>
          <operation>login</operation>
          <username>slavka</username>
          <password>slavka</password>
        </request>
     *
     * Response example:
     * <?xml version="1.0" encoding="UTF-8" ?>
        <response>
            <status>OK</status>
            <operation>login</operation>
            <session_id>151</session_id>
            <status_out>1</status_out>
        </response>
     */
    /**
     * @param $phpObject
     * @return array
     */
    public static function loginSubject($phpObject){
        $result = AuthModel::loginSubject($phpObject->username, $phpObject->password);

        return array(
            "status" => $result['status'],
            "operation" => $phpObject->operation,
            "session_id"=>$result['session_id'],
            "status_out"=>$result['status_out'],
        );
    }

    /***
     * XML
     * Request example:
     * <?xml version="1.0" encoding="UTF-8" ?>
        <request>
          <operation>logout</operation>
          <session_id>151</session_id>
        </request>
     *
     * Response example:
     * <?xml version="1.0" encoding="UTF-8" ?>
        <response>
            <status>OK</status>
            <operation>logout</operation>
            <status_out>1</status_out>
        </response>
     */
    /**
     * @param $phpObject
     * @return array
     */
    public static function logoutSubject($phpObject){
        $result = AuthModel::logoutSubject($phpObject->session_id);

        return array(
            "status" => $result['status'],
            "operation" => $phpObject->operation,
            "status_out"=>$result['status_out'],
        );
    }

}
