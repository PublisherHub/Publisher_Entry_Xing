<?php

namespace Unit\XingEntry;

use Unit\Publisher\Entry\EntryTest;

class XingForumEntryTest extends EntryTest
{
    
    protected function getEntryName()
    {
        return 'Publisher\\Entry\\Xing\\XingForumEntry';
    }
    
    public function getValidBody()
    {
        $return = array(
            array(array('content' => 'foo', 'title' => 'bar')),
            array(array('content' => 'foo', 'title' => 'bar'))
        );
        
        $types = array('jpeg', 'png', 'gif', 'bmp');
        foreach ($types as $type) {
            $return[] = array(
                array(
                    'content' => 'foo',
                    'title' => 'bar',
                    'image' => array(
                        'file_name' => 'foo',
                        'mime_type' => 'image/'.$type,
                        'content' => 'foo'
                    )
                )
            );
        }
        
        // add required parameters
        $parameters = $this->getParameters();
        for($i = 0; $i < count($return); $i++) {
            $return[$i][] = $parameters;
        }
        
        return $return;
    }
    
    public function getInvalidBody()
    {
        return array(
            array(array()),
            array(array('notRequired' => 'foo')),
            array(array('content' => 'foo')),
            array(array('title' => 'bar')),
            array(array('content' => 'foo', 'title' => 'bar')),
            array(
                array('content' => 'foo', 'title' => 'bar', 'image' => array()),
                $this->getParameters()
            )
        );
    }
    
    public function getBodyWithExceededMessage()
    {
        return array(
            array(
                array('content' => $this->getExceededMessage(), 'title' => 'bar'),
                $this->getParameters()
            )
        );
    }
    
    public function testAddForumIdToPath()
    {
        $parameters = array('forum_id' => 'foo');
        $body = array('content' => 'something', 'title' => 'News');
        
        $this->entry = $this->getEntry($body, $parameters);
        
        $this->assertEquals(
                '/groups/forums/foo/posts',
                $this->entry->getRequest()->getPath()
        );
    }
    
    protected function getParameters()
    {
        return array('forum_id' => 'foo');
    }
}

