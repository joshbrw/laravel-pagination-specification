# Laravel Pagination Specification

The main purpose of this package is to provide a consistent object that represents all of the main values you have to take into account when paginating (i.e. Current Page, Per Page, Appends for the URLs).

This object can then be passed around to methods and used for less verbose method parameters.

# Installing

1. `composer require joshbrw/laravel-pagination-specification`
2. Add the following Service Provider to your `config/app.php` under `provider`:
    ```php
       Joshbrw\PaginationSpecification\PaginationSpecificationServiceProvider::class
    ```

# Usage

The class is bound into the container under the `Joshbrw\PaginationSpecification\PaginationSpecification` interface, and can be overwritten/decorated if required.

For example, injecting into a Controller method:

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Joshbrw\PaginationSpecification\PaginationSpecification;

class UserController extends Controller {
    public function index(
        Request $request,
        PaginationSpecification $paginationSpecification,
        UserRepository $userRepository
    ): View {
        // Reads the `per_page` and `page` values from the request
        $paginationSpecification->fromRequest($request);
        
        // Set how many items we want per page
        $paginationSpecification->setPerPage(30);
        
        // This can now be passed around to other methods, which can typehint it as a dependency
        return $userRepository->get($paginationSpecification);
    }
}
```
