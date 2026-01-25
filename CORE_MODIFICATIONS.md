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
