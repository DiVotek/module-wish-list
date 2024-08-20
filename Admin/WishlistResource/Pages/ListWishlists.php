<?php

namespace Modules\Wishlist\Admin\WishlistResource\Pages;

use Filament\Resources\Pages\ListRecords;
use Modules\Wishlist\Admin\WishlistResource;

class ListWishlists extends ListRecords
{
    protected static string $resource = WishlistResource::class;
}
