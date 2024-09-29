<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PropertyResource\Pages;
use App\Filament\Resources\PropertyResource\RelationManagers;
use App\Models\Property;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PropertyResource extends Resource
{
    protected static ?string $model = Property::class;

    public static function getModelLabel(): string
    {
        return __('Property');
    }

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(3) // Grid para o layout
                ->schema([
                    Forms\Components\TextInput::make('title')
                        ->required()
                        ->maxLength(105)
                        ->translateLabel()
                        ->columnSpanFull(),  // Faz o campo ocupar uma coluna completa
                    Forms\Components\TextInput::make('price')
                        ->required()
                        ->numeric()
                        ->prefix('R$')
                        ->translateLabel(),
                    Forms\Components\TextInput::make('bedrooms')
                        ->required()
                        ->numeric()
                        ->translateLabel(),
                    Forms\Components\TextInput::make('bathrooms')
                        ->required()
                        ->numeric()
                        ->translateLabel(),
                    Forms\Components\TextInput::make('garage_spaces')
                        ->required()
                        ->numeric()
                        ->translateLabel(),
                    Forms\Components\TextInput::make('total_area')
                        ->required()
                        ->numeric()
                        ->translateLabel(),
                    Forms\Components\TextInput::make('usable_area')
                        ->required()
                        ->numeric()
                        ->translateLabel(),
                    Forms\Components\TextInput::make('neighborhood')
                        ->required()
                        ->maxLength(255)
                        ->translateLabel(),
                    Forms\Components\TextInput::make('city')
                        ->required()
                        ->maxLength(255)
                        ->translateLabel(),
                    Forms\Components\Select::make('category_id')
                        ->relationship('category', 'name') // 'name' é o campo visível da categoria
                        ->required()
                        ->translateLabel(),
                ]),
                Forms\Components\Toggle::make('featured')
                    ->required()
                    ->translateLabel(),
                Forms\Components\RichEditor::make('description')
                    ->required()
                    ->translateLabel()
                    ->columnSpanFull() // Descrição ocupa uma linha inteira
                    ->toolbarButtons([
                       'bold',
                        'h3',
                        'italic',
                        'redo',
                        'strike',
                        'underline',
                        'undo'
                    ]),
                // Seção de Upload de Imagens
                Forms\Components\Repeater::make('property_images') // Nome do campo
                ->relationship('propertyImages')// Relacionamento correto
                ->translateLabel()
                    ->schema([
                        Forms\Components\FileUpload::make('photos')
                            ->label('Fotos do Imóvel')
                            ->image()
                            ->multiple()  // Permitir upload de várias imagens
                            ->maxFiles(6)
                            ->maxSize(80000)  // 800 KB limite
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->disk('public')  // Define o disco de armazenamento como 'public'
                            ->directory('properties')  // Define o diretório onde os arquivos serão salvos
                            ->visibility('public')  // Torna o arquivo publicamente acessível
                    ])
                    ->columnSpanFull(), // O Repeater ocupa uma linha inteira
            ]);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->translateLabel(),
                Tables\Columns\ToggleColumn::make('featured') // Alterando para ToggleColumn
                ->label('Featured') // Definindo o label da coluna
                ->onColor('success') // Cor quando está ativo (true)
                ->offColor('danger') // Cor quando está inativo (false)
                ->sortable() // Ordenável
                ->toggleable()
                    ->translateLabel(), // Habilita o comportamento de toggle
                Tables\Columns\TextColumn::make('category.name') // Adiciona a coluna de categoria
                ->label('Category') // Definindo o rótulo da coluna
                ->sortable() // Permitir ordenar por categoria
                ->translateLabel(),
                Tables\Columns\TextColumn::make('price')
                    ->money('brl',true)
                    ->sortable()
                    ->translateLabel(),
                Tables\Columns\TextColumn::make('city')
                    ->searchable()
                    ->translateLabel(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->translateLabel(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->translateLabel(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(), // Botão de Editar
                Tables\Actions\DeleteAction::make(), // Botão de Excluir ao lado do Editar
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
            'index' => Pages\ListProperties::route('/'),
            'create' => Pages\CreateProperty::route('/create'),
            'edit' => Pages\EditProperty::route('/{record}/edit'),
        ];
    }
}
