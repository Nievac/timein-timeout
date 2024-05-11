<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TimeEntryResource\Pages;
use App\Filament\Resources\TimeEntryResource\RelationManagers;
use App\Models\TimeEntry;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TimeEntryResource extends Resource
{
    protected static ?string $model = TimeEntry::class;

    protected static ?string $navigationIcon = 'heroicon-o-list-bullet';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                \Filament\Forms\Components\Select::make('user_id')
                    ->relationship(
                        name: 'user_not_admin',
                        titleAttribute: 'name',
                    )
                    ->label('User')
                    ->required()
                ,\Filament\Forms\Components\DateTimePicker::make('date_time_entry')
                    ->default(now())
                    ->required()
                ,\Filament\Forms\Components\Select::make('time_entry_type')
                    ->options(\App\Enums\TimeEntryType::getList())
                    ->label('Type')
                    ->required()

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                \Filament\Tables\Columns\TextColumn::make('user_not_admin.name')
                    ->label('Name')
                ,\Filament\Tables\Columns\TextColumn::make('date_time_entry')
                    ->label('Time')
                ,\Filament\Tables\Columns\TextColumn::make('time_entry_type')
                    ->formatStateUsing(fn (string $state): string => \App\Enums\TimeEntryType::getList()[$state])
                    ->label('Type')
            ])
            ->filters([
                //
            ])
            ->actions([
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
            'index' => Pages\ListTimeEntries::route('/'),
            'create' => Pages\CreateTimeEntry::route('/create'),
            'edit' => Pages\EditTimeEntry::route('/{record}/edit'),
        ];
    }
}
