<?php

namespace Modules\Wishlist\Admin\WishlistResource\Pages;

use Filament\Infolists\Components\KeyValueEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;
use Modules\Wishlist\Admin\WishlistResource;
use Modules\Wishlist\Models\Wishlist;

class ViewWishlists extends ViewRecord
{
    protected static string $resource = WishlistResource::class;

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make($infolist->record->user->email)
                    ->schema([
                        KeyValueEntry::make('products')
                            ->columnSpanFull()
                            ->hiddenLabel()
                            ->keyLabel(__('Products'))
                            ->valueLabel(__('Added'))
                            ->getStateUsing(function ($record) {
                                $wishlists = Wishlist::query()->where('user_id', $record->user->id)->get();
                                $products = [];

                                foreach ($wishlists as $wishlist) {
                                    $products[$wishlist->product->name] = $wishlist->created_at->format('d.m.Y');
                                }

                                return $products;
                            })
                    ])
            ]);
    }
}
