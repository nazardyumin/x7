<?php
class Post
{
    public $id;
    public $title;
    public $content;
    public $created_at;

    function __construct($array)
    {
        $this->id = $array['id'];
        $this->title = $array['title'];
        $this->content = $array['content'];
        $this->created_at = $array['created_at'];
    }
}
?>