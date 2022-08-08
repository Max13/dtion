# Dtion

`Dtion` is a serializable classes allowing you to store a condition and result.

`DtionList` is also serializable and is used to store a list of `Dtion`, allowing you to find the result for a given criterion, if any.

Example, you can store conditions like:
- If the **category** of the employee is **between 1 and 5**, the *prior notice* is **1 month**.
- If the **category** of the employee is **between 6 and 7**, the *prior notice* is **2 months**.
- If the **category** of the employee is **between 8 and 12**, the *prior notice* is **3 months**.

Here is another example using date intervals as conditions:
- If the **fixed term contract** lasts from **0** to **6 months**, then the *trial period* is **15 days**.
- Above **6 months**, the *trial period* is **1 month**.

Expressing these intervals (as `DateInterval` or `CarbonInterval`) as conditions with `Dtion` is easy. See bellow.

## Installation

You can use composer: `composer require max13/dtion:^1.0`

## Usage

Using the examples above:

```php
use Dtion\Dtion;
use Dtion\DtionList;

// A Dtion accepts: string, int, float, callable and a Stringable value.
$priorNoticeList = new DtionList([
    new Dtion(1, 5, new DateInterval('P1M'),
    new Dtion(6, 7, new DateInterval('P2M'),
    new Dtion(8, 12, new DateInterval('P3M'),
]);

$category = 2;
$employeePriorNotice = $priorNoticeList->resultFor($category); // returns DateInterval('P1M')
$dtion = $priorNoticeList->find($category); // returns the corresponding Dtion, or null if not found.
```

## Need help?

Open an issue.

Now have fun.
