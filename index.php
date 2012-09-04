<?php
/**
 * User: Jacob Ebey
 * Date: 9/3/12
 * Time: 3:26 PM
 * URL: index.php
 */

require 'includes/JacobForm.php';

$checkboxes = array();
$radios = array();
$selects = array();

for ($i = 1; $i <= 10; $i++) {
    $checkboxes[] = new Checkbox("Checkbox " . $i . ":", $i, $i);
}

for ($i = 1; $i <= 3; $i++) {
    $radios[] = new Radio("Radio " . $i . ":", $i, $i);
}

for ($i = 1; $i <= 3; $i++) {
    $selects[] = new Select("Radio " . $i . ":", $i, $i);
}

$form = new JacobForm("Test Form", "");
$form->addElement(new TextElement("Name", "name", "name", "Name:"));
$form->addElement(new PasswordElement("Name 2", "password", "password", "Password:"));
$form->addElement(new HtmlElement("<hr>"));
$form->addElement(new CheckboxElement($checkboxes, "checkboxes", "checkbox_class", "", "<br>"));
$form->addElement(new RadioElement($radios, "radios", "radio_class", "", "<br>"));
$form->addElement(new SelectElement($selects, "selects", "select_class", "", ""));
$form->addElement(new SubmitElement("Submit 1", "submit", "submit", "Submit"));

$form->render("", "", "", "<br>");