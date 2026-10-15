# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## What this is

ODOJ ("One Day One Juz") is a Laravel 13 (PHP 8.4+) app for tracking daily Quran recitation reports of WhatsApp study groups (production URL referenced in code: `https://odoj.inisiator.com`). Members submit a daily entry (which juz they read, how many pages, and a time-slot status emoji); each submission re-renders the group's whole daily report and posts it to the group's WhatsApp chat. UI text, flash messages and code comments are largely in Indonesian (e.g. `/laporan` = "report").

## Commands

```bash
composer dev                    # serve + queue:listen + vite, concurrently
php artisan serve               # app only
npm run dev / npm run build     # Vite (Breeze auth pages only, see below)
php artisan migrate             # default DB is sqlite (database/database.sqlite)

php artisan test                # Pest (tests/Unit, tests/Feature)
php artisan test --filter=ProfileTest            # single file/test
./vendor/bin/pest tests/Feature/ProfileTest.php  # alternative
./vendor/bin/pint               # code style (Laravel Pint)
```

`phpunit.xml` has the sqlite `:memory:` override commented out, and `tests/Pest.php` applies `RefreshDatabase`, so running tests as-is **wipes the local `database/database.sqlite`**. Run them with `$env:DB_DATABASE=':memory:'` (PowerShell) or `DB_DATABASE=:memory:` set. Most Breeze feature tests currently fail because the users migration has a required unique `phone` column that `UserFactory` and registration don't fill.

## Architecture

Domain: `Group` → hasMany `Report` → hasMany `ReportEntry`.

- **Group members are not a table.** `groups.member` is a JSON column holding `[{name, whatsapp}, ...]`, converted by a mutator/accessor pair on `Group` (assign a PHP array, read back an array). Adding, removing and editing members means rewriting that whole array (`GroupController::storeMember` / `removeMember`). `groups.whatsapp_id` is the WhatsApp group target the reports are sent to.
- **Report** = one day for one group (`report_date`, plus the names of the duty holders `pj_odoj`, `pj_bersaksi` and `pj_nextday`).
- **ReportEntry** links to a member by **name string only**: `user_id` exists but is unused, and the entries are public (no auth). The daily report matches entries to members with `$entries->firstWhere('name', $member['name'])`, and the per-person statistics page (`/laporan/detail?name=...`, `ReportEntryController::show`) queries by name across all reports. Renaming a member therefore breaks the link to their past entries.
- **WhatsApp flow:** `ReportEntryController::store` saves the entry, builds the full report text (hard-coded template: Ramadan 1446 H header, juz → keycap-emoji map, first character of `status` used as the time-slot emoji, legend), then calls `WhatsappController::sendNotification`, which POSTs to the Fonnte API (`https://api.fonnte.com/send`) using `WHATSAPP_TOKEN` from `.env`. `WhatsappController` is a plain service class resolved via `app(...)`, with no routes. Failures are logged and swallowed. The template contains emoji and Arabic text, so keep files UTF-8 when editing.
- `app/Helpers/Odoj.php` is autoloaded through composer `files` and defines the global `getRandomAyah()`, which makes synchronous `file_get_contents` calls to api.alquran.cloud. It is called from the `layouts/ayat` Blade partial on the group and entry index pages.

### Routing quirks (`routes/web.php`)

- All domain routes (groups, reports, entries, `/laporan*`) are **outside** the `auth` middleware; only profile routes and Breeze's `routes/auth.php` require login.
- Entries are a nested resource with a bare parameter prefix: `Route::resource('{report}/entries', ...)`. The `/laporan` routes are the public entry flow: search → pick report → `entries.create`.
- `reports.create` takes a `{group}` parameter and is registered separately from the resource.
- The custom `/groups/...` member routes must stay above `Route::resource('groups', ...)`.

### Views / frontend

Two separate frontends coexist:
- Domain pages `@extends('layouts.main')`, a prebuilt Bootstrap 5 admin theme served as static files from `public/assets/...` (included via `layouts/css` and `layouts/js`, with jQuery plugins and CDN links). Vite/Tailwind are **not** used there.
- Breeze scaffolding (auth, profile) uses `<x-app-layout>` / `<x-guest-layout>` with Tailwind and Alpine via Vite. Tailwind is v4, configured in CSS (`resources/css/app.css`: `@plugin`, `@source`, `@theme`) and loaded through the `@tailwindcss/vite` plugin. There is no `tailwind.config.js` or PostCSS config.

### Known incomplete code

`GroupController::editMember` contains `dd()`. `GroupController::update` and `destroy` have member-editing logic that doesn't match the resource semantics (for example, `destroy` looks up `$group->group_id`). `ReportEntryController::edit`, `update` and `destroy` are empty stubs. `dashboard.blade.php` extends a non-existent `layouts.dashboard`. Tests are only the Breeze defaults; there are none for the domain.
