### Installation

Use composer

`composer require oberon/quill-rendering`

### Usage

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


### Most important components
* **Renderer**

  Has function `render` which returns a string with formatted contents

* **Parser**

  When given a Quill `op` and `renderers[]` return `true` if `op` was handled and an appropriate `Renderer` was added to provided `renderers[]`, `false` otherwise
  
### Convenient classes/methods
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

### Adding a custom Parser and Renderer

Example: You want to use `<b>` instead of `<strong>` for bold.

1. Create a Renderer

```
class Bold implements Renderer {
	
	private $text;
	
	public function __construct($insert) {
		$this->text = $insert;
	}
	
	public function render() {
		return '<b>'.$this->text.'</b>';
	}
}
```

2. Create a Parser

```
class BoldParser implements Parser {
	
	public function handleOp(array $op, array & $renderers) {
		
		//Check if your parser is going to handle the op
		if (array_key_exists('attributes', $op)
			&& is_array($op['attributes'])
			&& is_string($op['insert'])
			&& array_key_exists(Attribute::BOLD, $op['attributes'])) {
			
			//Instantiate your Bold Renderer
			$boldRenderer = new Bold($op['insert']);
			
			//It is inline, so add it to a Paragraph-block. The InlineUtil can do that
			InlineUtil::addToParagraph($boldRenderer, $renderers);
			
			return true;
		} else {
			// If your parser does not handle the op return false;
			return false;
		}
	}
}
```

3. Register the Parser with the QuillRender

```
//Start with the other HTML parsers
$parsers = DefaultHtmlParsers::get();

//Add to the beginning of the array,
//so it is checked before BasicHtmlParser which would also handle the bold attribute
$parsers = array_unshift($parsers, new BoldParser());

$quill = new RenderQuill();
//register
$quill->setParsers($parsers);
```

### Notes

The `load` method immediately uses the provided `Parsers`, so Parsers should be set first.

Other Ops than insert exist: those will not be rendered. Use the Quill-Delta library at
https://packagist.org/packages/oberon/quill-delta  
