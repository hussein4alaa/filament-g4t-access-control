<?php

namespace App\Filament\Resources\PermissionResource\RelationManager;

use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\AttachAction;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DetachAction;
use Spatie\Permission\PermissionRegistrar;
use Filament\Tables\Actions\DissociateBulkAction;
use Filament\Resources\RelationManagers\RelationManager;
use Illuminate\Database\Eloquent\Model;

class RoleRelationManager extends RelationManager
{
    protected static string $relationship = 'roles';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return config('g4t-filament-access-control.titles.roles');
    }

    protected static function getRecordLabel(): ?string
    {
        return config('g4t-filament-access-control.titles.role');
    }


    protected static ?string $recordTitleAttribute = 'name';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->unique()->columnSpanFull(),
                TextInput::make('email')->required()->columnSpanFull(),

                TextInput::make('guard_name')->default('web')->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('guard_name'),

            ])
            ->headerActions([
                CreateAction::make(),
                AttachAction::make()->preloadRecordSelect(true)->recordSelect(fn($select) => $select->multiple())->closeModalByClickingAway(false),
            ])
            ->actions([
                DetachAction::make()
            ])

            ->bulkActions([

                DissociateBulkAction::make(),

            ]);
    }

    public function afterAttach(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }

    public function afterDetach(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }

    public function isReadOnly(): bool
    {
        return false;
    }
}
