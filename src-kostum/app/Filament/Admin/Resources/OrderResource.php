<?php

namespace App\Filament\Admin\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Order;
use App\Models\Kostum;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Filament\Admin\Resources\OrderResource\Pages;
use Filament\Forms\Components\{DatePicker, Hidden, Repeater, Select, TextInput, Textarea};

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;
    protected static ?string $navigationIcon  = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Order';
    protected static ?string $navigationGroup = 'Order Management';

    /* ------------------------------------------------------------------ */
    /*  FORM                                                              */
    /* ------------------------------------------------------------------ */
    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Card::make([
                TextInput::make('nomor_pesanan')
                    ->label('Nomor Otomatis')
                    ->disabled()
                    ->dehydrated(false),

                Select::make('profile_id')
                    ->label('Profile')
                    ->relationship('profile', 'nama_lengkap')
                    ->required()
                    ->columnSpan(2),

                /* ---------- Kostum via Repeater ---------- */
                Repeater::make('orderItems')
    ->relationship('orderItems')
    ->schema([
        Select::make('kostums_id')
            ->label('Kostum')
            ->relationship('kostums', 'nama_kostum')
            ->searchable()
            ->required()
            ->reactive()
            ->afterStateUpdated(fn ($state, $set) =>
                $set('harga_sewa', \App\Models\Kostum::find($state)?->harga_sewa ?? 0)
            )
            ->afterStateHydrated(fn ($set, $get) =>
                $set('harga_sewa', \App\Models\Kostum::find($get('kostums_id'))?->harga_sewa ?? 0)
            ),

        TextInput::make('durasi_sewa')
            ->label('Durasi (hari)')
            ->numeric()
            ->disabled()
            ->default(fn ($get) => $get('../../durasi_sewa'))
            ->dehydrated(),

        TextInput::make('harga_sewa')
            ->label('Harga Sewa')
            ->numeric()
            ->readOnly()     // hanya tampil, tak bisa diubah
            ->required()     // kolom DB NOT NULL
            ->dehydrated()   // wajib supaya ikut payload
            ->default(0),
    ])
    ->columns(2),

                DatePicker::make('tanggal_order')
                    ->label('Order Date')
                    ->required()
                    ->columnSpan(2),

                DatePicker::make('tanggal_batas_sewa')
                    ->label('Rental End Date')
                    ->required()
                    ->columnSpan(2),

                TextInput::make('total_harga')
                    ->label('Total Harga')
                    ->numeric()
                    ->required()
                    ->columnSpan(2),

                Select::make('status')
                    ->label('Status')
                    ->options([
                        'Menunggu'      => 'Menunggu',
                        'Diproses'      => 'Diproses',
                        'Siap Di Ambil' => 'Siap Di Ambil',
                        'Selesai'       => 'Selesai',
                    ])
                    ->default('Menunggu')
                    ->required(),

                Textarea::make('alamat_toko')
                    ->label('Alamat Toko')
                    ->required()
                    ->columnSpanFull(),
            ])->columns(2),
        ]);
    }

    /* ------------------------------------------------------------------ */
    /*  TABLE                                                             */
    /* ------------------------------------------------------------------ */
    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('nomor_pesanan')->label('No'),
            Tables\Columns\TextColumn::make('profile.nama_lengkap')->label('Profile'),
            Tables\Columns\TextColumn::make('kostum_summary')
                ->label('Kostum')
                ->html()
                ->getStateUsing(fn ($record) =>
                    $record->orderItems
                        ->map(fn ($item) => optional($item->kostums)->nama_kostum)
                        ->filter()
                        ->implode('<br>')
                ),
            Tables\Columns\TextColumn::make('tanggal_order')->date()->label('Order'),
            Tables\Columns\TextColumn::make('tanggal_batas_sewa')->date()->label('End'),
            Tables\Columns\TextColumn::make('durasi_sewa')->label('Durasi'),
            Tables\Columns\TextColumn::make('total_harga')->label('Total')->money('IDR'),
            Tables\Columns\TextColumn::make('status')->label('Status'),
        ])
        ->actions([
            Tables\Actions\EditAction::make(),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit'   => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
