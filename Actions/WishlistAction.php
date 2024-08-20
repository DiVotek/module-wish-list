<?php

namespace Modules\Wishlist\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Wishlist\Models\Wishlist;

class WishlistAction
{
    use AsAction;

    public function handle(int $user_id, int $product_id): int
    {
        if (!Wishlist::query()->where('user_id', $user_id)->where('product_id', $product_id)->exists()) {
            Wishlist::query()->create(['user_id' => $user_id, 'product_id' => $product_id]);
        }
        return Wishlist::query()->where('user_id', $user_id)->count();
    }
}
