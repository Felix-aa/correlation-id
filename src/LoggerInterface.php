<?php 

namespace Felixaa\Logger;

interface LoggerInterface
{
    /**
     * Defined fields for enhanced logging
     * see https://maviance.atlassian.net/wiki/spaces/SET/pages/2695004187/1002+-+Enhance+Logging+in+Smobilpay+related+applications
     * 
     * 
     */
    const TIMESTAMP        = 'timestamp';
    const ENVIROMENT       = 'environment';
    const BUSINESS_ID      = 'business_id';
    const EVENT_OWNER      = 'event_owner'; 
    const PROCESS          = 'process';
    const SUB_PROCESS      = 'sub_process';
    const COMPONENT        = 'component';
    const CORRELATION_ID   = 'cid';
    const PROCESSED_OBJECT = 'processed_object';
    const STATUS           = 'status';
    const RESULT           = 'result';
    const ERROR_MESSAGE    = 'error_message';
    const ERROR_CODE       = 'error_code';
    const API_ENDPOINT     = 'api_endpoint';
    const API_METHOD       = 'api_method';
    const CLIENT_IP        = 'client_ip';
    const API_VERSION      = 'api_version';
    const PAYLOAD          = 'payload';
    const HOSTNAME         = 'hostname';
    const MAVIANCE_CORRELATION_ID = 'x-correlation-id';


    public function  __invoke(array $record): array;


}

