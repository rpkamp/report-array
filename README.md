# report-array
Easily create aggregate arrays from flat data

Creating a structured array from flat data that comes from a relation database can be quite a hassle.

For example when you have data like

product | country | count
--------|---------|------
foo     | NL      | 5
foo     | US      | 10
bar     | UK      | 3
bar     | DE      | 2

and want to transform it to an array like

```
[
  'foo' => [
      'NL' => 5,
      'US' => 10,
  ],
  'bar' => [
    'UK' => 3,
    'DE' => 2,
  ]
]
```

you often see code that goes a little like this

    $report = [];
    foreach ($rows as $row) {
      if (!isset($report[$row['product']][$row['country']])) {
        $report[$row['product']][$row['country'] = 0;
      }
      $report[$row['product']][$row['country']] += $row['count'];
    }

The `isset` part takes 3 lines and quite noisy to read. This is where `ReportArray` comes in. Instead of the above you can do

```
$storage = new ReportArray\Storage();
$report = new ReportArray($storage);
foreach ($rows as $row)
{
  $report->add($row['product'], $row['country'], $row['count']);
}
```

If at any point you want the array shown above just call `$report->get()`.

That's it. No more isset, just tell the class to add a value and it will assume a value of 0 for any key that was not set yet.
If you want a different value from 0 as default value, pass it the `ReportArray\Storage` class constructor as an argument.

In addition to the `add` method, there is also `sub` for substraction, `mul` for multiplication, `pow` for powers and `sqrt` for roots.
