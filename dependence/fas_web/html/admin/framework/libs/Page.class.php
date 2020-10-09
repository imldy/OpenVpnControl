<?php

/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2017/8/18
 * Time: 0:13
 */
class Page
{

    static $PAGE_IN_PATH = 0;
    static $PAGE_IN_QUERY = 1;

    public $rows = 0;
    public $offset = 1;
    public $pageSize = 20;
    public $pageType = 1;
    public $key = "page";
    public $url = "page";
    public $queryString = true;
    public $pageStyle = "pagination pagination-sm";

    //设置总页数
    function setRows($vo)
    {
        $this->rows = $vo;
    }

    //获取当前页数(适用于位于查询字符串的类型)
    static function getOffset($key='page')
    {
        if (!(int)$_GET[$key] || (int)$_GET[$key] < 1) {
            return 1;
        }
        return (int)$_GET[$key];
    }

    //设置当前页
    function setOffset($vo)
    {
        $this->offset = $vo;
    }

    //每页记录数
    function setPageSize($vo)
    {
        $this->pageSize = $vo;
    }

    function setPageType($vo)
    {
        $this->pageType = $vo;
    }

    function setPageStyle($vo)
    {
        $this->pageStyle = $vo;
    }

    function setKey($vo)
    {
        $this->key = $vo;
    }

    function setUrl($vo)
    {
        $this->url = $vo;
    }

    function setQueryString($vo)
    {
        $this->queryString = $vo;
    }

    public function createUrl($offset)
    {
        $query = "";
        //$urlall = explode("?",$this->url,2);
      //  $path = $urlall[0];
      //  $query_string = $urlall[1];
      //  $query_arr = explode("&",)
        if ($this->pageType == self::$PAGE_IN_QUERY) {
            $_GET[$this->key] = $offset;
            $query = "?" . http_build_query($_GET);
        } else {
            if ($this->queryString) {
                $query = $_SERVER["QUERY_STRING"] ? "?" . $_SERVER["QUERY_STRING"] : "";
            }
            $query = '/' . $offset . $query;
        }
        $url = $this->url ?: $_SERVER['PHP_SELF'] . $_SERVER['PATH_INFO'];
        return $url . $query;
    }

    public function create()
    {
        $numrows = $this->rows;
        $offsetPage = $this->offset;
        $pageSize = $this->pageSize;

        $style = $this->pageStyle;
        $pages = intval($numrows / $pageSize);
        if ($numrows % $pageSize) {
            $pages++;
        }

        $page_limit = 15;
        $page = intval($offsetPage) == "" ? 1 : $offsetPage;


        $rem = $page % $page_limit;

        $page_start = $page - $rem + 1;
        if ($page >= 15) {
            $page_start--;
        }
        $for_len = $pages - $page_start > 15 ? 15 : $pages - $page_start + 1;
        $html = "";
        $html .= '<ul class="' . $style . '">';
        $first = 1;
        $prev = $page - 1;
        $next = $page + 1;
        $last = $pages;
        if ($page > 1) {
            $html .= '<li><a href="' . $this->createUrl($first) . '">首页</a></li>';
            $html .= '<li><a href="' . $this->createUrl($prev) . '">&laquo;</a></li>';
        } else {
            $html .= '<li class="disabled"><a>首页</a></li>';
            $html .= '<li class="disabled"><a>&laquo;</a></li>';
        }
        for ($i = $page_start; $i < $page_start + $for_len; $i++) {
            if ($page != $i) {
                $html .= '<li><a href="' . $this->createUrl($i) . '">' . $i . '</a></li>';
            } else {
                $html .= '<li class="disabled"><a>' . $page . '</a></li>';
            }
        }

        if ($page < $pages) {
            $html .= '<li><a href="' . $this->createUrl($next) . '">&raquo;</a></li>';
            $html .= '<li><a href="' . $this->createUrl($last) . '">尾页</a></li>';
        } else {
            $html .= '<li class="disabled"><a>&raquo;</a></li>';
            $html .= '<li class="disabled"><a>尾页</a></li>';
        }
        $html .= '</ul>';

        return $html;
    }
}