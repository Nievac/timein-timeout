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
use Filament\Tables\Actions\Action;
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
                    ->disabled(fn($record) => $record && $record->user_id != auth()->user()->id )
                    ->maxLength(65535),
                Forms\Components\TextInput::make('status')
                    ->required()
                    ->maxLength(255)
                    ->disabled(),
                Forms\Components\Textarea::make('approval_message')
                    ->required()
                    ->maxLength(65535)
                    ->columnSpanFull()
                    ->disabled(fn($record) => $record && !(is_null($record->status) || $record->status == TimeEntryCorrectionStatus::PENDING) )
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

            ])
            ->filtersFormColumns(3)
            ->deferFilters()
            ->actions([
                Action::make('Approve')
                    ->requiresConfirmation()
                    ->form([
                        \Filament\Forms\Components\TextArea::make('approval_message')->label('Approval Message'),
                    ])
                    ->action(function ($record, $data){
                        $record->update([
                            'status' => TimeEntryCorrectionStatus::APPROVED,
                            'approval_message' => $data['approval_message'],
                            'resolved_timestamp' => now(),
                        ]);
                    })
                    ->visible(fn($record) => is_null($record->status) || $record->status === TimeEntryCorrectionStatus::PENDING),
                Action::make('Reject')
                    ->requiresConfirmation()
                    ->form([
                        \Filament\Forms\Components\TextArea::make('approval_message')->label('Rejection Message'),
                    ])
                    ->action(function ($record, $data){
                        $record->update([
                            'status' => TimeEntryCorrectionStatus::REJECTED,
                            'approval_message' => $data['approval_message'],
                            'resolved_timestamp' => now(),
                        ]);
                    })->color('danger')
                    ->visible(fn($record) => is_null($record->status) || $record->status === TimeEntryCorrectionStatus::PENDING),
                Tables\Actions\ViewAction::make()
                    ->extraModalFooterActions(fn (Action $action): array => [
                        Action::make('Approve')
                            ->requiresConfirmation()
                            ->form([
                                \Filament\Forms\Components\TextArea::make('approval_message')->label('Approval Message'),
                            ])
                            ->action(function ($record, $data){
                                dump($record);
                                $record->update([
                                    'status' => TimeEntryCorrectionStatus::APPROVED,
                                    'approval_message' => $data['approval_message'],
                                    'resolved_timestamp' => now(),
                                ]);
                            }),
                    ])
                    ->action(function (array $data, array $arguments): void {
                        // Create

                        if ($arguments['another'] ?? false) {
                            // Reset the form and don't close the modal
                        }
                    }),
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
