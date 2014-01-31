<?php

class ReallySimpleIssueTracker_IssueType {

    private $id;
    private $name;
    private $description;

    public function __construct($id, $name, $description = '') {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
    }

    /**
     * Constructs and returns the default issue types
     * @static
     * @return array ReallySimpleIssueTracker_IssueType
     */
    public static function getDefaultIssueTypes(){

        $bug = new self('bug',__('Bug',ReallySimpleIssueTracker::HANDLE),'');
        $task = new self('task',__('Task',ReallySimpleIssueTracker::HANDLE),'');
        $improvement = new self('improvement',__('Improvement',ReallySimpleIssueTracker::HANDLE),'');
        $new_feature = new self('new_feature',__('New feature',ReallySimpleIssueTracker::HANDLE),'');
        $story = new self('story',__('Story',ReallySimpleIssueTracker::HANDLE),'');

        return array($bug, $task, $improvement, $new_feature, $story);
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
}