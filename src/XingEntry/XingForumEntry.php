<?php

namespace Publisher\Entry\Xing;

use Publisher\Entry\AbstractEntry;
use Publisher\Mode\Recommendation\RecommendationInterface;
use Publisher\Helper\Validator;

/**
 * @link https://dev.xing.com/docs/post/groups/forums/:forum_id/posts
 */
class XingForumEntry extends AbstractEntry implements RecommendationInterface
{
    
    const MAX_LENGTH_OF_MESSAGE = 420;
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
    
    // Implementation of RecommendationInterface
    
    public function setRecommendationParameters(
        string $message,
        string $url = '',
        string $title = '',
        int $date = null
    ) {
        $body = array();
        $body['title'] = $title;
        
        $body['content'] = empty($url) ? $message : $message."\n".$url;
        
        $this->setBody($body);
    }
    
}