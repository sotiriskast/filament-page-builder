<?php

namespace Sotiriskast\FilamentPageBuilder\Resources;

use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Illuminate\Support\Str;
use Sotiriskast\FilamentPageBuilder\Models\Page;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('Locales')
                    ->tabs(function () {
                        $tabs = [];
                        foreach (config('app.locales', ['en']) as $locale) {
                            $tabs[] = Forms\Components\Tabs\Tab::make($locale)
                                ->schema([
                                    Forms\Components\TextInput::make("title.{$locale}")
                                        ->required(),
                                    // Dynamic fields based on layout schema will be added here
                                ]);
                        }
                        return $tabs;
                    }),
                Forms\Components\Select::make('layout_id')
                    ->relationship('layout', 'name')
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function ($state, Forms\Set $set) {
                        if (!$state) return;

                        $layout = Layout::find($state);
                        if (!$layout) return;

                        // Dynamically add fields based on layout schema
                        foreach ($layout->fields_schema as $field) {
                            foreach (config('app.locales', ['en']) as $locale) {
                                $fieldComponent = match ($field['type']) {
                                    'text' => Forms\Components\TextInput::make("content.{$locale}.{$field['name']}"),
                                    'textarea' => Forms\Components\Textarea::make("content.{$locale}.{$field['name']}"),
                                    'rich_editor' => Forms\Components\RichEditor::make("content.{$locale}.{$field['name']}"),
                                    default => null,
                                };

                                if ($fieldComponent) {
                                    $set("content.{$locale}.{$field['name']}", null);
                                }
                            }
                        }
                    }),
                Forms\Components\Toggle::make('is_published'),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title'),
                Tables\Columns\TextColumn::make('slug'),
                Tables\Columns\TextColumn::make('layout.name'),
                Tables\Columns\IconColumn::make('is_published')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('layout')
                    ->relationship('layout', 'name'),
                Tables\Filters\TernaryFilter::make('is_published'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit' => Pages\EditPage::route('/{record}/edit'),
        ];
    }
}
