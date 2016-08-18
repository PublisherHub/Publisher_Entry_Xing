<?php

namespace Unit\Publisher\Entry\Xing\Entity\Mode\Recommendation;

use Unit\Publisher\Mode\Recommendation\Entity\AbstractRecommendationTest;
use Publisher\Entry\Xing\Entity\Mode\Recommendation\XingForumRecommendation;
use Publisher\Entry\Xing\XingForumEntry;

class XingForumRecommendationTest extends AbstractRecommendationTest
{
    
    public function getValidData()
    {
        return array(
            array(
                array(
                    'message' => "abcdefghijklmnopqrstToday Unit 123",
                    'title' => "Today Unit 123",
                    'url' => 'http://www.example.com',
                    'date' => null
                )
            ),
            array(// test special characters
                array(
                    'message' => "#@><´'°~!§%&ßöäüÄÜÖµ\"+-*^$/(\\)=}{[]",
                    'title' => "#@><´'°~!?§%&ßöäüÄÜÖµ\"+-*^$/(\\)=}{[]",
                    'url' => '',
                    'date' => null
                )
            )
        );
    }
    
    public function getInvalidData()
    {
        return array(
            array(// invalid since Xing doesn't support sheduled publishing per API
                array(
                    'message' => "Today Unit 123",
                    'title' => "Testing",
                    'url' => 'http://www.example.com',
                    'date' => 946684800 // invalid
                ),
                1
            )
        );
    }
    
    public function getExeecedMessageData()
    {
        $url = 'http://www.example.com'; // 22 characters
        
        /* 
         * Characters arrangement:
         * 22 for url
         * 1 for break between message and url
         */
        $messageLength = XingForumEntry::MAX_LENGTH_OF_MESSAGE - 22 - 1;
        $message = '';
        //add one additional character so we exceed maximum message length
        for ($i = 0; $i < $messageLength+1; $i++) {
            $message .= 'c';
        }
        
        $title = '';
        //add one additional character so we exceed maximum title length
        for ($i = 0; $i < XingForumEntry::MAX_LENGTH_OF_TITLE+1; $i++) {
            $title .= 'c';
        }
        
        return array(
            array(
                array(
                    'message' => $message,
                    'title' => $title,
                    'url' => $url,
                    'date' => null
                )
            ),
            array(
                array( 
                    'message' => $message.'b'.$url, // .'b' => combining break
                    'title' => $title,
                    'url' => '',
                    'date' => null
                )
            )
        );
    }
    
    /**
     * @return AbstractRecommendation
     */
    protected function createRecommendation()
    {
        return new XingForumRecommendation();
    }
    
}