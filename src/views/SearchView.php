<?php


namespace boisson\views;


class SearchView
{
    public static function render($data) {
        $title = 'Resulta pour ' . "<b>" . $data['search'] . "</b>";
        unset($data['search']);
        $contentArray = array('title' => $title);
        $content = "<div id='lists'><h1>" . $title . "</h1><table>";
        foreach ($data as $element) {
            $name = $element->name;
            $type = $element->type;
            $id = $element->id;
            if ($type == 'recipe')
                $js = "showRecipe(".$id.")";
            else
                $js = "showIngredient(".$id.")";
            $content .= "<tr onclick=$js><th>$name</th></tr>";
        }
        $contentArray['body'] = $content . "</table></div>";
        return (new ViewRendering())->render($contentArray);
    }
}