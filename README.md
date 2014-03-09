# PHPWord

[![Build Status](https://travis-ci.org/PHPOffice/PHPWord.png?branch=master)](https://travis-ci.org/PHPOffice/PHPWord)
[![Latest Stable Version](https://poser.pugx.org/phpoffice/phpword/v/stable.png)](https://packagist.org/packages/phpoffice/phpword) [![Total Downloads](https://poser.pugx.org/phpoffice/phpword/downloads.png)](https://packagist.org/packages/phpoffice/phpword) [![Latest Unstable Version](https://poser.pugx.org/phpoffice/phpword/v/unstable.png)](https://packagist.org/packages/phpoffice/phpword) [![License](https://poser.pugx.org/phpoffice/phpword/license.png)](https://packagist.org/packages/phpoffice/phpword)

__OpenXML - Read, Write and Create Word documents in PHP.__

PHPWord is a library written in PHP that create word documents.

No Windows operating system is needed for usage because the result are docx files (Office Open XML) that can be
opened by all major office software.

__Want to contribute?__ Fork us!

## Requirements

* PHP version 5.3.0 or higher

## Installation

It is recommended that you install the PHPWord library [through composer](http://getcomposer.org/). To do so, add
the following lines to your ``composer.json``.

```json
{
    "require": {
       "phpoffice/phpword": "dev-master"
    }
}
```

## Documentation

### Table of contents

1. [Basic usage](#basic-usage)
    * [Measurement units](#measurement-units)
2. [Sections](#sections)
    * [Section settings](#section-settings)
    * [Section page numbering](#section-page-numbering)
3. [Texts](#texts)
4. [Tables](#tables)
    * [Cell Style](#tables-cell-style)
5. [Images](#images)

<a name="basic-usage"></a>
#### Basic usage

The following is a basic example of the PHPWord library.

```php
$PHPWord = new PHPWord();

// Every element you want to append to the word document is placed in a section.
// To create a basic section:
$section = $PHPWord->createSection();

// After creating a section, you can append elements:
$section->addText('Hello world!');

// You can directly style your text by giving the addText function an array:
$section->addText('Hello world! I am formatted.',
    array('name'=>'Tahoma', 'size'=>16, 'bold'=>true));

// If you often need the same style again you can create a user defined style
// to the word document and give the addText function the name of the style:
$PHPWord->addFontStyle('myOwnStyle',
    array('name'=>'Verdana', 'size'=>14, 'color'=>'1B2232'));
$section->addText('Hello world! I am formatted by a user defined style',
    'myOwnStyle');

// You can also put the appended element to local object like this:
$fontStyle = new PHPWord_Style_Font();
$fontStyle->setBold(true);
$fontStyle->setName('Verdana');
$fontStyle->setSize(22);
$myTextElement = $section->addText('Hello World!');
$myTextElement->setFontStyle($fontStyle);

// Finally, write the document:
$objWriter = PHPWord_IOFactory::createWriter($PHPWord, 'Word2007');
$objWriter->save('helloWorld.docx');
```

<a name="measurement-units"></a>
##### Measurement units

The base length unit in Open Office XML is twip. Twip means "TWentieth of an Inch Point", i.e. 1 twip = 1/1440 inch.

You can use PHPWord helper functions to convert inches, centimeters, or points to twips.

```php
// Paragraph with 6 points space after
$PHPWord->addParagraphStyle('My Style', array(
    'spaceAfter' => PHPWord_Shared_Font::pointSizeToTwips(6))
);

$section = $PHPWord->createSection();
$sectionStyle = $section->getSettings();
// half inch left margin
$sectionStyle->setMarginLeft(PHPWord_Shared_Font::inchSizeToTwips(.5));
// 2 cm right margin
$sectionStyle->setMarginRight(PHPWord_Shared_Font::centimeterSizeToTwips(2));
```

<a name="sections"></a>
#### Sections

Every visible element in word is placed inside of a section. To create a section, use the following code:

```php
$section = $PHPWord->createSection($sectionSettings);
```
The `$sectionSettings` is an optional associative array that sets the section. Example:

```php
$sectionSettings = array(
    'orientation' => 'landscape',
    'marginTop' => 600,
    'colsNum' => 2,
);
```
<a name="section-settings"></a>
##### Section settings

Below are the available settings for section:

* `orientation` Page orientation, i.e. 'portrait' (default) or 'landscape'
* `marginTop` Page margin top in twips
* `marginLeft` Page margin left in twips
* `marginRight` Page margin right in twips
* `marginBottom` Page margin bottom in twips
* `borderTopSize` Border top size in twips
* `borderTopColor` Border top color
* `borderLeftSize` Border left size in twips
* `borderLeftColor` Border left color
* `borderRightSize` Border right size in twips
* `borderRightColor` Border right color
* `borderBottomSize` Border bottom size in twips
* `borderBottomColor` Border bottom color
* `headerHeight` Spacing to top of header
* `footerHeight` Spacing to bottom of footer
* `colsNum` Number of columns
* `colsSpace` Spacing between columns
* `breakType` Section break type (nextPage, nextColumn, continuous, evenPage, oddPage)

The following two settings are automatically set by the use of the `orientation` setting. You can alter them but that's not recommended.

* `pageSizeW` Page width in twips
* `pageSizeH` Page height in twips

<a name="section-page-numbering"></a>
##### Section page numbering

You can change a section page numbering.

```php
$section = $PHPWord->createSection();
$section->getSettings()->setPageNumberingStart(1);
```

<a name="texts"></a>
#### Texts

Text can be added by using `addText` and `createTextRun` method. `addText` is used for  creating simple paragraphs that only contain texts with the same style. `createTextRun` is used for creating complex paragraphs that contain text with different style (some bold, other italics, etc) or other elements, e.g. images or links.

`addText` sample:

```php
$fontStyle = array('name' => 'Times New Roman', 'size' => 9);
$paragraphStyle = array('align' => 'both');
$section->addText('I am simple paragraph', $fontStyle, $paragraphStyle);
```

`createTextRun` sample:

```php
$textrun = $section->createTextRun();
$textrun->addText('I am bold', array('bold' => true)); 
$textrun->addText('I am italic, array('italic' => true));
$textrun->addText('I am colored, array('color' => 'AACC00'));
```
<a name="tables"></a>
#### Tables

The following illustrates how to create a table.

```php
$table = $section->addTable();
$table->addRow();
$table->addCell();
```

<a name="tables-cell-style"></a>
##### Cell Style

###### Cell Span

You can span a cell on multiple columms.

```php
$cell = $table->addCell(200);
$cell->getStyle()->setGridSpan(5);
```

<a name="images"></a>
#### Images

You can add images easily using the following example.

```php
$section = $PHPWord->createSection();
$section->addImage('mars.jpg');
```

Images settings include:
* ``width`` width in pixels
* ``height`` height in pixels
* ``align`` image alignment, _left_, _right_ or _center_
* ``marginTop`` top margin in inches, can be negative
* ``marginLeft`` left margin in inches, can be negative
* ``wrappingStyle`` can be _inline_, _square_, _tight_, _behind_, _infront_

To add an image with settings, consider the following example.

```php
$section->addImage(
    'mars.jpg',
    array(
        'width' => 100,
        'height' => 100,
        'marginTop' => -1,
        'marginLeft' => -1,
        'wrappingStyle' => 'behind'
    )
);
 ```
