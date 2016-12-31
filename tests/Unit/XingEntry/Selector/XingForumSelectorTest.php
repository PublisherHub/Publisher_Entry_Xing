<?php

namespace Unit\XingEntry\Selector;

use Unit\Publisher\Selector\Parameter\AbstractSelectorTest;
use Publisher\Entry\Xing\Selector\XingForumSelector;
use Publisher\Requestor\RequestorInterface;
use Publisher\Storage\StorageInterface;

class XingForumSelectorTest extends AbstractSelectorTest
{
    
    public function getFinalState()
    {
        $choices = array('group_id' => '123', 'forum_id' => '321');
        $parameters = array('forum_id' => '321');
        
        return array(array($choices, $parameters));
    }
    
    /**
     * @runInSeparateProcess
     */
    public function testAddGroupSelection()
    {
        $selections = $this->getUpdatedSelection(
            array(),
            $this->getShortenedResponseData('groups')
        );
        
        $expectedChoices = array('foo' => '123', 'bar' => '321');
        
        $this->assertTrue(isset($selections[0]));
        $this->assertEquals('group_id', $selections[0]->getName());
        $this->assertEquals($expectedChoices, $selections[0]->getChoices());
        $this->assertTrue($this->selector->isParameterMissing());
    }
    
    /**
     * @runInSeparateProcess
     */
    public function testAddForumSelections()
    {
        $selections = $this->getUpdatedSelection(
            array('group_id' => '123'),
            $this->getShortenedResponseData('forums')
        );
        
        $expectedChoices = array('foo' => '123', 'bar' => '321');
        
        $this->assertTrue(isset($selections[1]));
        $this->assertEquals('forum_id', $selections[1]->getName());
        $this->assertEquals($expectedChoices, $selections[1]->getChoices());
        $this->assertTrue($this->selector->isParameterMissing());
    }
    
    protected function getShortenedResponseData(string $type)
    {
        $response = array(
            $type => array(
                'items' => array(
                    array('id' => '123', 'name' => 'foo'),
                    array('id' => '321', 'name' => 'bar')
                )
            )
        );
        
        return json_encode($response);
    }
    
    protected function getSelector(
        RequestorInterface $requestor,
        StorageInterface $storage
    ) {
        return new XingForumSelector($requestor, $storage);
    }
    
}