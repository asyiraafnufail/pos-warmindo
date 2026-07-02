<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MenuResource\Pages;
use App\Models\Menu;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class MenuResource extends Resource
{
    protected static ?string $model = Menu::class;

    protected static ?string $navigationIcon = 'heroicon-o-square-3-stack-3d';
    protected static ?string $navigationLabel = 'Kelola Menu';
    protected static ?string $modelLabel = 'Menu';
    protected static ?string $pluralModelLabel = 'Kelola Menu';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Master Data Menu')
                    ->description('Pastikan data menu makanan dan minuman Warmindo terinput dengan valid.')
                    ->schema([
                        Forms\Components\TextInput::make('nama_menu')
                            ->label('Nama Menu / Varian')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\Select::make('kategori')
                            ->label('Golongan Kategori')
                            ->options([
                                'Makanan' => 'Makanan',
                                'Minuman' => 'Minuman',
                                'Toping' => 'Toping / Ekstra Porsi',
                            ])
                            ->required(),

                        Forms\Components\TextInput::make('harga')
                            ->label('Harga Jual Kasir')
                            ->numeric()
                            ->prefix('Rp')
                            ->required(),

                        Forms\Components\TextInput::make('stok')
                            ->label('Ketersediaan Stok')
                            ->numeric()
                            ->default(0)
                            ->required(),
                    ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_menu')
                    ->label('Nama Item Varian')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('kategori')
                    ->label('Kategori')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Makanan' => 'warning',
                        'Minuman' => 'info',
                        'Toping' => 'success',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('harga')
                    ->label('Harga Jual')
                    ->numeric(thousandsSeparator: '.')
                    ->prefix('Rp ')
                    ->sortable(),

                Tables\Columns\TextColumn::make('stok')
                    ->label('Sisa Stok Gudang')
                    ->numeric()
                    ->sortable()
                    ->badge()
                    ->color(fn (int $state): string => $state <= 10 ? 'danger' : 'gray'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('kategori')
                    ->options([
                        'Makanan' => 'Makanan',
                        'Minuman' => 'Minuman',
                        'Toping' => 'Toping',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMenus::route('/'),
            'create' => Pages\CreateMenu::route('/create'),
            'edit' => Pages\EditMenu::route('/{record}/edit'),
        ];
    }
}