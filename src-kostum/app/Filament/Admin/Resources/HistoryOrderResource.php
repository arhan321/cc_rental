<?php

namespace App\Filament\Admin\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Order;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Admin\Resources\HistoryOrderResource\Pages;
use App\Filament\Admin\Resources\HistoryOrderResource\RelationManagers;

class HistoryOrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
    protected static ?string $navigationLabel = 'History Orders';  // Label yang muncul di menu navigasi
    protected static ?string $navigationGroup = 'Order Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(Order::where('status', 'Selesai')) // Menyaring hanya order dengan status 'Selesai'
            ->columns([
                Tables\Columns\TextColumn::make('nomor_pesanan') // Menampilkan Kode Order
                    ->label('Order ID')
                    ->sortable(),
                Tables\Columns\TextColumn::make('profile.nama_lengkap') // Nama customer dari relasi profile
                    ->label('Customer Name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('tanggal_order') // Tanggal order
                    ->label('Order Date')
                    ->sortable()
                    ->date(),
                Tables\Columns\TextColumn::make('tanggal_batas_sewa') // Tanggal batas sewa
                    ->label('Rental End Date')
                    ->sortable()
                    ->date(),
                Tables\Columns\TextColumn::make('total_harga') // Total harga
                    ->label('Total Price')
                    ->sortable()
                    ->money('IDR'),
                Tables\Columns\TextColumn::make('status') // Status yang hanya akan menampilkan 'Selesai'
                    ->label('Status'),
            ])
            ->filters([ // Bisa menambahkan filter jika diperlukan
                // Add filters here
            ])
            ->actions([
                Tables\Actions\ViewAction::make() // Menambahkan aksi untuk melihat detail order
                    ->extraAttributes(['class' => 'bg-indigo-600 text-white rounded-lg py-2 px-4 hover:bg-indigo-700 transition-all']),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make() // Menambahkan bulk delete action
                        ->extraAttributes(['class' => 'bg-red-500 text-white hover:bg-red-600 transition-all rounded-lg py-2 px-4']),
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
            'index' => Pages\ListHistoryOrders::route('/'),
            'create' => Pages\CreateHistoryOrder::route('/create'),
            'edit' => Pages\EditHistoryOrder::route('/{record}/edit'),
        ];
    }
}
