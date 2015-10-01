# Paginator Bundle
---

Yet another paginator bundle.
 - Extracts the page number from the URL.
 - Extracts the maximum amount of items to show from the URL.
 - Works out the offset of items by using the page number + maximum amount of items to show.

# Installation
---

## Step 1: Download the Bundle

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```bash
$ composer require kieranbamforth/paginator-bundle "~1"
```

This command requires you to have Composer installed globally, as explained
in the [installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

## Step 2: Enable the Bundle

Then, enable the bundle by adding it to the list of registered bundles
in the `app/AppKernel.php` file of your project:

```php
<?php
// app/AppKernel.php

// ...
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // ...
            new KieranBamforth\Bundle\PaginatorBundle\KBPaginatorBundle(),
        );

        // ...
    }

    // ...
}
```

# Usage
---
## Step 1: Inject  PaginatedRequest into Controller Actions
The bundle will automatically inject a PaginatedRequest object into any controller action that takes PaginatedRequest as a parameter.

The PaginatedRequest object extends the Symfony Request object, and can be alongside / in lieu of the Symfony Request object.
```php
// src/AppBundle/Controller/HelloController.php
namespace AppBundle\Controller;

use KieranBamforth\Bundle\PaginatorBundle\HttpFoundation\PaginatedRequest;
use Symfony\Component\HttpFoundation\Response;

class HelloController
{
    public function indexAction($name, PaginatedRequest $request)
    {
        return new Response(sprintf(
            'Showing a maximum of %s results on page %s. The offset is %s.',
            $request->getMaxResults(),
            $request->getPage(),
            $request->getOffset()
        ));
    }
}
```
## Step 2: Use it!
```
GET /?page=1&max_results=5 HTTP/1.1
> Host: www.example.com
> ...
>
< HTTP/1.1 200 OK
< ...
<
< Showing a maximum of 5 results on page 1. The offset is 1.
```
