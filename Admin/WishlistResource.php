<?php

namespace Modules\Wishlist\Admin;

use App\Models\Setting;
use App\Services\Schema;
use App\Services\TableSchema;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Modules\Wishlist\Admin\WishlistResource\Pages;
use Modules\Wishlist\Models\Wishlist;

class WishlistResource extends Resource
{
    protected static ?string $model = Wishlist::class;

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()->withoutGlobalScopes();
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationGroup(): ?string
    {
        return __('Sales');
    }

    public static function getModelLabel(): string
    {
        return __('Wishlist');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Wishlists');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TableSchema::getUser()
                    ->formatStateUsing(function ($record) {
                        return $record->user->email;
                    }),
                TableSchema::getProduct()
                    ->label(__('Products count'))
                    ->formatStateUsing(function ($record) {
                        return Wishlist::query()->where('user_id', $record->user_id)->count();
                    }),
                TableSchema::getUpdatedAt(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->headerActions([
                Action::make(__('Help'))
                    ->iconButton()
                    ->icon('heroicon-o-question-mark-circle')
                    ->modalDescription(__('Here you can manage blog categories. Blog categories are used to group blog articles. You can create, edit and delete blog categories as you want. Blog category will be displayed on the blog page or inside slider(modules section). If you want to disable it, you can do it by changing the status of the blog category.'))
                    ->modalFooterActions([]),
                Tables\Actions\Action::make('Template')
                    ->slideOver()
                    ->icon('heroicon-o-cog')
                    ->fillForm(function (): array {
                        return [
                            'design' => setting(config('settings.wishlist.design'), 'Base'),
                        ];
                    })
                    ->action(function (array $data): void {
                        setting([
                            config('settings.wishlist.design') => $data['design'],
                        ]);
                        Setting::updatedSettings();
                    })
                    ->form(function ($form) {
                        return $form
                            ->schema([
                                Schema::getModuleTemplateSelect('Pages/Wishlist'),
                                Section::make('')->schema([
                                    Schema::getTemplateBuilder()->label(__('Template')),
                                ]),
                            ]);
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWishlists::route('/'),
            'view' => Pages\ViewWishlists::route('/{record}'),
        ];
    }
}
