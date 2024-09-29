<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BahanBakuController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProduksiController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\NeracaAwalController;
use App\Http\Controllers\DetailController;
use App\Http\Controllers\AsetController;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'store'])->name('tologin');

Route::group(['middleware' => 'auth'], function () {
    //Log Out
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    //profile
    Route::get('profile/{id}', [ProfileController::class, 'index'])->name('profile');
    Route::put('photo/update/{id}', [ProfileController::class, 'update_profile'])->name('update.photo');
    Route::put('profile/update/{id}', [ProfileController::class, 'update'])->name('update.profile');

    //dashboard
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    //invoice
    Route::get('invoice/orderan/{no}', [InvoiceController::class, 'invoice_orderan'])->name('invoice.order');
    Route::get('invoice/resep/{no}', [InvoiceController::class, 'invoice_resep'])->name('invoice.resep');

    Route::group(['middleware' => 'role:administrator'], function () {
        //users
        Route::get('users', [UsersController::class, 'index'])->name('users');
        Route::post('/users_add', [UsersController::class, 'store'])->name('add.users');
        Route::get('/users/{id}/edit', [UsersController::class, 'edit'])->name('edit.user');
        Route::put('/users', [UsersController::class, 'update'])->name('update.users');
        Route::delete('/users/delete/{id}', [UsersController::class, 'destroy'])->name('delete.users');

        //supplier
        Route::get('supplier', [SupplierController::class, 'index'])->name('supplier');
        Route::post('supplier', [SupplierController::class, 'store'])->name('add.supplier');
        Route::get('/supplier/{id}/edit', [SupplierController::class, 'edit'])->name('edit.supplier');
        Route::put('/supplier', [SupplierController::class, 'update'])->name('update.supplier');
        Route::delete('/supplier/delete/{id}', [SupplierController::class, 'destroy'])->name('delete.supplier');

        //Transaksi
        Route::get('transaksi', [TransaksiController::class, 'index'])->name('transaksi');
        Route::post('/transaksi', [TransaksiController::class, 'store'])->name('transaksi.store');
        Route::delete('/transaksi/delete/{id}', [TransaksiController::class, 'destroy'])->name('transaksi.delete');
        Route::get('invoice/transaksi/{no}', [InvoiceController::class, 'invoice_transaksi'])->name('invoice.transaksi');

        //Transaksi - Kas Keluar
        Route::get('kas_keluar', [TransaksiController::class, 'kas_keluar'])->name('kas');
        Route::post('/kas_keluar', [TransaksiController::class, 'store_kas'])->name('add.kas');
        Route::get('/kas_keluar/{id}/edit', [TransaksiController::class, 'edit_kas'])->name('edit.kas');
        Route::put('/kas_keluar', [TransaksiController::class, 'update_kas'])->name('update.kas');
        Route::delete('/kas_keluar/delete/{id}', [TransaksiController::class, 'destroy_kas'])->name('delete.kas');

        //Margin
        Route::post('/transaksi/store-margin', [TransaksiController::class, 'store_Margin'])->name('transaksi.store_margin');
        Route::put('/transaksi/update-margin/{id}', [TransaksiController::class, 'update_Margin'])->name('transaksi.update_margin');

        //laporan
        Route::get('laporan/neraca', [LaporanController::class, 'index'])->name('lap.neraca');
        Route::get('laporan/rugi', [LaporanController::class, 'laba_rugi'])->name('lap.laba');
        Route::get('laporan/modal', [LaporanController::class, 'per_modal'])->name('lap.modal');
        Route::get('laporan/jurnal_umum', [LaporanController::class, 'jurnal_umum'])->name('lap.jurnal');
        Route::get('laporan/buku_besar', [LaporanController::class, 'buku_besar'])->name('lap.buku');

        //setting
        Route::get('setting', [SettingController::class, 'index'])->name('setting');
        Route::get('/setting/{id}/edit', [SettingController::class, 'edit'])->name('edit.setting');
        Route::put('/setting', [SettingController::class, 'store'])->name('update.setting');

        //Master Akun
        Route::get('/master_akun', [MasterController::class, 'index'])->name('master');
        Route::post('/master', [MasterController::class, 'store'])->name('add.master');
        Route::get('/master/{id}/edit', [MasterController::class, 'edit'])->name('edit.master');
        Route::put('/master', [MasterController::class, 'update'])->name('update.master');
        Route::delete('/master/delete/{id}', [MasterController::class, 'destroy'])->name('delete.master');

        //Neraca Awal
        Route::get('laporan/neraca_awal', [NeracaAwalController::class, 'index'])->name('neraca_awal');
        Route::post('/neraca_awal', [NeracaAwalController::class, 'store'])->name('add.neraca_awal');
        Route::get('/neraca_awal/{id}/edit', [NeracaAwalController::class, 'edit'])->name('edit.neraca_awal');
        Route::put('/neraca_awal', [NeracaAwalController::class, 'update'])->name('update.neraca_awal');
        Route::delete('/neraca_awal/delete/{id}', [NeracaAwalController::class, 'destroy'])->name('delete.neraca_awal');

        //Detail
        Route::get('laporan/detail_saldo', [DetailController::class, 'index'])->name('detail_saldo');
        Route::post('/detail_saldo', [DetailController::class, 'store'])->name('add.detail_saldo');
        Route::get('/detail_saldo/{id}/edit', [DetailController::class, 'edit'])->name('edit.detail_saldo');
        Route::put('/detail_saldo', [DetailController::class, 'update'])->name('update.detail_saldo');
        Route::delete('/detail_saldo/delete/{id}', [DetailController::class, 'destroy'])->name('delete.detail_saldo');

        //Aset
        Route::get('laporan/aset', [AsetController::class, 'index'])->name('aset');
        Route::post('/aset', [AsetController::class, 'store'])->name('add.aset');
        Route::get('/aset/{id}/edit', [AsetController::class, 'edit'])->name('edit.aset');
        Route::put('/aset', [AsetController::class, 'update'])->name('update.aset');
        Route::delete('/aset/delete/{id}', [AsetController::class, 'destroy'])->name('delete.aset');
    });

    Route::group(['middleware' => ['role:administrator|gudang']], function () {

        //Stok Produk
        Route::get('produks', [ProductController::class, 'index'])->name('product');
        Route::get('/produks/{id}/edit', [ProductController::class, 'edit'])->name('edit.product');
        Route::put('/produks', [ProductController::class, 'update'])->name('update.product');
        Route::delete('/produks/delete/{id}', [ProductController::class, 'destroy'])->name('delete.product');

        //Produk Masuk
        Route::get('masuk', [ProductController::class, 'masuk'])->name('product.masuk');
        Route::post('/masuk_add', [ProductController::class, 'masuk_store'])->name('add.masuk');
        Route::get('/masuk/{id}/edit', [ProductController::class, 'edit_masuk'])->name('edit.masuk');
        Route::put('/masuk/update', [ProductController::class, 'update_masuk'])->name('update.masuk');
        Route::delete('/masuk/delete/{id}', [ProductController::class, 'destroy_masuk'])->name('delete.masuk');

        //Produk Keluar
        Route::get('keluar', [ProductController::class, 'keluar'])->name('product.keluar');
        Route::post('/keluar_add', [ProductController::class, 'keluar_store'])->name('add.keluar');
        Route::get('/keluar/{id}/edit', [ProductController::class, 'edit_keluar'])->name('edit.keluar');
        Route::put('/keluar', [ProductController::class, 'update_keluar'])->name('update.keluar');
        Route::delete('/keluar/delete/{id}', [ProductController::class, 'destroy_keluar'])->name('delete.keluar');

        //Order Produk
        Route::get('order', [OrderController::class, 'index'])->name('product.order');
        Route::post('/order', [OrderController::class, 'store'])->name('order.store');
        Route::get('/order/details/{no}', [OrderController::class, 'show'])->name('order.details');
        Route::delete('/order/delete/{id}', [OrderController::class, 'destroy'])->name('order.delete');

        //Bahan Baku
        Route::get('baku', [ProductController::class, 'bahan_baku'])->name('product.baku');
        Route::post('baku', [ProductController::class, 'baku_store'])->name('add.baku');
        Route::get('/baku/{id}/edit', [ProductController::class, 'edit_baku'])->name('edit.baku');
        Route::put('/baku', [ProductController::class, 'update_baku'])->name('update.baku');
        Route::delete('/baku/delete/{id}', [ProductController::class, 'destroy_baku'])->name('delete.baku');
    });

    Route::group(['middleware' => ['role:administrator|produksi']], function () {
        //Resep
        Route::get('resep', [ProduksiController::class, 'index'])->name('resep');
        Route::post('/resep/add', [ProduksiController::class, 'store'])->name('add.resep');
        Route::get('/resep/bahan', [ProduksiController::class, 'resep_bahan'])->name('resep.bahan');
        Route::get('/resep/details/{no}', [ProduksiController::class, 'show'])->name('resep.details');
        Route::delete('/resep/delete/{id}', [ProduksiController::class, 'destroy'])->name('resep.delete');

        //Persediaan
        Route::post('/produksi/{no}', [ProduksiController::class, 'produksi_store'])->name('produksi');
        Route::get('persediaan', [ProduksiController::class, 'persediaan'])->name('persediaan');
        Route::get('/produksi/{id}/edit', [ProduksiController::class, 'edit'])->name('edit.stok');
        Route::put('/produksi', [ProduksiController::class, 'update'])->name('update.stok');
    });
});
