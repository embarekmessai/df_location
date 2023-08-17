<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-square-3-stack-3d';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\TextInput::make('name')
                                        ->label(__('product_name'))
                                        ->required()
                                        ->maxLength(255),

                Forms\Components\TextInput::make('price')
                                        ->numeric()
                                        ->inputMode('decimal')
                                        ->step(0.01)
                                        ->label(__('price'))
                                        ->required(),

                Forms\Components\TextInput::make('caution')
                                        ->numeric()
                                        ->inputMode('decimal')
                                        ->step(0.01)
                                        ->label(__('caution'))
                                        ->required(),

                Forms\Components\FileUpload::make('photo')
                                        ->label(__('photo')),

                Forms\Components\FileUpload::make('images')
                                        ->multiple()
                                        ->label(__('images')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('photo')->label(__('photo')),
                Tables\Columns\TextColumn::make('name')->label(__('product_name'))->searchable()->sortable(),
                Tables\Columns\TextColumn::make('location.status')->label(__('status'))
                                        ->badge()
                                        ->color(fn (string $status): string => match ($status) {
                                            'Disponibe' => 'success',
                                            'Non disponible' => 'danger',
                                        })
                                        ->searchable()->sortable(),
                Tables\Columns\TextColumn::make('price')->label(__('price'))->money('eur'),
                Tables\Columns\TextColumn::make('caution')->label(__('caution'))->money('eur'),
            ])
            ->filters([
                Tables\Filters\Filter::make('status')
                ->query(fn (Builder $query): Builder => $query->whereHas('location', fn($q) => $q->where('status', 0)))
                ->toggle(),
            // ...
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
