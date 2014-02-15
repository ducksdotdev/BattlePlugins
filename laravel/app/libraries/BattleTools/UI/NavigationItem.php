<?php
namespace BattleTools\UI;

class NavigationItem {
    private $title;
    private $url;
    private $parent;
    private $active = false;
    private $parentTitle;

    public function __construct($title, $url, $parent=false, $parentTitle=null) {
        $this->title = $title;
        $this->url = $url;
        $this->parent = $parent;
        $this->parentTitle = $parentTitle;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getUrl() {
        return $this->url;
    }

    public function isParent(){
        return $this->parent;
    }

    public function getParent(){
        return $this->parentTitle;
    }

    public function setActive($bool=true){
        $this->active = $bool;
    }

    public function isActive(){
        return $this->active;
    }
}
