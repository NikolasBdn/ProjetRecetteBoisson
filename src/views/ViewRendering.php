<?php


namespace boisson\views;


class ViewRendering
{

    private static function render1(array $content)
    {
        return self::render2($content['body'], $content['title']);
    }

    private static function render2(string $body, string $title)
    {
        $template = file_get_contents('./src/views/template.html');

        if (!$title == "") {
            $template = str_replace_first('${title}', " - $title", $template);
        } else {
            $template = str_replace_first('${title}', "", $template);
        }
        $template = str_replace_first('${body}', $body, $template);

        return $template;
    }

    public function __call($name, $arguments)
    {
        if ($name == 'render') {
            if (count($arguments) == 1) {
                return call_user_func_array(array($this, 'render1'), $arguments);
            } else if (count($arguments) == 2) {
                return call_user_func_array(array($this, 'render2'), $arguments);
            }
        }
    }
}