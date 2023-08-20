# Jetstream Disable Personal Team

This package allows you to disable the personal teams in Laravel Jetstream.

## Requirements

This package requires Laravel 10.x and Jetstream 2.x.

## Installation

You can install the package via composer:

```bash
composer require itbm/laravel-jetstream-disable-personal-team
```

## Usage

### All

Update your `CreateNewUser.php` file to comment out the personal team creation logic:

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

Then, edit `web.php` and `api.php` to include the `require-team` middleware included with this package. This will redirect the user to the team creation page if they have not joined a team yet:

```php
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'require-team',
])->group(function () {
    // ...
});
```

### Inertia Only

You will need to update your `AppLayout.vue` file. Find and replace these 2 lines:

```javascript
<Dropdown v-if="$page.props.jetstream.hasTeamFeatures" align="right" width="60">

<template v-if="$page.props.jetstream.hasTeamFeatures">
```
with:

```javascript
<Dropdown v-if="$page.props.jetstream.hasTeamFeatures && $page.props.auth.user.current_team" align="right" width="60">

<template v-if="$page.props.jetstream.hasTeamFeatures && $page.props.auth.user.current_team">
```

### Livewire Only

You will need to update your `navigation-menu.blade.php` file. Find and replace both instances of this line:

```blade
@if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
```
with:
```blade  
@if (Laravel\Jetstream\Jetstream::hasTeamFeatures() && Auth::user()->currentTeam)
```
