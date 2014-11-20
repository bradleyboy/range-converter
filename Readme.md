# Range converter

This simple class reduces arrays into compact strings by creating ranges when encountering neighboring integers. It can also expand strings with ranges back to the original array form.

[![Build Status](https://travis-ci.org/bradleyboy/range-converter.svg?branch=master)](https://travis-ci.org/bradleyboy/range-converter)

## Examples

Reducing ranges:

```php
$converter = new Bradleyboy\Util\RangeConverter;
$converter->reduce([1,2,3,4,7,9,10,11]); // Returns: '1..4,7,9..11'
```

Expanding ranges:

```php
$converter = new Bradleyboy\Util\RangeConverter;
$converter->expand('1..4,7,9..11'); // Returns: [1,2,3,4,7,9,10,11]
```

You can also set custom separators:

```php
$converter = new Bradleyboy\Util\RangeConverter;
$converter->setSeparator('.')
          ->setRangeSeparator('-')
          ->reduce([1,2,3,4,7,9,10,11]); // Returns: '1-4.7.9-11'
```

For more examples, see `src/Bradleyboy/Util/RangeConverterTest.php`.
