<?php

namespace Publisher\Entry\Xing;

use Publisher\Entry\AbstractEntry;
use Publisher\Helper\Validator;

/**
 * @link https://dev.xing.com/docs/post/users/:id/status_message
 * 
 * Publish will return "Status update has been posted" it was successful.
 */
class XingUserEntry extends AbstractEntry
{
    
    // source: html source code
    const MAX_LENGTH_OF_MESSAGE = 420;
    
    protected function defineRequestProperties()
    {
        $this->request->setPath('/users/me/status_message');
        $this->request->setMethod('POST');
    }
    
    protected function validateBody(array $body)
    {
        Validator::checkRequiredParametersAreSet(
                $body,
                array('message')
        );
        Validator::validateMessageLength(
                $body['message'],
                self::MAX_LENGTH_OF_MESSAGE
        );
    }
    
    // Implementation of MonitoredInterface
    
    public static function succeeded($response)
    {
        return ($response === 'Status update has been posted');
    }
    
}