<?php

namespace Publisher\Entry\Xing\Entity\Mode\Recommendation;

use Publisher\Mode\Recommendation\Entity\AbstractRecommendation;
use Publisher\Entry\Xing\XingUserEntry;

class XingUserRecommendation extends AbstractRecommendation
{
    
    /**
     * @{inheritdoc}
     */
    protected function getMaxLengthOfMessage()
    {
        return XingUserEntry::MAX_LENGTH_OF_MESSAGE;
    }
    
    /**
     * @{inheritdoc}
     */
    protected function createCompleteMessage()
    {
        $fullMessage = empty($this->title) ? $this->message : $this->title."\n".$this->message;
        $fullMessage .= empty($this->url) ? '' : "\n".$this->url;
        
        return $fullMessage;
    }
    
}