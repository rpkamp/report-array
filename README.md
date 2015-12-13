# report-array
Easily create aggregate arrays from flat data

Creating a structured array from flat data that comes from a relation database for example can be quite a hassle.

For example when you have data like

product | country | count
--------|---------|------
foo     | NL      | 5
foo     | US      | 10
bar     | UK      | 3
bar     | DE      | 2

and want to transform it to an array like

```php
$report = [
    'foo' => [
        'NL' => 5,
        'US' => 10,
    ],
    'bar' => [
      'UK' => 3,
      'DE' => 2,
    ]
];
```

you often see code that goes along the lines of

```
$report = [];
foreach ($rows as $row) {
    if (!isset($report[$row['product']][$row['country']])) {
        $report[$row['product']][$row['country']] = 0;
    }
    $report[$row['product']][$row['country']] += $row['count'];
}
```

The `isset` part takes up 3 lines total and is quite hard to read. This is where `ReportArray` comes in. Instead of the above you can do

```php
$storage = new rpkamp\ReportArray\Storage();
$report = new rpkamp\ReportArray\ReportArray($storage);
foreach ($rows as $row) {
    $report->add($row['product'], $row['country'], $row['count']);
}
```

If at any point you want the array shown above just call `$report->get()`.

That's it. No more isset, just tell the class to add a value and it will assume a value of 0 for any key that was not yet set.
If you want a different value than 0 as default value, pass it to the `rpkamp\ReportArray\Storage` class constructor as an argument.

In addition to the `add` method, there is also `sub` for substraction, `mul` for multiplication, `div` for division, `pow` for powers and `sqrt` for roots.
