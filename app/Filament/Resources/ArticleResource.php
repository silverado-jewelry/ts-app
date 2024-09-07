<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArticleResource\Pages;
use App\Filament\Resources\ArticleResource\RelationManagers;
use App\Models\Article;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ArticleResource extends Resource
{
    /** @var string|null */
    protected static ?string $model = Article::class;

    /** @var string|null */
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    /**
     * @param Form $form
     * @return Form
     */
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label('Title')
                    ->maxLength(255)
                    ->columnSpan(2)
                    ->required(),
                Forms\Components\RichEditor::make('body')
                    ->label('Body')
                    ->maxLength(65535)
                    ->columnSpan(2)
                    ->required(),
                Forms\Components\DatePicker::make('publish_at')
                    ->label('Publication Date')
                    ->required(),
            ]);
    }

    /**
     * @param Table $table
     * @return Table
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('publish_at')
                    ->label('Publication Date')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->searchable()
                    ->label('Author'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    /**
     * @return array|\Filament\Resources\RelationManagers\RelationGroup[]|\Filament\Resources\RelationManagers\RelationManagerConfiguration[]|string[]
     */
    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListArticles::route('/'),
            'create' => Pages\CreateArticle::route('/create'),
            'edit' => Pages\EditArticle::route('/{record}/edit'),
        ];
    }

    /**
     * @param Article $record
     * @return bool
     */
    public static function canDelete($record): bool
    {
        return $record->user_id === auth()->id() && parent::canDelete($record);
    }

    /**
     * @param Article $record
     * @return bool
     */
    public static function canEdit($record): bool
    {
        return $record->user_id === auth()->id() && parent::canEdit($record);
    }

    /**
     * @param Model $record
     * @return bool
     */
    public static function canForceDelete(Model $record): bool
    {
        return $record->user_id === auth()->id() && parent::canForceDelete($record);
    }
}
