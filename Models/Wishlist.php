<?php

namespace Modules\Wishlist\Models;

use App\Models\User;
use App\Traits\HasTable;
use App\Traits\HasTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Product\Models\Product;
use Nwidart\Modules\Facades\Module;

class Wishlist extends Model
{
    use HasFactory;
    use HasTable;
    use HasTimestamps;

    protected $fillable = ['user_id', 'product_id'];

    public static function getDb(): string
    {
        return 'wishlists';
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(  User::class);
    }

    public function product()
    {
        if (Module::find('Product') && Module::find('Product')->isEnabled()) {
            return $this->belongsTo(  Product::class);
        }
    }
}
