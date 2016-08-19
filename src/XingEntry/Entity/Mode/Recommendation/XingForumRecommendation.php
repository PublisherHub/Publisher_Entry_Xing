<?php

namespace Publisher\Entry\Xing\Entity\Mode\Recommendation;

use Publisher\Mode\Recommendation\Entity\AbstractRecommendation;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Publisher\Entry\Xing\XingForumEntry;

class XingForumRecommendation extends AbstractRecommendation
{
    
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        parent::loadValidatorMetadata($metadata);
        parent::addDefaultConstraints($metadata);
        parent::addScheduleNotSupportedConstraint($metadata);
        // a post in a XING forum requires a title 
        $metadata->addPropertyConstraint('title', new Assert\NotBlank());
    }
    
    /**
     * @{inheritdoc}
     */
    public function validateMessageLength(
        ExecutionContextInterface $context,
        $payload
    ) {
        parent::validateMessageLength($context, $payload);
        
        $max = XingForumEntry::MAX_LENGTH_OF_TITLE;
        
        if (strlen($this->title) > $max) {
            $context
                ->buildViolation("Title shouldn't exceed $max characters.")
                ->atPath('title')
                ->addViolation();
        }
    }
    
    protected function getMaxLengthViolationMessage(int $max)
    {
        return "Message and URL combined shouldn't exceed $max characters.";
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