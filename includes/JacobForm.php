<?php
/**
 * Jacob's Form Class to make the creation and rendering of forms easy.
 */
class JacobForm
{
    private
        $formName,
        $redirectLocation,
        $elements;

    /**
     * @param string $_formName
     * @param string $_redirectLocation
     *   Used as action in <form> tag
     */
    public function __construct($_formName = "", $_redirectLocation = "")
    {
        $this->formName = $_formName;
        $this->redirectLocation = $_redirectLocation;
    }

    /**
     * @param FormElement $formElement
     */
    public function addElement(FormElement $formElement)
    {
        $this->elements[] = $formElement;
    }

    public function render($id = "", $class = "", $beforeEachElement = "", $afterEachElement = "")
    {
        $html = "<form method='post' action='{$this->redirectLocation}' id='{$id}' class='{$class}'>";
        foreach ($this->elements as $element) {
            $html .= $beforeEachElement;
            $html .= $element->generateHTML();
            $html .= $afterEachElement;
        }
        $html .= "</form>";
        echo $html;
    }

}

/**
 * Default Form Element
 */
class FormElement
{
    public
        $name,
        $id,
        $class,
        $label;

    public function __construct($_name = "", $_id = "", $_class = "", $_label = "")
    {
        $this->name = $_name;
        $this->id = $_id;
        $this->class = $_class;
        $this->label = $_label;
    }
}

/**
 * Standard Text Input
 */
class TextElement extends FormElement
{
    public function __construct($_name = "", $_id = "", $_class = "", $_label = "")
    {
        parent::__construct($_name, $_id, $_class, $_label);
    }

    public function generateHTML()
    {
        $html = "<label for='{$this->id}'>{$this->label}</label>";
        $html .= "<input type='text' name='{$this->name}' id='{$this->id}' class='{$this->class}'";
        $html .= !empty($_POST[$this->name]) ? " value='{$_POST[$this->name]}'" : "";
        $html .= ">";

        return $html;
    }
}

/**
 * Password Text Input
 */
class PasswordElement extends FormElement
{
    public function __construct($_name = "", $_id = "", $_class = "", $_label = "")
    {
        parent::__construct($_name, $_id, $_class, $_label);
    }

    public function generateHTML()
    {
        $html = "<label for='{$this->id}'>{$this->label}</label>";
        $html .= "<input type='password' name='{$this->name}' id='{$this->id}' class='{$this->class}'>";

        return $html;
    }
}

/**
 * Single Checkbox to be passed in array to @CheckboxElement
 */
class Checkbox
{
    public
        $label,
        $value,
        $id;

    public function __construct($_label, $_value, $_id = "")
    {
        $this->label = $_label;
        $this->value = $_value;
        $this->id = $_id;
    }
}

/**
 * Checkbox Inputs Used With an array of @Checkbox
 */
class CheckboxElement extends FormElement
{
    private
        $elements,
        $before,
        $after;

    public function __construct(array $_elements, $_name = "", $_class = "", $_beforeEachCheckbox = "", $_afterEachCheckbox = "")
    {
        parent::__construct($_name, "", $_class, "");

        $this->elements = $_elements;
        $this->before = $_beforeEachCheckbox;
        $this->after = $_afterEachCheckbox;
    }

    public function generateHTML()
    {
        $html = "";
        foreach ($this->elements as $element) {
            $html .= $this->before;
            $html .= "<label for='{$element->id}'>{$element->label}</label>";
            $html .= "<input type='checkbox' name='{$this->name}[]' value='{$element->value}' id='{$element->id}' class='{$this->class}'";
            $html .= !empty($_POST[$this->name]) ? in_array($element->value, $_POST[$this->name]) ? " checked='checked'" : "" : "";
            $html .= ">";
            $html .= $this->after;
        }
        return $html;
    }
}

/**
 * Single Radio to be passed in array to a @RadioElement
 */
class Radio
{
    public
        $label,
        $value,
        $id;

    public function __construct($_label, $_value, $_id = "")
    {
        $this->label = $_label;
        $this->value = $_value;
        $this->id = $_id;
    }
}

/**
 * Radio inputs to be used with an array of @Radio
 */
class RadioElement extends FormElement
{
    private
        $elements,
        $before,
        $after;

    public function __construct(array $_elements, $_name = "", $_class = "", $_beforeEachCheckbox = "", $_afterEachCheckbox = "")
    {
        parent::__construct($_name, "", $_class, "");

        $this->elements = $_elements;
        $this->before = $_beforeEachCheckbox;
        $this->after = $_afterEachCheckbox;
    }

    public function generateHTML()
    {
        $html = "";
        foreach ($this->elements as $element) {
            $html .= $this->before;
            $html .= "<label for='{$element->id}'>{$element->label}</label>";
            $html .= "<input type='radio' name='{$this->name}' value='{$element->value}' id='{$element->id}' class='{$this->class}'";
            $html .= !empty($_POST[$this->name]) ? $_POST[$this->name] == $element->value ? " checked='checked'" : "" : "";
            $html .= ">";
            $html .= $this->after;
        }
        return $html;
    }
}

/**
 * Single Select to be passed in array to a @SelectElement
 */
class Select
{
    public
        $label,
        $value;

    public function __construct($_label, $_value)
    {
        $this->label = $_label;
        $this->value = $_value;
    }
}

/**
 * Select input to be used with an array of @Select
 */
class SelectElement extends FormElement
{
    private
        $elements;

    public function __construct(array $_elements, $_name = "", $_id = "", $_class = "", $_label = "")
    {
        parent::__construct($_name, $_id, $_class, $_label);
        $this->elements = $_elements;
    }

    public function generateHTML()
    {
        $html = "<label for='{$this->id}'>{$this->label}</label>";
        $html .= "<select id='{$this->id}' name='{$this->name}'>";
        foreach ($this->elements as $element) {
            $html .= " <option class='{$this->class}' value='{$element->value}'";
            $html .= (!empty($_POST[$this->name]) && $_POST[$this->name] == $element->value) ? " selected='selected'" : "";
            $html .= ">{$element->label}</option >";
        }
        $html .= "</select>";
        return $html;
    }
}

/**
 * Standard Submit button
 */
class SubmitElement extends FormElement
{
    public function __construct($_name = "", $_id = "", $_class = "", $_label = "")
    {
        parent::__construct($_name, $_id, $_class, $_label);
    }

    public function generateHTML()
    {
        $html = " <input type='submit' name='{$this->name}' id='{$this->id}' class='{$this->class}' value ='{$this->label}' >";

        return $html;
    }
}

/**
 * HTML Form Element to be rendered
 */
class HtmlElement extends FormElement
{
    private
        $htmlString;

    public function __construct($_htmlString)
    {
        $this->htmlString = $_htmlString;
    }

    public function generateHTML()
    {
        return $this->htmlString;
    }
}