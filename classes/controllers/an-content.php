<?php

/** 
 * Định nghĩa class Content cho nội dung website
 */

class AN_Content {

    // Thuộc tính
    private $content_view;

    // Phương thức

    public function __construct($page) {

        $this->content_view = new AN_Content_View;

        // Thao tác khởi tạo
        $this->content_view->render($page);
    }
}
