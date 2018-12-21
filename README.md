# Self Destruct

This package was built with the goal in mind of creating a repeatable way of having models delete themselves after a specified amount of time. Currently, the package is fairly basic but could be expanded upon to allow deeper customisation and the ability of having per-record expiration times rather than scoped to each model.

## What's in the package

- [SelfDestruct Trait](https://github.com/Robert-Hucks/SelfDestruct/blob/master/src/Traits/SelfDestruct.php)

This can be used on `Model`s to give it the ability to delete after a specified time.

- [Migration](https://github.com/Robert-Hucks/SelfDestruct/blob/master/src/Database/migrations/2018_12_21_095154_create_self_destruct_table.php)

Table that is used to manage the destruction of `Model`s.

## How it works

This package works by using the provided `Trait` on a `Model` which hooks in to the `created` event. When a `Model` is created, it takes the sum of `created_at` and `life_time` and stores it in a seperate table. Then, every minute this table is checked for expired records and each `Model` is deleted.

## How to use

1) Adding the package to your project.

```bash
composer require roberthucks/selfdestruct
```

2) Run migration to create the table

```bash
php artisan migrate
```

3) Configure models

The first step here is to add the `Trait` to the `Model`.
Add `use roberthucks\selfdestruct\Traits\SelfDestruct;` and then user it inside your `Model`s class like so `use SelfDestruct;`
Once these have been added to your `Model` you need to then add a property called `$life_time`. This is the amount of seconds that a `Model` should stay alive for.

Here is how a `Model` looks when modified:
```php
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use roberthucks\selfdestruct\Traits\SelfDestruct;

class Post extends Model
{
  use SoftDeletes;
  use SelfDestruct;

  protected $table = 'post';
  protected $fillable = [
    'title',
    'body'
  ];
  protected $dates = ['deleted_at'];

  protected $life_time = 60;
}
```

4) Set up Laravel's scheduler

This package requires the use of the [Task Scheduler](https://laravel.com/docs/5.7/scheduling#introduction). You should make sure that it is configured and running correctly on your system or else this package will do nothing.

```bash
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

## Considerations

This package relies on having a `created_at` field on your `Model`. In this future this would be a configurable field or possibly even removed for just having the current time but for now, this is a requirement of the `Model`.

Another thing to keep in mind is that the `Task` for clearing expired `Model`s runs every minute. This means that the deletion will almost never occur on the exact time of expiry. If there is another way to perform this action I am all ears but this wasn't an issue for my use-case and therefore was a limitation I was happy to accept.
