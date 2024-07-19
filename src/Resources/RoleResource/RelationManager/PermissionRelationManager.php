<?php

namespace App\Filament\Resources\RoleResource\RelationManager;

use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\AttachAction;
use Filament\Tables\Actions\DetachAction;
use Spatie\Permission\PermissionRegistrar;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DetachBulkAction;
use Illuminate\Database\Eloquent\Model;

class PermissionRelationManager extends RelationManager
{
    protected static string $relationship = 'permissions';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return config('g4t-filament-access-control.titles.permissions');
    }

    protected static function getRecordLabel(): ?string
    {
        return config('g4t-filament-access-control.titles.permission');
    }

    protected static ?string $recordTitleAttribute = 'name';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->required(),
                TextInput::make('guard_name')->required()->default('web')
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable(),
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

                DetachBulkAction::make(),

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
