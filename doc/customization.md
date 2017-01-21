<h1 align="center">EasyHtmlElement</h1>

<p align="center">An easy way to create simple or complex HTML elements in PHP.</p>

---

##Customization

EasyHtmlElement tries to cover the maximum of use cases but if your needs are really specific you can customize it. And another time EasyHtmlElement make it easier for you. Every component is defined from an interface so if you want to customize something you just need to create your own class and implement the component interface.

* [HtmlElementInterface][1]: Library heart, it manages all others components.
* [ElementInterface][2]: Element which generates HTML code.
* [EscaperInterface][3]: Manages and applies escaping strategies.
* [BranchValidatorInterface][4]: Validates the `map` branches before load elements.

[1]: ../src/NatePage/EasyHtmlElement/HtmlElementInterface.php
[2]: ../src/NatePage/EasyHtmlElement/ElementInterface.php
[3]: ../src/NatePage/EasyHtmlElement/EscaperInterface.php
[4]: ../src/NatePage/EasyHtmlElement/BranchValidatorInterface.php
