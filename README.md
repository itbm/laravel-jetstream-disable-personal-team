# Jetstream Disable Personal Team

This package allows you to disable the personal team feature in Jetstream.

## Requirements

This package requires Laravel 10.x and Jetstream 2.x.

## Installation

You can install the package via composer:

```bash
composer require itbm/laravel-jetstream-disable-personal-team
```

## Usage

After installing the package, you can disable the personal team feature by replacing the `HasTeams` trait in your `User` model:

```php
// use Laravel\Jetstream\HasTeams;
use ITBM\DPT\Traits\HasTeams;

class User extends Authenticatable
{
    use HasTeams;
}
```

Then you will need to update your `CreateNewUser.php` file to comment out the personal team creation logic:

```php
return DB::transaction(function () use ($input) {
    return tap(User::create([
        'name' => $input['name'],
        'email' => $input['email'],
        'password' => Hash::make($input['password']),
    ]), function (User $user) {
        // $this->createTeam($user);
    });
});
```

Next you will need to update your `AppLayout.vue` file to hide the team dropdown from the navigation before the user has joined a team. Find and replace these 2 lines:

```javascript
<Dropdown v-if="$page.props.jetstream.hasTeamFeatures" align="right" width="60">

<template v-if="$page.props.jetstream.hasTeamFeatures">
```
with:

```javascript
<Dropdown v-if="$page.props.jetstream.hasTeamFeatures && $page.props.auth.user.all_teams.length > 0" align="right" width="60">

<template v-if="$page.props.jetstream.hasTeamFeatures && $page.props.auth.user.all_teams.length > 0">
```

Finally, edit `web.php` and `api.php` to include the `require-team` middleware. This will redirect the user to the team creation page if they have not joined a team yet:

```php
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'require-team',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});
```
