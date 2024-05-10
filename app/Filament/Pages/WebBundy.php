<?php

namespace App\Filament\Pages;

use App\Enums\TimeEntryType;
use App\Models\TimeEntry;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;

class WebBundy extends Page implements HasForms, HasActions, HasTable
{

    use InteractsWithActions;
    use InteractsWithForms;
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-clock';

    protected static string $view = 'filament.pages.web-bundy';

    public function test1() {

    }

    public function timeInAction(): Action
    {
        return Action::make('timeIn')
            ->requiresConfirmation()
            ->color('success')
            ->action(fn () => $this->saveTimeEntry(TimeEntryType::IN));
    }

    public function timeOutAction(): Action
    {
        return Action::make('timeOut')
            ->requiresConfirmation()
            ->color('danger')
            ->disabled(function() {
               return TimeEntry::where('user_id', auth()->user()->id)
                    ->orderByDesc('created_at')->first()
                    ?->time_entry_type == TimeEntryType::OUT;
            })
            ->action(fn () => $this->saveTimeEntry(TimeEntryType::OUT));
    }

    protected function saveTimeEntry($type) {
        return TimeEntry::create([
            'user_id' => auth()->user()->id,
            'date_time_entry' => now(),
            'time_entry_type' => $type,
         ]);
    }

    public function table(Table $table): Table {
        return $table
            ->query(TimeEntry::query()->where('user_id', auth()->user()->id))
            ->columns([
                TextColumn::make('time_entry_type')
                    ->color(fn (string $state): string => match ($state) {
                        TimeEntryType::IN => 'success',
                        TimeEntryType::OUT => 'danger',
                    }),
                TextColumn::make('date_time_entry'),
            ])
            ->filters([
                // ...
            ])
            ->actions([
                // ...
            ])
            ->bulkActions([
                // ...
            ]);
    }


}
