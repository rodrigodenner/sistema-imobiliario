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

    public static function canAccess(): bool
    {
        $user = auth()->user();

        // Permitir acesso se o usuário for 'admin' ou 'corretor'
        return $user->role === 'admin' || $user->role === 'corretor';
    }


    protected static ?string $navigationIcon = 'heroicon-o-home-modern';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('user_id') // Vincula o imóvel ao usuário logado
                ->default(auth()->user()->id)
                    ->translateLabel(),
                Forms\Components\Grid::make(3) // Grid para o layout
                ->schema([
                    Forms\Components\TextInput::make('title')
                        ->required()
                        ->maxLength(105)
                        ->translateLabel(),
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
                    Forms\Components\TextInput::make('CEP')
                        ->required()
                        ->label('CEP'),
                    Forms\Components\TextInput::make('city')
                        ->required()
                        ->maxLength(255)
                        ->translateLabel(),
                    Forms\Components\TextInput::make('slug')
                        ->required()
                        ->maxLength(150)
                        ->label('Slug'),
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
                            ->label(false)
                            ->image()
                            ->imageEditor()
                            ->reorderable()
                            ->multiple()  // Permitir upload de várias imagens
                            ->maxFiles(6)
                            ->maxSize(700000)  // 700 MB limite
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->disk('public')  // Define o disco de armazenamento como 'public'
                            ->directory('properties')
                            ->visibility('public')  // Torna o arquivo publicamente acessível
                    ])
                    ->columnSpanFull(),
            ]);


    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->limit(30)
                    ->searchable()
                    ->translateLabel(),
                Tables\Columns\ToggleColumn::make('featured') // Alterando para ToggleColumn
                ->label('Featured') // Definindo o label da coluna
                ->onColor('success') // Cor quando está ativo (true)
                ->offColor('danger') // Cor quando está inativo (false)
                ->toggleable()
                    ->translateLabel(), // Habilita o comportamento de toggle
                Tables\Columns\TextColumn::make('user.name') // Alterando para acessar o nome do usuário
                ->searchable()
                    ->translateLabel(),
                Tables\Columns\TextColumn::make('category.name') // Adiciona a coluna de categoria
                ->label('Category') // Definindo o rótulo da coluna
                ->translateLabel(),
                Tables\Columns\TextColumn::make('price')
                    ->money('brl', true)
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
                Tables\Actions\ViewAction::make(),//botão para visualizar
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
