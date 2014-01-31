<?php

class ReallySimpleIssueTracker_Status {
    private $id;
    private $name;
    private $description;

    public function __construct($id, $name, $description = '') {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
    }

    /**
     * Constructs and returns the default status types
     * @static
     * @return array ReallySimpleIssueTracker_Status
     */
    public static function getDefaultStatusTypes(){

        $open = new self('open',__('Open',ReallySimpleIssueTracker::HANDLE),'');
        $in_progress = new self('in_progress',__('In progress',ReallySimpleIssueTracker::HANDLE),'');
        $stopped = new self('stopped',__('Stopped',ReallySimpleIssueTracker::HANDLE),'');
        $fixed = new self('fixed',__('Fixed',ReallySimpleIssueTracker::HANDLE),'');
        $closed = new self('closed',__('Closed',ReallySimpleIssueTracker::HANDLE),'');

        return array($open, $in_progress, $stopped, $fixed, $closed);
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getId() {
        return $this->id;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getName() {
        return $this->name;
    }

    /**
     * @param $id
     * @return bool|ReallySimpleIssueTracker_Status
     */
    public function getStatusTypeById($id) {
        if($id == $this->id)
            return $this;
        else
            return false;
    }
}