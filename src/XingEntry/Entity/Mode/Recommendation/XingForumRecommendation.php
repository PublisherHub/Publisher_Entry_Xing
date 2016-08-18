<?php

namespace Publisher\Entry\Xing\Entity\Mode\Recommendation;

use Publisher\Mode\Recommendation\Entity\AbstractRecommendation;
use Publisher\Entry\Xing\XingForumEntry;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class XingForumRecommendation extends AbstractRecommendation
{
    
    /**
     * @{inheritdoc}
     */
    public function validateMessageLength(
        ExecutionContextInterface $context,
        $payload
    ) {
        // maximum, allowed number of characters
        $max = $this->getMaxLengthOfMessage();
        
        $message = $this->createCompleteMessage();
        
        if (strlen($message) > $max) {
            $context
                ->buildViolation("Message and URL combined shouldn't exceed $max characters.")
                ->atPath('message')
                ->addViolation();
        }
        
        $max = XingForumEntry::MAX_LENGTH_OF_TITLE;
        
        if (strlen('title') > $max) {
            $context
                ->buildViolation("Title shouldn't exceed $max characters.")
                ->atPath('title')
                ->addViolation();
        }
    }
    
    /**
     * @{inheritdoc}
     */
    protected function getMaxLengthOfMessage()
    {
        return XingForumEntry::MAX_LENGTH_OF_MESSAGE;
    }
    
    /**
     * @{inheritdoc}
     */
    protected function createCompleteMessage()
    {
        $fullMessage = empty($this->url) ? $this->message : $this->message."\n".$this->url;
        
        return $fullMessage;
    }
    
}