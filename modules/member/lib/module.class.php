<?php

class Member extends Member_base{
    public $parent;
    public $parent_table;
    public $theme_name;
    public $recnum; // 출력 기본 값
    public $sort;
    public $orderby;
    public $oneline_recnum = 5;

    // 테마 패스 추출함수
    public function getThemePath($type){
        global $g;

        if($type=='relative') $result = $g['path_module'].$this->module.'/themes/'.$this->theme_name;
        else if($type=='absolute') $result = $g['url_root'].'/modules/'.$this->module.'/themes/'.$this->theme_name;

        return $result;
    }
    // get html & replace-parse
    public function getHtml($fileName) {
        global $g,$TMPL;
        $theme_path = $this->getThemePath('relative');
        $file = sprintf($theme_path.'/_html/%s.html', $fileName);
        $fh_skin = fopen($file, 'r');
        $skin = @fread($fh_skin, filesize($file));
        fclose($fh_skin);
        //return $skin;
        return $this->getParseHtml($skin);
    }

    public function getParseHtml($skin) {
        global $TMPL;
        // $skin = preg_replace_callback('/{\$lng->(.+?)}/i', create_function('$matches', 'global $LNG; return $LNG[$matches[1]];'), $skin);
        $skin = preg_replace_callback('/{\$([a-zA-Z0-9_]+)}/', create_function('$matches', 'global $TMPL; return (isset($TMPL[$matches[1]])?$TMPL[$matches[1]]:"");'), $skin);

        return $skin;
    }

}

?>
