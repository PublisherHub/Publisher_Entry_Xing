<?php

namespace Publisher\Entry\Xing\Entity\Mode\Recommendation;

use Publisher\Mode\Recommendation\Entity\AbstractRecommendation;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Publisher\Entry\Xing\XingUserEntry;

class XingUserRecommendation extends AbstractRecommendation
{
    
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        parent::loadValidatorMetadata($metadata);
        parent::addDefaultConstraints($metadata);
        parent::addScheduleNotSupportedConstraint($metadata);
    }
    
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