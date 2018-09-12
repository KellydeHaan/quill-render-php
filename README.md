#README

##Installation
Use composer

`composer require oberon/quill-rendering`

###Usage

```
$quillOps = "{\"ops\":[
    {\"insert\":\"Lorem ipsum dolor sit amet, \"},
    {\"insert\":\" consectetur\",\"attributes\":{\"bold\":true}},
    {\"insert\":\" adipiscing elit. Sed volutpat lectus non \"},
    {\"insert\":\"pellentesque volutpat\",\"attributes\":{\"italic\":true}},
    {\"insert\":\". Phasellus in lectus pulvinar lorem vestibulum pellentesque.\"}
]}";

try {
    $quill = new RenderQuill();
    $quill->setParsers(\Oberon\Quill\Render\Html\DefaultHtmlParsers::get());
    $quill->load($quillOps);
    echo $quill->render(true);
} catch (Exception $e) {
    echo $e->getMessage();
}
```

Output should be: <p>Lorem ipsum dolor sit amet, <strong> consectetur</strong> adipiscing elit. Sed volutpat lectus non <em>pellentesque volutpat</em>. Phasellus in lectus pulvinar lorem vestibulum pellentesque.</p>


###Most important components
* **Renderer**

  Has function `render` which returns a string with formatted contents

* **Parser**

  When given a Quill `op` and `renderers[]` return `true` if `op` was handled and an appropriate `Renderer` was added to provided `renderers[]`, `false` otherwise
  
###Convenient classes/methods
`DefaultHtmlParsers::get()` returns a `Parser[]` for most basic HTML functionality including 
* Bold 
* Underline
* Strikethrough
* Italic
* Ordered/Unordered lists
* Links
* Images
* Headers
* Sub/SuperScript

`HtmlParser::withQuill($quillOps)` will render the provided Quill-text with the DefaultHtmlParsers.

###Notes

The `load` method immediately uses the provided `Parsers`, so Parsers should be set first.

Other Ops than insert exist: those will not be rendered. Use the Quill-Delta library at
https://packagist.org/packages/oberon/quill-delta  