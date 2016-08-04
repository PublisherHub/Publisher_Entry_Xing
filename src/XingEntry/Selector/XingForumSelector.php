<?php

namespace Publisher\Entry\Xing\Selector;

use Publisher\Selector\Parameter\AbstractSelector;
use Publisher\Requestor\Request;

use Publisher\Selector\Selection;

class XingForumSelector extends AbstractSelector
{
    
    public function getParameters()
    {
        if ($this->isParameterMissing()) {
            return null;
        } else {
            return array('forum_id' => $this->results['forum_id']);
        }
    }
    
    public function isParameterMissing()
    {
        return (!isset($this->results['forum_id']));
    }
    
    protected function defineSteps()
    {
        $this->steps[0] = function (array $results) {
            return new Request('/users/me/groups', 'GET');
        };
        $this->steps[1] = function (array $results) {
            return new Request('/groups/'.$results["group_id"].'/forums', 'GET');
        };
    }
    
    protected function matchParameter(array $choices)
    {
        if (isset($choices['group_id'])) {
            $this->setResult(0, 'group_id', $choices['group_id']);
        }
        if (isset($choices['forum_id'])) {
            $this->setResult(1, 'forum_id', $choices['forum_id']);
        }
    }
    
    protected function saveResult(int $stepId, string $response)
    {
        switch ($stepId) {
            case 0:
                $this->saveGroups($response);
                break;
            case 1:
                $this->saveForums($response);
                break;
        }
        $this->updateSelections();
    }
    
    protected function saveGroups(string $response)
    {
        $choices = $this->parseResponseForChoices($response, 'groups');
        $this->selections[0] = new Selection('group_id', $choices);
    }
    
    protected function saveForums(string $response)
    {
        $choices = $this->parseResponseForChoices($response, 'forums');
        $this->selections[1] = new Selection('forum_id', $choices);
    }
    
    protected function parseResponseForChoices(string $response, string $type)
    {
        $set = json_decode($response);
        
        $choices = array();
        foreach ($set->$type->items as $object) {
            $choices[$object->name] = $object->id;
        }
        return $choices;
    }
    
}

