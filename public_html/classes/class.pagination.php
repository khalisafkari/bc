<?php

class Pagination
{
    /**
     * Biến config chứa tất cả các cấu hình
     *
     * @var array
     */
    private $config = [
        'total' => 0, // tổng số mẩu tin
        'limit' => 0, // số mẩu tin trên một trang
        'querystring' => 'page' // GET id nhận page
    ];

    /**
     * khởi tạo
     *
     * @param array $config
     */
    public function __construct($config = [])
    {
        // kiểm tra xem trong config có limit, total đủ điều kiện không
        if (isset($config['limit']) && $config['limit'] < 0 || isset($config['total']) && $config['total'] < 0) {
            // nếu không thì dừng chương trình và hiển thị thông báo.
            die('limit và total không được nhỏ hơn 0');
        }
        // Kiểm tra xem config có querystring không
        if (!isset($config['querystring'])) {
            //nếu không để mặc định là page
            $config['querystring'] = 'page';
        }
        $this->config = $config;
    }

    /**
     * Lấy ra tổng số trang
     *
     * @return int
     */
    private function gettotalPage()
    {
        return ceil($this->config['total'] / $this->config['limit']);
    }

    /**
     * Lấy ra trang hiện tại
     *
     * @return int
     */
    private function getCurrentPage()
    {
        // kiểm tra tồn tại GET querystring và có >=1 không
        if (isset($_GET[$this->config['querystring']]) && (int)$_GET[$this->config['querystring']] >= 1) {
            // Nếu có kiểm tra tiếp xem nó có lớn hơn tổn số trang không.
            if ((int)$_GET[$this->config['querystring']] > $this->gettotalPage()) {
                // nếu lớn hơn thì trả về tổng số page
                return (int)$this->gettotalPage();
            } else {
                // còn không thì trả về số trang
                return (int)$_GET[$this->config['querystring']];
            }

        } else {
            // nếu không có querystring thì nhận mặc định là 1
            return 1;
        }
    }

    /**
     * lấy ra trang phía trước
     *
     * @return string
     */
    private function getPrePage()
    {
        // nếu trang hiện tại bằng 1 thì trả về null
        if ($this->getCurrentPage() === 1) {
            return;
        } else {
            // còn không thì trả về html code
            return '<li><a href="#" title="Page 1">&laquo; First</a></li>';
        }
    }

    /**
     * Lấy ra trang phía sau
     *
     * @return string
     */
    private function getNextPage()
    {
        // nếu trang hiện tại lơn hơn = totalpage thì trả về rỗng
        if ($this->getCurrentPage() >= $this->gettotalPage()) {
            return;
        } else {
            // còn không thì trả về HTML code
            return '<li><a href="#" title="Page '.$this->gettotalPage().'">Last &raquo;</a></li>';
        }
    }

    /**
     * Hiển thị html code của page
     *
     * @return string
     */
    public function getPagination()
    {
        // tạo biến data rỗng
        $data = '';
        $data .= ($this->getCurrentPage() - 1) > 1 ? '<li><a>...</a></li>' : '';

        for ($i = ($this->getCurrentPage() - 1) > 0 ? ($this->getCurrentPage() - 1) : 1; $i <= (($this->getCurrentPage() + 1) > $this->gettotalPage() ? $this->gettotalPage() : ($this->getCurrentPage() + 1)); $i++) {
            if ($i === $this->getCurrentPage()) {
                $data .= '<li class="active" ><a href="#">' . $i . '</a></li>';
            } else {
                $data .= '<li><a href="#" title="Page '.$i.'">' . $i . '</a></li>';
            }
        }

        $data .= ($this->getCurrentPage() + 1) < $this->gettotalPage() ? '<li><a>...</a></li>' : '';
        return $this->getPrePage() . $data . $this->getNextPage();
    }
}
?>