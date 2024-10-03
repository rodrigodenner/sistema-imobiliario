<?php

namespace App\Filament\Widgets;

use App\Models\Message;
use App\Models\Property;
use App\Models\User;

// Importando o model User
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class GeneralStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $totalMessage = Message::count();
        $totalProperties = Property::count();  // Contagem de propriedades
        $totalUsers = User::count();  // Contagem de usuários

        return [

            Stat::make('Total de Propriedades', $totalProperties)  // Contagem de propriedades
            ->description('Propriedades cadastradas')  // Descrição do widget
            ->icon('heroicon-o-home')  // Ícone Heroicon (pode escolher outro)
            ->color('success')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),

            Stat::make('Total de Mensagens', $totalMessage)  // Contagem de mensagens
            ->description('Mensagens recebidas')  // Descrição do widget
            ->icon('heroicon-o-inbox')  // Ícone Heroicon
            ->color('primary')
                ->chart([7, 2, 10, 3, 15, 17])
                ->color('primary') ,

            Stat::make('Total de Usuários', $totalUsers)  // Contagem de usuários
            ->description('Usuários cadastrados')  // Descrição do widget
            ->icon('heroicon-o-users')  // Ícone Heroicon
            ->color('info')
                ->chart([7, 2, 10, 3, 15, 17])
                ->color('info') ,
        ];
    }
}
