# This applications is from symfony 6.0 and above, it uses "ramsey/uuid": ">=4.0", and "symfony/monolog-bundle": ">=3.7" to add uuid as colleration_id to request logs if not found using CorrelationIdProcessor.php class and forward this correlation_id to headers using CorrelationIdResponseListener class  
# configure service to add correlation-id in services.yaml
services:
    Felixaa\Logger\EventListener\CorrelationIdResponseListener:
        arguments: ["@request_stack"]
        tags:
            - {name: kernel.event_listener, event: kernel.response, method: onKernelResponse }
 
    Felixaa\Logger\Processor\CorrelationIdProcessor:
        arguments: ["@request_stack"]
        tags:
            - { name: monolog.processor, method: __invoke }
            
            
# Configure service to add enviroment variables 
