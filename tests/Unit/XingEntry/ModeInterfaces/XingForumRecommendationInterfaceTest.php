<?php

namespace Unit\XingEntry\ModeInterfaces;

use Unit\Publisher\Mode\Recommendation\RecommendationInterfaceTest;

class XingForumRecommendationInterfaceTest extends RecommendationInterfaceTest
{
    
    public function getEntry(array $parameters = array('forum_id' => 'foo'))
    {
        return parent::getEntry($parameters);
    }
    
    protected function getEntryName()
    {
        return 'Publisher\\Entry\\Xing\\XingForumEntry';
    }
    
    public function getValidRecommendationParameters()
    {
        return array(
            array('message', '', 'title', null),
            array('message', 'url@foo.com', 'title', time() + (0 * 0 * 10 * 0))
        );
    }
    
    public function getRecommendationParametersAndResult()
    {
        return array(
            array(
                'message',
                'url@foo.com',
                'title',
                time() + (0 * 0 * 10 * 0),
                array(
                    'content' => "message\nurl@foo.com",
                    'title' => 'title'
                )
            )
        );
    }
}

