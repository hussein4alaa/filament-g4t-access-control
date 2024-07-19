<?php

namespace App\Filament\Resources\RoleResource\RelationManager;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\AttachAction;
use Filament\Tables\Actions\DetachAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DissociateBulkAction;
use Filament\Resources\RelationManagers\RelationManager;
use Illuminate\Database\Eloquent\Model;

class UserRelationManager extends RelationManager
{
    protected static string $relationship = 'users';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return config('g4t-filament-access-control.titles.users');
    }

    protected static function getRecordLabel(): ?string
    {
        return config('g4t-filament-access-control.titles.user');
    }


    protected static ?string $recordTitleAttribute = 'email';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->searchable(),
                TextColumn::make('name')->searchable(),
                TextColumn::make('email')->searchable()
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // ...
                AttachAction::make(),
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
    }

    public function afterDetach(): void
    {
    }

    public function isReadOnly(): bool
    {
        return false;
    }
}
