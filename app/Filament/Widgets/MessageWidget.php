<?php

namespace App\Filament\Widgets;

use App\Models\Message;
use Filament\Notifications\Notification;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables\Actions\Action;
use Filament\Forms;

class MessageWidget extends BaseWidget
{
    // Define o modelo que será usado na query da tabela
    protected static ?string $heading = 'Mensagens Recentes'; // Cabeçalho opcional

    // Define que o widget ocupe toda a largura da tela
    protected static ?string $maxHeight = null;



    public function table(Table $table): Table
    {
        return $table
            ->query(Message::query()->orderBy('created_at', 'desc')) // Define a query para buscar as mensagens
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
                // Filtros podem ser definidos aqui, se necessário
            ])
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
                Tables\Actions\DeleteBulkAction::make(),
            ]); // Limita para 5 registros por página
    }
}
