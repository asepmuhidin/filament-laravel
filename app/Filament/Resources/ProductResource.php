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
use Filament\Forms\Components\Section;
use Filament\Notifications\Notification;
use Filament\Forms\Components\Group;
use Illuminate\Support\Str;
use Filament\Forms\Set;
use Carbon\Carbon;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-circle-stack';

    protected static ?string $navigationGroup = 'Data Management';

    protected static ?string $navigationLabel = 'Products';

    protected static ?int $navigationSort = 1;


    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    
    public static function form(Form $form): Form
    {
        
        return $form
            ->schema([
                Group::make()
                    ->schema([
                        Section::make('Product Information')
                            ->collapsible()                        
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label('Product Name')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur:true)
                                    ->afterStateUpdated(function (string $operation, $state,Set $set) {
                                        if($operation !=='create'){
                                            return ;
                                        }
                                        $sku=Product::generateSKU();
                                        $set('slug', Str::slug($state));
                                        $set('sku', $sku);
                                    })
                                    ->columnSpan(2),
                                Forms\Components\TextInput::make('slug')
                                    ->required()
                                    ->readOnly(true)
                                    ->maxLength(255)
                                    ->columnSpan(2),   
                                Forms\Components\TextInput::make('sku')
                                    ->required()
                                    ->label("SKU")
                                    ->readOnly(true)
                                    ->maxLength(255)
                                    ->columnSpan(1),    
                                Forms\Components\MarkDownEditor::make('description')
                                    ->columnSpanFull(),     
                            ])->columns(5),
                        Section::make('Price and Quantity')
                        ->schema([
                            Forms\Components\TextInput::make('price')
                                ->required()
                                ->numeric()
                                ->default(0.00)
                                ->prefix('Rp.'),
                            Forms\Components\TextInput::make('quantity')
                                ->required()
                                ->numeric()
                                ->default(0),
                        ])->columns(2),  
                    ])->columns(2)->columnspan(2),
                
                Group::make()
                    ->schema([
                        Section::make('Image')
                            ->schema([
                                Forms\Components\Select::make('category_id')
                                ->relationship('category', 'name')
                                ->required(),
                            Forms\Components\Select::make('brand_id')
                                ->relationship('brand', 'name')
                                ->required(),      
                        Forms\Components\FileUpload::make('image')
                            ->image()
                            ->imageEditor()
                            ->disk('public')
                            ->directory('images/product/'.Carbon::now()->format('FY'))                            ,
                        Forms\Components\Toggle::make('status')
                        ])
                    ])->columns(1)        
           ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image'),
                Tables\Columns\TextColumn::make('sku')
                ->label('SKU')
                ->searchable(),
            Tables\Columns\TextColumn::make('name')
                ->searchable(),
            Tables\Columns\TextColumn::make('slug')
                ->searchable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('brand.name')
                          ->sortable(),
             
                
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('price')
                    ->money()
                    ->sortable(),
                Tables\Columns\TextColumn::make('quantity')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'view' => Pages\ViewProduct::route('/{record}'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
