<?php


namespace boisson\views;


/**
 * Class ViewRendering
 * @package boisson\views
 */
class ViewRendering
{

    /**
     * @param $content array Containing the body and the title
     * @return string The page who get send to the client
     */
    private static function render1($content)
    {
        return self::render2($content['body'], $content['title']);
    }

    /**
     * @param $body string The body of the page
     * @param $title string The title of the page
     * @return string The page who get send to the client
     */
    private static function render2($body, $title)
    {
        $template = file_get_contents('./html/template.html');

        if (!$title == "") {
            $template = str_replace_first('${title}', " - $title", $template);
        } else {
            $template = str_replace_first('${title}', "", $template);
        }
        $template = str_replace_first('${body}', $body, $template);

        return $template;
    }

    /**
     * @param $name string name of the function
     * @param $arguments array argument of the function
     * @return mixed Return the corresponding function `render1` or  `render2`
     */
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