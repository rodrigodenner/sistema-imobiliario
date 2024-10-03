<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MessageResource\Pages;
use App\Filament\Resources\MessageResource\RelationManagers;
use App\Models\Message;
use Filament\Actions\StaticAction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Actions\Action;
use Filament\Notifications\Notification;

class MessageResource extends Resource
{
    protected static ?string $model = Message::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-ellipsis';

    public static function getModelLabel(): string
    {
        return ('Mensagen');
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->translateLabel()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('phone')
                    ->translateLabel()
                    ->tel()
                    ->required()
                    ->maxLength(20),
                Forms\Components\TextInput::make('type')
                    ->translateLabel()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('address')
                    ->translateLabel()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('bedrooms')
                    ->translateLabel()
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('neighborhood')
                    ->translateLabel()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('city')
                    ->translateLabel()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('state')
                    ->translateLabel()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('usable_area')
                    ->translateLabel()
                    ->required()
                    ->numeric()
                    ->default(0.00),
                Forms\Components\TextInput::make('total_area')
                    ->translateLabel()
                    ->required()
                    ->numeric()
                    ->default(0.00),
                Forms\Components\Textarea::make('message')
                    ->translateLabel()
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Checkbox::make('is_read')
                    ->translateLabel(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\CheckboxColumn::make('no_read')
                    ->label('Lida')
                    ->sortable()
                    ->toggleable()
                    ->action(function ($record) {
                        $record->update(['no_read' => !$record->no_read]);
                    }),
                Tables\Columns\TextColumn::make('name')
                    ->translateLabel()
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->translateLabel()
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->translateLabel()
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->translateLabel()
                    ->searchable(),
                Tables\Columns\TextColumn::make('city')
                    ->translateLabel()
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->translateLabel()
                    ->label('Created At')
                    ->dateTime('d/m/Y'), // Exibe a data no formato d/m/Y
            ])
            ->filters([
                //
            ])
            ->defaultSort('created_at', 'desc') // Aplica a ordenação por 'created_at' em ordem decrescente
            ->actions([
                Action::make('view')
                    ->label('Visualizar')
                    ->icon('heroicon-o-eye') // Ícone de olho
                    ->modalHeading('Visualizar')
                    ->form([
                        Forms\Components\Grid::make(2) // Definindo um grid com 2 colunas
                        ->schema([
                            Forms\Components\TextInput::make('name')
                                ->label('Nome')
                                ->default(fn($record) => $record->name),

                            Forms\Components\TextInput::make('email')
                                ->label('Email')
                                ->default(fn($record) => $record->email),

                            Forms\Components\TextInput::make('phone')
                                ->label('Telefone')
                                ->default(fn($record) => $record->phone),

                            Forms\Components\TextInput::make('type')
                                ->label('Tipo')
                                ->default(fn($record) => $record->type),

                            Forms\Components\TextInput::make('address')
                                ->label('Endereço')
                                ->default(fn($record) => $record->address),

                            Forms\Components\TextInput::make('bedrooms')
                                ->label('Quartos')
                                ->default(fn($record) => $record->bedrooms),

                            Forms\Components\TextInput::make('neighborhood')
                                ->label('Bairro')
                                ->default(fn($record) => $record->neighborhood),

                            Forms\Components\TextInput::make('city')
                                ->label('Cidade')
                                ->default(fn($record) => $record->city),

                            Forms\Components\TextInput::make('state')
                                ->label('Estado')
                                ->default(fn($record) => $record->state),

                            Forms\Components\Textarea::make('message')
                                ->label('Mensagem')
                                ->default(fn($record) => $record->message)
                                ->disabled()
                                ->columnSpanFull(), // Ocupa toda a linha
                        ])
                    ])
                    ->action(function ($record) {
                        // Atualiza o campo no banco de dados para marcar como lida
                        $record->update(['no_read' => false]);

                        Notification::make()
                            ->title('Mensagem marcada como lida!')
                            ->success() // Exibe a notificação com estilo de sucesso
                            ->send();
                    })
->disabledForm()
                    ->modalButton('Marcar como Lida') // Renomeia o texto do botão
                    ->modalCloseButton(false) // Remove o botão de fechar no canto superior direito
                    ->closeModalByClickingAway(false), // Desativa o fechamento ao clicar fora do modal

                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListMessages::route('/'),
            //'create' => Pages\CreateMessage::route('/create'),
            //'edit' => Pages\EditMessage::route('/{record}/edit'),
        ];
    }
}
