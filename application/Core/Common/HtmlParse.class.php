<?php
        namespace Core\Common;

/**
 * 一个简单的Html解析类
 * @TODO 为类添加解析字符串接口
 * @TODO 为类添加替换变量限制接口
 * @TODO 为替换变量加强完善过滤机制,防止跨站脚本攻击
 */

class HtmlParse
{

    public function __construct()
    {
    }

    /**
     * HTML解析方法
     * @param  [string] $htmlfile [文件模板名]
     * @param  [array] $replace  [替换的变量]
     * @return [string]           [返回替换后的文件内容]
     */
    public function htmlparse($htmlfile, $replace)
    {
        if (!is_array($replace)) {
            throw new \Exception("The replacement must be an array");
        }

        //对传入变量进行简单的过滤
        $replace = array_map(function ($value) {

               return $value;

        }, $replace);
    
        $htmlfile = RESOURCE_PATH."mail_html_template"."/".$htmlfile;

        if (file_exists($htmlfile)) {
            $fhandler = fopen($htmlfile, "r");
            $filecontents = fread($fhandler, filesize($htmlfile));



           //替换模板中的变量
            $replace_reg = "/\\".C("TMPL_L_DELIM").".*\\".C("TMPL_R_DELIM")."/";

            $match_res   = array();
            $template_vars = preg_match_all($replace_reg, $filecontents, $match_res);





            if (count($replace) != $template_vars) {
                throw new \Exception("The Variable's number  in template is not match the replacement!");
            } else {
                $match_res = array_map(function ($string) {

                    return "/".preg_quote($string)."/";

                }, $match_res[0]);


                $parsed = preg_replace($match_res, $replace, $filecontents);

                return $parsed;
            }
        } else {
            throw new \Exception("File ".$htmlfile."
 			     	is no Exists!");
        }
    }
}
