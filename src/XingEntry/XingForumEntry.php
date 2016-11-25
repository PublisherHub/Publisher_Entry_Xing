<?php

namespace Publisher\Entry\Xing;

use Publisher\Entry\AbstractEntry;
use Publisher\Helper\Validator;

/**
 * @link https://dev.xing.com/docs/post/groups/forums/:forum_id/posts
 */
class XingForumEntry extends AbstractEntry
{
    
    // source: html source code
    const MAX_LENGTH_OF_TITLE = 254;
    // source: html source code
    const MAX_LENGTH_OF_MESSAGE = 9999;
    
    static $validImageMimeTypes = array(
        'image/jpeg',
        'image/png',
        'image/gif',
        'image/bmp'
    );
    
    protected function defineRequestProperties()
    {
        $this->request->setPath('/groups/forums/?/posts');
        $this->request->setMethod('POST');
    }
    
    protected function setParameters(array $parameters)
    {
        Validator::checkRequiredParametersAreSet(
                $parameters,
                array('forum_id')
        );
        $this->addForumIdToPath($parameters['forum_id']);
    }
    
    protected function addForumIdToPath($forumId)
    {
        $incompletePath = $this->request->getPath();
        $path = preg_replace('/(\?)/', $forumId, $incompletePath);
        $this->request->setPath($path);
    }
    
    protected function validateBody(array $body)
    {
        Validator::checkRequiredParametersAreSet(
            $body,
            array('content', 'title')
        );
        
        if (isset($body['image'])) {
            Validator::checkRequiredParametersAreSet(
                $body['image'],
                array('file_name', 'mime_type', 'content')
            );
            Validator::validateValue(
                $body['image']['mime_type'],
                self::$validImageMimeTypes
            );
        }
        
        Validator::validateMessageLength(
            $body['title'],
            self::MAX_LENGTH_OF_TITLE
        );
        
        Validator::validateMessageLength(
            $body['content'],
            self::MAX_LENGTH_OF_MESSAGE
        );
    }
    
    // Implementation of MonitoredInterface
    
    public static function succeeded($response)
    {
        $object = json_decode($response);
        return (isset($object->id));
    }
    
}