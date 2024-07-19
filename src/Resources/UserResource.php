<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    public static function getModel(): string
    {
        return config('g4t-filament-access-control.models.user');
    }

    public static function getNavigationIcon(): string | Htmlable | null
    {
        return config('g4t-filament-access-control.icons.users');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        TextInput::make('name')->required(),
                        TextInput::make('email')->required()->email()->unique(table: static::$model, ignorable: fn ($record) => $record),
                        TextInput::make('password')->same('passwordConfirmation')->password()->maxLength(255)->required(fn ($component, $get, $livewire, $model, $record, $set, $state) => $record === null)->dehydrateStateUsing(fn ($state) => !empty($state) ? Hash::make($state) : ''),
                        TextInput::make('passwordConfirmation')->password()->dehydrated(false)->maxLength(255),
                        Select::make('roles')->multiple()->relationship('roles', 'name'),
                    ])->columns(2),
            ]);
    }
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('name')->searchable()->sortable(),
                TextColumn::make('email')->searchable()->sortable(),
                IconColumn::make('email_verified_at')->default(false)->boolean()->label("verified"),
                TextColumn::make('roles.name')->badge()->label("Roles"),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
