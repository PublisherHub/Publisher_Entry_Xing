<?php

namespace Unit\XingEntry;

use Unit\Publisher\Entry\EntryTest;

class XingUserEntryTest extends EntryTest
{
    
    protected function getEntryClass()
    {
        return 'Publisher\\Entry\\Xing\\XingUserEntry';
    }
    
    public function getValidBody()
    {
        return array(
            array(array('message' => 'foo'))
        );
    }
    
    public function getInvalidBody()
    {
        return array(
            array(array()),
            array(array('notRequired' => 'foo'))
        );
    }
    
    public function getBodyWithExceededMessage()
    {
        return array(
            array(array('message' => $this->getExceededMessage()))
        );
    }
    
}