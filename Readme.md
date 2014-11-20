# Range converter

This simple class reduces comma separated integer strings into reduced length versions by creating ranges where possible. It can also expand strings with ranges back to the original comma separated form.

## Examples

Reducing ranges:

```php
$converter = new Bradleyboy\RangeConverter;
$converter->reduceRanges('1,2,3,4,7,9,10,11'); // Returns: 1..4,7,9..11
```

Expanding ranges:

```php
$converter = new Bradleyboy\RangeConverter;
$converter->expandRanges('1..4,7,9..11'); // Returns: 1,2,3,4,7,9,10,11
```

You can also set custom separators:

```php
$converter = new Bradleyboy\RangeConverter;
$converter->setSeparator('.')
          ->setRangeSeparator('-')
          ->reduceRanges('1.2.3.4.7.9.10.11'); // Returns: 1-4.7.9-11
```

For more examples, see `src/bradleyboy/RangeConverterTest.php`.
