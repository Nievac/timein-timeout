<?php

namespace App\Filament\Resources;

use App\Enums\TimeEntryCorrectionStatus;
use App\Enums\TimeEntryType;
use App\Filament\Resources\TimeEntryCorrectionResource\Pages;
use App\Filament\Resources\TimeEntryCorrectionResource\RelationManagers;
use App\Models\TimeEntryCorrection;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TimeEntryCorrectionResource extends Resource
{
    protected static ?string $model = TimeEntryCorrection::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship(name: 'user', titleAttribute: 'name')
                    ->searchable(['name', 'email'])
                    ->default(auth()->user()->id)
                    ->preload()
                    ->visible(auth()->user()->checkPermissionTo('select user_id TimeEntryCorrection'))
                    ->required(),
                Forms\Components\DatePicker::make('date_to_correct')
                    ->required(),
                Forms\Components\DateTimePicker::make('date_time_entry')
                    ->required(),
                Forms\Components\Select::make('correction_type')
                    ->options(\App\Enums\TimeEntryType::class)
                    ->label('Type')
                    ->required(),
                Forms\Components\Textarea::make('correction_reason')
                    ->required()
                    ->maxLength(65535),
                Forms\Components\TextInput::make('status')
                    ->required()
                    ->maxLength(255)
                    ->visible(auth()->user()->checkPermissionTo('edit status TimeEntryCorrection')),
                Forms\Components\Textarea::make('approval_message')
                    ->required()
                    ->maxLength(65535)
                    ->columnSpanFull()
                    ->visible(auth()->user()->checkPermissionTo('edit approval_message TimeEntryCorrection')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->numeric()
                    ->sortable()
                    ->visible(auth()->user()->hasRole('admin')),
                Tables\Columns\TextColumn::make('approver_id')
                    ->numeric()
                    ->sortable()
                    ->visible(auth()->user()->hasRole('admin')),
                Tables\Columns\TextColumn::make('date_to_correct')
                    ->date('Y-m-d')
                    ->sortable(),
                Tables\Columns\TextColumn::make('date_time_entry')
                    ->dateTime('Y-m-d h:i A')
                    ->sortable(),
                Tables\Columns\TextColumn::make('correction_type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('requested_timestamp')
                     ->dateTime('Y-m-d h:i A')
                    ->sortable(),
                Tables\Columns\TextColumn::make('resolved_timestamp')
                    ->dateTime()
                    ->visible(auth()->user()->hasRole('admin'))
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('correction_type')
                    ->options(TimeEntryType::class),
                SelectFilter::make('status')
                    ->options(TimeEntryCorrectionStatus::class)

            ], layout: FiltersLayout::AboveContent)
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
            'index' => Pages\ListTimeEntryCorrections::route('/'),
            // 'create' => Pages\CreateTimeEntryCorrection::route('/create'),
            // 'view' => Pages\ViewTimeEntryCorrection::route('/{record}'),
            // 'edit' => Pages\EditTimeEntryCorrection::route('/{record}/edit'),
        ];
    }
}
