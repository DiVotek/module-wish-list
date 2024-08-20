<?php

namespace Modules\Wishlist\Components;

use App\View\Components\PageComponent;

class WishlistPage extends PageComponent
{
    public function __construct($entity)
    {
        $component = setting(config('settings.wishlist.design'), 'Base');
        $component = 'template.' . strtolower(template()) . '.pages.wishlist.' . strtolower($component);
        parent::__construct($entity, $component);
    }
}
