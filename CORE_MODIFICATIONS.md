# Core Modifications

This document tracks modifications made to the Botble core files. These changes must be reapplied or verified after any Botble update.

## 1. FormHelper Type Compatibility
**File:** `platform/core/base/src/Forms/FormHelper.php`
**Date:** 2026-01-24
**Reason:** Compatibility issue with `kris/laravel-form-builder`. The parent class in the installed version does not use strict types, but Botble's `FormHelper` did, causing a fatal error during deployment.

**Changes:**
1. Removed strict type declarations from `addCustomField` method.
2. Removed strict type declarations from `hasCustomField` method.

**Original Code (`addCustomField`):**
```php
public function addCustomField(string $name, string $class): string
{
    if (! $this->hasCustomField($name)) {
        return $this->customTypes[$name] = $class;
    }
    throw new InvalidArgumentException('Custom field [' . $name . '] already exists on this form object.');
}
```

**Modified Code (`addCustomField`):**
```php
public function addCustomField($name, $class)
{
    if (! $this->hasCustomField($name)) {
        return $this->customTypes[$name] = $class;
    }
    throw new InvalidArgumentException('Custom field [' . $name . '] already exists on this form object.');
}
```

**Original Code (`hasCustomField`):**
```php
public function hasCustomField(string $name): bool
{
    return array_key_exists($name, $this->customTypes);
}
```

**Modified Code (`hasCustomField`):**
```php
public function hasCustomField($name)
{
    return array_key_exists($name, $this->customTypes);
}
```

## 2. FormAbstract Type Compatibility
**File:** `platform/core/base/src/Forms/FormAbstract.php`
**Date:** 2026-01-25
**Reason:** Same compatibility issue with `kris/laravel-form-builder`.

**Original Code (`add`):**
```php
public function add(string $name, string $type = 'text', array|Arrayable $options = [], bool $modify = false): static
```

**Modified Code (`add`):**
```php
public function add($name, $type = 'text', array $options = [], $modify = false)
```

**Original Code (`addField`):**
```php
protected function addField(FormField $field, bool $modify = false): static
```

**Modified Code (`addField`):**
```php
protected function addField(FormField $field, $modify = false)
```

## 3. TableAbstract Type Compatibility
**File:** `platform/core/table/src/Abstracts/TableAbstract.php`
**Date:** 2026-01-25
**Reason:** Compatibility issue with `yajra/laravel-datatables-oracle`. The child class included `AnonymousResourceCollection` in the union type which was not present in the parent class `Yajra\DataTables\Services\DataTable::applyScopes`.

**Original Code (`applyScopes`):**
```php
protected function applyScopes(
    EloquentBuilder|QueryBuilder|EloquentRelation|Collection|AnonymousResourceCollection $query
): EloquentBuilder|QueryBuilder|EloquentRelation|Collection|AnonymousResourceCollection
```

**Modified Code (`applyScopes`):**
```php
protected function applyScopes(
    EloquentBuilder|QueryBuilder|EloquentRelation|Collection $query
): EloquentBuilder|QueryBuilder|EloquentRelation|Collection
```

## 4. FormFront Type Compatibility
**File:** `platform/packages/theme/src/FormFront.php`
**Date:** 2026-01-25
**Reason:** Compatibility issue with `FormAbstract` (which was modified to match `laravel-form-builder`). The child class `FormFront` had strict types that were no longer compatible with the parent `FormAbstract` loose types.

**Original Code (`renderForm`):**
```php
public function renderForm(array $options = [], bool $showStart = true, bool $showFields = true, bool $showEnd = true): string
```

**Modified Code (`renderForm`):**
```php
public function renderForm(array $options = [], $showStart = true, $showFields = true, $showEnd = true): string
```


