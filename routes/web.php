<?php

Route::get('/tes', function() {

});

Route::post('/captcha', function() {
    $captcha = Captcha::chars('0123456789')->length(4)->size(130, 50)->generate();
    return response()->json([
        'success'   => true,
        'id'        => $captcha->id(),
        'image'     => $captcha->image()
        ]);
});


Route::get('/', 'HomeController@index');
Route::group(['prefix' => 'process'], function() {
    Route::get('/findproduct', 'HomeController@findproduct');
    Route::get('/findproduct/pembayaran', 'HomeController@findproductPembayaran');
    Route::get('/prefixproduct', 'HomeController@prefixproduct');
    Route::get('/getoperator', 'HomeController@getoperator');
});

Route::group(['prefix' => 'payments'], function() {
    Route::group(['prefix' => 'paypal'], function() {
       Route::get('/callback', 'Member\PayPalController@callback')->name('payments.paypal.callback');
       Route::get('/view/{id}', 'Member\PayPalController@view')->name('payments.paypal.view');
       Route::post('/confirm/{id}', 'Member\PayPalController@confirm')->name('payments.paypal.confirm');
    });
});

// FOR CoinPayments IPN
Route::post('/payments/coinpayments/deposit/ipn', 'Member\DepositController@coinpaymentsIPN');
Route::get('tiketing', 'CronjobTiketingController@tiketing');
//For PaymentTripay callback
Route::post('callback', 'Member\PaymentTripayController@callbackPaymentTripay');

Route::get('/cara-transaksi', 'HomeController@caraTransaksi');
Route::get('/price/pembelian/{slug}', 'HomeController@pricePembelian');
Route::get('/price/pembayaran/{slug}', 'HomeController@pricePembayaran');
Route::get('/deposit', 'HomeController@deposit');
Route::get('/testimonial', 'HomeController@testimonial');
Route::get('/faq', 'HomeController@faq');
Route::post('/messages', 'HomeController@sendMessage');

Route::post('voucher/generate-code', 'Admin\VoucherController@generateCode')->name('voucher.generateCode');
Route::get('/transaksi-pembayaran/process', 'Member\PembayaranController@transaksiProcess');
Route::get('/transaksi/process', 'Member\PembelianController@transaksiProcess');

Route::group(['prefix'=>'admin', 'middleware'=>['auth', 'role:admin']], function() {
    
    Route::get('/ovo-transfer', 'Admin\SettingOvoTransferController@index');
    Route::post('/ovo-transfer', 'Admin\SettingOvoTransferController@store');

    Route::get('/block-phone', 'Admin\BlockPhoneController@index')->name('admin.blokir.telephone.index');
    Route::post('/block-phone/store', 'Admin\BlockPhoneController@store')->name('admin.blokir.telephone.store');
    Route::post('/block-phone/update', 'Admin\BlockPhoneController@update')->name('admin.blokir.telephone.update');
    Route::delete('/block-phone/destroy/{id}', 'Admin\BlockPhoneController@destroy')->name('admin.blokir.telephone.destroy');
    
    Route::get('/log-viewer-laravel', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
    Route::get('/pin', 'Admin\IndexController@getPin');

    Route::get('/', 'Admin\IndexController@indexNew');
    Route::get('/GetDataByRage', 'Admin\IndexController@getByDate');
    Route::get('/GetDataByMonth', 'Admin\IndexController@getByMonth');

    Route::group(['prefix' => 'validasi-users'], function() {
        Route::get('/', 'Admin\ValidasiUserController@index')->name('data.validasi-users.index');
        Route::get('/get-data', 'Admin\ValidasiUserController@getDatatable')->name('data.validasi-users.datatables');
        Route::get('/{id}', 'Admin\ValidasiUserController@showDetail')->name('data.validasi-users.show-detail');
        Route::get('/approve/{id}', 'Admin\ValidasiUserController@approveValidasi');
        Route::get('/nonapprove/{id}', 'Admin\ValidasiUserController@nonapproveValidasi');
    });
    
    Route::post('/users/lock', 'Admin\UserController@lockUsers')->name('lock.admin.users');
    Route::post('/users/unlock', 'Admin\UserController@unlockUsers')->name('unlock.admin.users');
    Route::get('/users/block-saldo/{id}','Admin\UserController@lockSaldo');
    Route::get('/users/unblock-saldo/{id}','Admin\UserController@unlockSaldo');
    
    Route::group(['prefix' => 'membership'], function() {
        Route::get('/', 'Admin\MembershipController@index')->name('data.validasi-upgrade.index');
        Route::get('/show/{id}','Admin\MembershipController@show');
        Route::post('/get-data', 'Admin\MembershipController@getDatatable')->name('data.validasi-membership.datatables');
        Route::get('/approve/{id}', 'Admin\MembershipController@approveValidasi');
        Route::get('/nonapprove/{id}', 'Admin\MembershipController@nonapproveValidasi');
    });

    Route::post('/mode', 'Admin\IndexController@mode');
    Route::get('/get-member', 'Admin\IndexController@getMember');
    Route::get('/ceksaldo', 'Admin\IndexController@ceksaldo');
    
    Route::group(['prefix' => 'transaksi'], function() {
        Route::get('/antrian', 'Admin\TransaksiController@transaksiAntrian');
        Route::post('/antrian/datatables', 'Admin\TransaksiController@transaksiAntrianProdukDatatables');
        Route::get('/antrian/{id}', 'Admin\TransaksiController@showTransaksiAntrian');
        Route::delete('/antrian/hapus/{id}', 'Admin\TransaksiController@transaksiAntrianHapus');
        Route::get('/produk', 'Admin\TransaksiController@transaksiProduk');
        Route::post('/produk/datatables', 'Admin\TransaksiController@transaksiProdukDatatables');
        Route::get('/produk/{id}', 'Admin\TransaksiController@showTransaksiProduk');
        Route::delete('/produk/hapus/{id}', 'Admin\TransaksiController@transaksiHapus');
        Route::post('/produk/refund/{id}', 'Admin\TransaksiController@refundTransaksiProduk');
        Route::post('/produk/ubahStatus/{id}', 'Admin\TransaksiController@ubahStatusTransaksiProduk');
        Route::get('/deposit', 'Admin\TransaksiController@transaksiSaldo');
        Route::post('/deposit/datatables', 'Admin\TransaksiController@transaksiSaldoDatatables');
        Route::get('/deposit/show/{id}', 'Admin\TransaksiController@depositShow');
        Route::get('/deposit/menunggu/{id}', 'Admin\TransaksiController@depositMenunggu');
        Route::get('/deposit/validasi/{id}', 'Admin\TransaksiController@depositValidasi');
        Route::get('/deposit/success/{id}', 'Admin\TransaksiController@depositSuccess');
        Route::get('/deposit/gagal/{id}', 'Admin\TransaksiController@depositGagal');
        Route::delete('/deposit/hapus/{id}', 'Admin\TransaksiController@depositHapus');
        Route::get('/tagihan', 'Admin\TransaksiController@transaksiTagihan');
        Route::post('/tagihan/datatables', 'Admin\TransaksiController@transaksiTagihanDatatables');
        Route::get('/tagihan/{id}', 'Admin\TransaksiController@showTransaksiTagihan');
        Route::delete('/tagihan/hapus/{id}', 'Admin\TransaksiController@hapusTransaksiTagihan');
        Route::get('/tagihan/menunggu/{id}', 'Admin\TransaksiController@tagihanMenunggu');
        Route::get('/tagihan/refund/{id}', 'Admin\TransaksiController@tagihanRefund');
        Route::get('/tagihan/success/{id}', 'Admin\TransaksiController@tagihanSuccess');
        Route::get('/tagihan/gagal/{id}', 'Admin\TransaksiController@tagihanGagal');
        Route::get('/redeem', 'Admin\TransaksiController@redeem');
        Route::get('/redeem/detail/{id}', 'Admin\TransaksiController@redeemDetail');
        Route::delete('/redeem/hapus/{id}', 'Admin\TransaksiController@redeemHapus');
        
        Route::get('/transfer-bank/datatables', 'Admin\TransferBankController@datatables');
        Route::group(['prefix' => 'transfer-bank'], function() {
            Route::get('/', 'Admin\TransferBankController@index');
            Route::get('/{id}', 'Admin\TransferBankController@show');
            Route::get('/pending/{id}', 'Admin\TransferBankController@statusPending');
            Route::get('/refund/{id}', 'Admin\TransferBankController@statusRefund');
            Route::get('/success/{id}', 'Admin\TransferBankController@statusSuccess');
            Route::post('/failed/{id}', 'Admin\TransferBankController@statusFailed');
        });
        
        Route::group(['prefix' => 'paypal'], function() {
            Route::get('/', 'Admin\TransaksiPaypalController@index');
            Route::get('/get-data', 'Admin\TransaksiPaypalController@getDatatable');
            Route::get('/{id}', 'Admin\TransaksiPaypalController@showTransaksi');
            Route::post('/menunggu', 'Admin\TransaksiPaypalController@trxMenunggu');
            Route::post('/refund', 'Admin\TransaksiPaypalController@trxRefund');
            Route::post('/success', 'Admin\TransaksiPaypalController@trxSuccess');
            Route::post('/gagal', 'Admin\TransaksiPaypalController@trxGagal');
        });
        
    });
    
    
        
    Route::get('/static-page/{slug}', 'Admin\StaticPageController@edit');
    Route::post('/static-page/{slug}', 'Admin\StaticPageController@store');
    
    Route::get('/setting/security', 'Admin\SettingSecurityController@index');
    Route::post('/setting/security', 'Admin\SettingSecurityController@store');
    
    Route::get('/setting', 'Admin\SettingController@indexSetting');
    Route::post('/setting/{id}', 'Admin\SettingController@storeSetting');

    Route::post('/send-informasi', 'Admin\IndexController@sendInformasi');
    Route::delete('/delete-informasi/{id}', 'Admin\IndexController@deleteInformasi');

    Route::post('/users/deposit-manual', 'Admin\UserController@depositManual');
    Route::post('/users/ubah-saldo-manual', 'Admin\UserController@ubahSaldoManual');

    Route::get('/broadcast-sms', 'Admin\BroadcastController@indexSMS');
    Route::post('/broadcast-sms/check', 'Admin\BroadcastController@checkSMS');
    Route::post('/broadcast-sms/send', 'Admin\BroadcastController@sendBroadcastSMS');
    
    Route::get('/broadcast-email', 'Admin\BroadcastController@indexEmail');
    Route::post('/broadcast-email/test', 'Admin\BroadcastController@testEmail');
    Route::post('/broadcast-email/send', 'Admin\BroadcastController@sendBroadcastEmail');

    Route::get('/pembayaran-produk/update-harga-semua', 'Admin\PembayaranprodukController@updateHargaSemua')->name('update.pembayaran.harga.semua');
    Route::get('/pembayaran-produk/update-harga-peroperator', 'Admin\PembayaranprodukController@updateHargaPerOperator')->name('update.pembayaran.harga.peroperator');
    Route::get('/pembayaran-produk/update-harga-perkategori', 'Admin\PembayaranprodukController@updateHargaPerKategori')->name('update.pembayaran.harga.perkategori');
    
    Route::get('/pembayaran-produk/update-harga-sum-markup-bykategori', 'Admin\PembayaranprodukController@updateHaragSumMakupPerKategori')->name('update.pembayaran.harga.sum.markup.perkategori');
    Route::get('/pembayaran-produk/update-harga-sum-markup-byoperator', 'Admin\PembayaranprodukController@updateHaragSumMakupPerOperator')->name('update.pembayaran.harga.sum.markup.peroperator');
    Route::delete('/pembayaran-produk/delete/{id}', 'Admin\PembayaranprodukController@destroy')->name('admin.pembayaranProduk.delete');

    Route::get('/process-cari-pembayaran/findproduct', 'Admin\PembayaranprodukController@findproduct');

    Route::post('/pembayaran-produk/import', 'Admin\PembayaranprodukController@import');
    Route::post('/pembayaran-produk/importAllData', 'Admin\PembayaranprodukController@importAllData');
    Route::get('/pembayaran-produk', 'Admin\PembayaranprodukController@index')->name('admin.pembayaranProduk.index');
    Route::get('/pembayaran-produk/create/{slug}', 'Admin\PembayaranprodukController@create');
    Route::post('/pembayaran-produk/store', 'Admin\PembayaranprodukController@store');
    Route::get('/pembayaran-produk/{slug}/edit/{id}', 'Admin\PembayaranprodukController@edit');
    Route::patch('/pembayaran-produk/update/{id}', 'Admin\PembayaranprodukController@update');
    Route::get('/pembayaran-produk/{slug}', 'Admin\PembayaranprodukController@showbyKategori');

    Route::group(['prefix' => 'pembelian-produk'], function() {
        Route::get('/', 'Admin\PembelianprodukController@index');
        Route::get('/cek-harga', 'Admin\PembelianprodukController@cekHarga')->name('cek.harga.pembelian.produk');
        Route::get('/update-harga-otomatis', 'Admin\PembelianprodukController@updateHargaOtomatis')->name('update.pembelian.harga.otomatis');
        Route::get('/update-harga-semua', 'Admin\PembelianprodukController@updateHargaSemua')->name('update.pembelian.harga.semua');
        Route::get('/update-harga-peroperator', 'Admin\PembelianprodukController@updateHargaPerOperator')->name('update.pembelian.harga.peroperator');
        Route::get('/update-harga-perkategori', 'Admin\PembelianprodukController@updateHargaPerKategori')->name('update.pembelian.harga.perkategori');
        Route::get('/update-harga-sum-markup-bykategori', 'Admin\PembelianprodukController@updateHaragSumMakupPerKategori')->name('update.pembelian.harga.sum.markup.perkategori');
        Route::get('/update-harga-sum-markup-byoperator', 'Admin\PembelianprodukController@updateHaragSumMakupPerOperator')->name('update.pembelian.harga.sum.markup.peroperator');
        Route::post('/import', 'Admin\PembelianprodukController@import');
        Route::post('/importAllData', 'Admin\PembelianprodukController@importAllData');
        Route::post('/delete', 'Admin\PembelianprodukController@deleteAllProduk');
        Route::get('/{slug}/edit/{id}', 'Admin\PembelianprodukController@edit');
        Route::patch('/update/{id}', 'Admin\PembelianprodukController@update');
        Route::get('/{slug}', 'Admin\PembelianprodukController@showbyKategori');

        Route::group(['prefix' => '/markup'], function() {
            Route::group(['prefix' => '/role-personal'], function() {
                Route::get('/', 'Admin\Markup\PembelianprodukPersonalController@index')->name('admin.produkPersonal.index');
                Route::get('/cek-harga', 'Admin\Markup\PembelianprodukPersonalController@cekHarga');
                Route::get('/update-harga-semua', 'Admin\Markup\PembelianprodukPersonalController@updateHargaSemua');
                Route::get('/update-harga-peroperator', 'Admin\Markup\PembelianprodukPersonalController@updateHargaPerOperator');
                Route::get('/update-harga-perkategori', 'Admin\Markup\PembelianprodukPersonalController@updateHargaPerKategori');
                Route::post('/update-harga-sum-markup-bykategori', 'Admin\Markup\PembelianprodukPersonalController@updateHaragSumMakupPerKategori');
                Route::post('/update-harga-sum-markup-byoperator', 'Admin\Markup\PembelianprodukPersonalController@updateHaragSumMakupPerOperator');
                Route::delete('/produk/delete/{id}', 'Admin\Markup\PembelianprodukPersonalController@destroy')->name('admin.produkPersonal.delete');

                Route::get('/{slug}', 'Admin\Markup\PembelianprodukPersonalController@showbyKategori');
                Route::get('/{slug}/edit/{id}', 'Admin\Markup\PembelianprodukPersonalController@edit');
                Route::patch('/update/{id}', 'Admin\Markup\PembelianprodukPersonalController@update');
                Route::post('/delete', 'Admin\Markup\PembelianprodukPersonalController@deleteAllProduk');
                Route::get('/plusminusmarkup', 'Admin\Markup\PembelianprodukPersonalController@import');
                Route::post('/plusminusmarkupAllData', 'Admin\Markup\PembelianprodukPersonalController@plusminusmarkupAllData');

                Route::get('/process-cari/findproduct', 'Admin\Markup\PembelianprodukPersonalController@findproduct');
            });

            Route::group(['prefix' => '/role-agen'], function() {
                Route::get('/', 'Admin\Markup\PembelianprodukAgenController@index')->name('admin.produkAgen.index');
                Route::get('/cek-harga', 'Admin\Markup\PembelianprodukAgenController@cekHarga');
                Route::get('/update-harga-semua', 'Admin\Markup\PembelianprodukAgenController@updateHargaSemua');
                Route::get('/update-harga-peroperator', 'Admin\Markup\PembelianprodukAgenController@updateHargaPerOperator');
                Route::get('/update-harga-perkategori', 'Admin\Markup\PembelianprodukAgenController@updateHargaPerKategori');
                Route::post('/update-harga-sum-markup-bykategori', 'Admin\Markup\PembelianprodukAgenController@updateHaragSumMakupPerKategori');
                Route::post('/update-harga-sum-markup-byoperator', 'Admin\Markup\PembelianprodukAgenController@updateHaragSumMakupPerOperator');
                Route::delete('/produk/delete/{id}', 'Admin\Markup\PembelianprodukAgenController@destroy')->name('admin.produkAgen.delete');

                Route::get('/{slug}', 'Admin\Markup\PembelianprodukAgenController@showbyKategori');
                Route::get('/{slug}/edit/{id}', 'Admin\Markup\PembelianprodukAgenController@edit');
                Route::patch('/update/{id}', 'Admin\Markup\PembelianprodukAgenController@update');
                Route::post('/delete', 'Admin\Markup\PembelianprodukAgenController@deleteAllProduk');
                Route::get('/plusminusmarkup', 'Admin\Markup\PembelianprodukAgenController@import');
                Route::post('/plusminusmarkupAllData', 'Admin\Markup\PembelianprodukAgenController@plusminusmarkupAllData');

                Route::get('/process-cari/findproduct', 'Admin\Markup\PembelianprodukAgenController@findproduct');
            });

            Route::group(['prefix' => '/role-enterprise'], function() {
                Route::get('/', 'Admin\Markup\PembelianprodukEnterpriseController@index')->name('admin.produkEnterprise.index');
                Route::get('/cek-harga', 'Admin\Markup\PembelianprodukEnterpriseController@cekHarga');
                Route::get('/update-harga-semua', 'Admin\Markup\PembelianprodukEnterpriseController@updateHargaSemua');
                Route::get('/update-harga-peroperator', 'Admin\Markup\PembelianprodukEnterpriseController@updateHargaPerOperator');
                Route::get('/update-harga-perkategori', 'Admin\Markup\PembelianprodukEnterpriseController@updateHargaPerKategori');
                Route::post('/update-harga-sum-markup-bykategori', 'Admin\Markup\PembelianprodukEnterpriseController@updateHaragSumMakupPerKategori');
                Route::post('/update-harga-sum-markup-byoperator', 'Admin\Markup\PembelianprodukEnterpriseController@updateHaragSumMakupPerOperator');
                Route::delete('/produk/delete/{id}', 'Admin\Markup\PembelianprodukEnterpriseController@destroy')->name('admin.produkEnterprise.delete');

                Route::get('/{slug}', 'Admin\Markup\PembelianprodukEnterpriseController@showbyKategori');
                Route::get('/{slug}/edit/{id}', 'Admin\Markup\PembelianprodukEnterpriseController@edit');
                Route::patch('/update/{id}', 'Admin\Markup\PembelianprodukEnterpriseController@update');
                Route::post('/delete', 'Admin\Markup\PembelianprodukEnterpriseController@deleteAllProduk');
                Route::get('/plusminusmarkup', 'Admin\Markup\PembelianprodukEnterpriseController@import');
                Route::post('/plusminusmarkupAllData', 'Admin\Markup\PembelianprodukEnterpriseController@plusminusmarkupAllData');

                Route::get('/process-cari/findproduct', 'Admin\Markup\PembelianprodukEnterpriseController@findproduct');
            });
        });
    });

    Route::get('/pembelian-produk/cek-harga', 'Admin\PembelianprodukController@cekHarga')->name('cek.harga.pembelian.produk');
    Route::get('/pembelian-produk/update-harga-otomatis', 'Admin\PembelianprodukController@updateHargaOtomatis')->name('update.pembelian.harga.otomatis');
    Route::get('/pembelian-produk/update-harga-semua', 'Admin\PembelianprodukController@updateHargaSemua')->name('update.pembelian.harga.semua');
    Route::get('/pembelian-produk/update-harga-peroperator', 'Admin\PembelianprodukController@updateHargaPerOperator')->name('update.pembelian.harga.peroperator');
    Route::get('/pembelian-produk/update-harga-perkategori', 'Admin\PembelianprodukController@updateHargaPerKategori')->name('update.pembelian.harga.perkategori');

    Route::get('/pembelian-produk/update-harga-sum-markup-bykategori', 'Admin\PembelianprodukController@updateHaragSumMakupPerKategori')->name('update.pembelian.harga.sum.markup.perkategori');
    Route::get('/pembelian-produk/update-harga-sum-markup-byoperator', 'Admin\PembelianprodukController@updateHaragSumMakupPerOperator')->name('update.pembelian.harga.sum.markup.peroperator');

    Route::get('/process-cari/findproduct', 'Admin\PembelianprodukController@findproduct');

    Route::post('/pembelian-produk/import', 'Admin\PembelianprodukController@import');
    Route::post('/pembelian-produk/importAllData', 'Admin\PembelianprodukController@importAllData');
    Route::post('/pembelian-produk/delete', 'Admin\PembelianprodukController@deleteAllProduk');
    Route::get('/pembelian-produk/{slug}/edit/{id}', 'Admin\PembelianprodukController@edit');
    Route::patch('/pembelian-produk/update/{id}', 'Admin\PembelianprodukController@update');
    Route::get('/pembelian-produk/{slug}', 'Admin\PembelianprodukController@showbyKategori');

    Route::post('/users/get-Users', 'Admin\UserController@datataBlesUsers')->name('get.admin.users.datatables');


    Route::post('usersedit/pin/generate', 'Admin\UserController@getPinGenerate')->name('get.usersedit.generate.pin');

    Route::resource('pembelian-kategori', 'Admin\PembeliankategoriController');
    Route::resource('pembelian-operator', 'Admin\PembelianoperatorController');
    Route::resource('pembayaran-kategori', 'Admin\PembayarankategoriController');
    Route::resource('pembayaran-operator', 'Admin\PembayaranoperatorController');
    Route::resource('pusat-informasi', 'Admin\InformasiController');
    Route::resource('voucher', 'Admin\VoucherController');
    Route::resource('users', 'Admin\UserController');
    Route::resource('bank', 'Admin\BankController');
    Route::resource('testimonial', 'Admin\TestimonialController');
    Route::resource('faqs', 'Admin\FaqController');
    Route::resource('messages', 'Admin\MessageController');
    Route::resource('tos', 'Admin\TosController');

    Route::get('/messages/show/{id}', 'Admin\MessageController@show')->name('admin.message.show');
    Route::delete('/messages/delete/{id}', 'Admin\MessageController@destroy')->name('admin.message.delete');
    Route::post('/messages/reply', 'Admin\MessageController@reply');
    Route::post('/messages/kirim', 'Admin\MessageController@store');

    Route::group(['prefix' => 'kontrol-menu'], function() {
        Route::get('/', 'Admin\KontrolMenuController@index')->name('kontrol.menu.index');
        Route::get('get-data-menu', 'Admin\KontrolMenuController@getDataMenu')->name('kontrol.menu.getdata.menu');
        Route::get('get-data-submenu', 'Admin\KontrolMenuController@getDataSubMenu')->name('kontrol.menu.getdata.submenu');

        //edit
        Route::get('edit-menu/{id}', 'Admin\KontrolMenuController@editMenu');
        Route::get('edit-submenu/{id}', 'Admin\KontrolMenuController@editSubmenu');
        Route::get('edit-submenu2/{id}', 'Admin\KontrolMenuController@editSubmenu2');
        Route::patch('updateSaveMenu/{id}', 'Admin\KontrolMenuController@updateSaveMenu');
        Route::patch('updateSaveSubmenu/{id}', 'Admin\KontrolMenuController@updateSaveSubmenu');
        Route::patch('updateSaveSubmenu2/{id}', 'Admin\KontrolMenuController@updateSaveSubmenu2');

        Route::post('nonaktifkan-menu', 'Admin\KontrolMenuController@nonaktifkanMenu')->name('menu.kontrol.nonaktifkan');
        Route::post('aktifkan-menu', 'Admin\KontrolMenuController@aktifkanMenu')->name('menu.kontrol.aktifkan');
        Route::post('nonaktifkan-sub-menu', 'Admin\KontrolMenuController@nonaktifkanSubMenu')->name('sub.menu.kontrol.nonaktifkan');
        Route::post('aktifkan-sub-menu', 'Admin\KontrolMenuController@aktifkanSubMenu')->name('sub.menu.kontrol.aktifkan');
        Route::post('nonaktifkan-sub2-menu', 'Admin\KontrolMenuController@nonaktifkanSubMenu2')->name('sub2.menu.kontrol.nonaktifkan');
        Route::post('aktifkan-sub2-menu', 'Admin\KontrolMenuController@aktifkanSubMenu2')->name('sub2.menu.kontrol.aktifkan');

        //aktif-nonaktif all menu

        Route::post('aktifkan-all-menu1', 'Admin\KontrolMenuController@aktifkanAllMenu1')->name('all.menu.aktifkan.menu1');
        Route::post('nonaktifkan-all-menu1', 'Admin\KontrolMenuController@nonaktifkanAllMenu1')->name('all.menu.nonaktifkan.menu1');
        Route::post('aktifkan-all-menu2', 'Admin\KontrolMenuController@aktifkanAllMenu2')->name('all.menu.aktifkan.menu2');
        Route::post('nonaktifkan-all-menu2', 'Admin\KontrolMenuController@nonaktifkanAllMenu2')->name('all.menu.nonaktifkan.menu2');
        Route::post('aktifkan-all-menu3', 'Admin\KontrolMenuController@aktifkanAllMenu3')->name('all.menu.aktifkan.menu3');
        Route::post('nonaktifkan-all-menu3', 'Admin\KontrolMenuController@nonaktifkanAllMenu3')->name('all.menu.nonaktifkan.menu3');
    });

    Route::group(['prefix' => 'banner'], function() {
        Route::get('/', 'Admin\BannerMenuController@index')->name('banner.menu.index');
        Route::get('/create', 'Admin\BannerMenuController@create')->name('banner.menu.create');
        Route::post('/store', 'Admin\BannerMenuController@store')->name('upload-gambar.store');
        Route::post('/update', 'Admin\BannerMenuController@update')->name('upload-gambar.update');
        Route::delete('/delete/{id}', 'Admin\BannerMenuController@delete')->name('delete.banner');
        Route::get('/edit-banner/{id}', 'Admin\BannerMenuController@edit')->name('edit.banner');
    });

    Route::group(['prefix' => 'logo'], function() {
        Route::get('/', 'Admin\LogoController@index');
        Route::post('/store', 'Admin\LogoController@store');
    });


    Route::group(['prefix' => 'setting-layanan-bantuan'], function() {
        Route::get('/', 'Admin\SettingLayananBantuanController@index');
        Route::post('/store', 'Admin\SettingLayananBantuanController@store');
    });

    Route::group(['prefix' => 'setting-deposit'], function() {
        Route::get('/', 'Admin\SettingDepositController@index')->name('setting.deposit.index');
        Route::patch('/update', 'Admin\SettingDepositController@update')->name('setting.deposit.update');
    });

    Route::group(['prefix' => 'setting-bonus'], function() {
        Route::get('/', 'Admin\SettingBonusController@index')->name('setting.bonus.index');
        Route::patch('/update', 'Admin\SettingBonusController@update')->name('setting.bonus.update');
    });

    Route::group(['prefix' => 'setting-kurs'], function() {
        Route::get('/', 'Admin\SettingKursController@index')->name('setting.kurs.index');
        Route::patch('/update', 'Admin\SettingKursController@update')->name('setting.kurs.update');
    });

    Route::group(['prefix' => 'sms-gateway'], function(){
        Route::get('/', 'Admin\SMSController@index');
        Route::get('/outbox', 'Admin\SMSController@outbox');
        Route::delete('/outbox/hapus/{id}', 'Admin\SMSController@outboxDelete');
        Route::post('/outbox/datatables', 'Admin\SMSController@outboxDatatables');
        Route::post('/send', 'Admin\SMSController@send');
        Route::get('/setting', 'Admin\SMSController@setting');
        Route::post('/setting', 'Admin\SMSController@updateSetting');
    });

    Route::get('/pengumuman', 'Admin\PengumumanController@index');
    Route::post('/pengumuman', 'Admin\PengumumanController@store');
    
    Route::get('/setting-trx-paypal', 'Admin\SettingPayPalController@index');
    Route::post('/setting-trx-paypal', 'Admin\SettingPayPalController@save');

        
    Route::post('bank/edit_data_provider','Admin\BankController@edit_data_provider');
    Route::put('bank/status/{id}','Admin\BankController@status');
    Route::post('bank/edit_data_bank','Admin\BankController@edit_data_bank');
    Route::post('bank/edit_data','Admin\BankController@edit_data');
    Route::post('bank/akunPaypal','Admin\BankController@akunpaypal');
    Route::post('bank/editakunPaypal','Admin\BankController@edit_akun_paypal');

});


Route::group(['prefix'=>'member', 'middleware'=>'auth'], function(){

    Route::get('/me', function(){
        $user_id = Auth::user()->id;
        return Response::json($user_id);
    });
    Route::get('/trx-print/{id}', 'Member\RiwayatController@printEdit');
    Route::post('/trx-print/{id}', 'Member\RiwayatController@printShow');
    Route::post('/trigger-online', 'Member\IndexController@triggerOnline');

    Route::get('/', 'Member\IndexController@index');
    Route::get('/harga-produk/pembelian/{slug}', 'Member\IndexController@pricePembelian');
    Route::get('/harga-produk/pembayaran/{slug}', 'Member\IndexController@pricePembayaran');
    Route::get('/beli/{slug}', 'Member\PembelianController@formBeli');
    Route::post('/beli/riwayat-transaksi-datatables', 'Member\PembelianController@riwayatTransaksiDatatables')->name('beli.get.riwayat.datatables');
    Route::get('/bayar/{slug}', 'Member\PembayaranController@formBayar');
    Route::get('/deposit', 'Member\DepositController@formDeposit');
    Route::get('/deposit/{id}', 'Member\DepositController@showDeposit');
    Route::post('/deposit/konfirmasi', 'Member\DepositController@konfirmasiPembayaran');
    Route::get('/deposit/coinpayments/{id}', 'Member\DepositController@coinpayments');

    Route::get('/markup-downline','Member\MarkupDownlineController@index');
    Route::post('/markup-downline/update','Member\MarkupDownlineController@update');

    Route::get('/layanan-bantuan', 'Member\LayananBantuan@index');

    Route::get('/messages', 'Member\MessageController@index');
    Route::get('/messages-show/{id}', 'Member\MessageController@show')->name('member.message.show');
    Route::delete('/messages/delete/{id}', 'Member\MessageController@destroy')->name('member.message.delete');
    Route::post('/messages/kirim', 'Member\MessageController@store');
    Route::post('/messages/reply', 'Member\MessageController@reply');

    // Routes Fitur Kirim Saldo
    Route::get('/transfer-saldo', 'Member\DepositController@transferSaldo');
    Route::post('/transfer-saldo/cek-nomor', 'Member\DepositController@cekNomor');
    Route::post('/transfer-saldo/kirim', 'Member\DepositController@kirimSaldo');
    
    Route::get('/transfer-bank', 'Member\TransferBankController@index');
    Route::post('/transfer-bank', 'Member\TransferBankController@process');
    Route::post('/transfer-bank/inquiry', 'Member\TransferBankController@inquiry');
    Route::post('/transfer-bank/send/{uuid}', 'Member\TransferBankController@send');
    Route::get('/transfer-bank/history', 'Member\TransferBankController@history');
    Route::get('/transfer-bank/history/datatables', 'Member\TransferBankController@historyDatatables');
    Route::get('/transfer-bank/history/show/{id}', 'Member\TransferBankController@show');
    Route::get('/transfer-bank/history/print/{id}', 'Member\TransferBankController@printStruk');
    Route::get('/transfer-bank/get-bank', 'Member\TransferBankController@getBankCode')->name('get.bank.code');

    Route::get('/mutasi-saldo', 'Member\DepositController@mutasiSaldo');
    Route::post('/mutasi-saldo-datatables', 'Member\DepositController@mutasiSaldoDatatables')->name('get.mutasiSaldo.datatables');
    Route::get('/redeem-voucher', 'Member\DepositController@redeemVoucher');
    Route::post('/redeem-voucher', 'Member\RedeemController@redeemVoucher');

    Route::get('/buy-paypal', 'Member\BuyPaypalController@index');
    Route::post('/buy-paypal', 'Member\BuyPaypalController@processSaveTrx');

    Route::get('/riwayat-transaksi', 'Member\RiwayatController@riwayatTransaksi');
    Route::post('/riwayat-transaksi-datatables', 'Member\RiwayatController@riwayatTransaksiDatatables')->name('get.riwayat.datatables');
    Route::get('/riwayat-transaksi/{id}', 'Member\RiwayatController@showTransaksi');
    Route::get('/trx-print/{id}', 'Member\RiwayatController@printShow');
    Route::get('/tagihan-pembayaran', 'Member\TagihanController@tagihanPembayaran');
    Route::post('/tagihan-pembayaran-datatables', 'Member\TagihanController@tagihanPembayaranDatatables')->name('get.tagihan-pembayaran.datatables');
    Route::get('/tagihan-pembayaran/{id}', 'Member\TagihanController@showTagihan');

    Route::get('/process/getoperator', 'Member\PembelianController@getOperator');
    Route::get('/process/findproduct', 'Member\PembelianController@findproduct');
    Route::get('/process/prefixproduct', 'Member\PembelianController@prefixproduct');
    Route::post('/process/orderproduct', 'Member\PembelianController@orderproduct');
    
    Route::post('/process/orderproduct/home', 'Member\PembelianController@orderproducthome');
    Route::post('/process/depositsaldo', 'Member\DepositController@depositsaldo')->name('process.bank.deposit');
    Route::post('/process/depositsaldo/get-data-bank', 'Member\DepositController@getBankDeposit')->name('get.bank.deposit');

    Route::post('/process/findproductpembayaran', 'Member\PembayaranController@findproductpembayaran');
    Route::post('/process/cektagihan', 'Member\PembayaranController@cektagihan');
    Route::post('/process/cektagihan/home', 'Member\PembayaranController@cektagihanhome');
    Route::post('/process/bayartagihan', 'Member\PembayaranController@bayartagihan')->name('bayartagihan');

    Route::get('/profile', 'Member\ProfilController@index');
    Route::get('/biodata', 'Member\ProfilController@biodata');
    Route::post('/biodata', 'Member\ProfilController@storeBiodata');
    Route::get('/pusat-informasi', 'Member\ProfilController@pusatInformasi');
    Route::get('/ubah-password', 'Member\ProfilController@password');
    Route::post('/ubah-password', 'Member\ProfilController@updatePassword');
    Route::get('/picture', 'Member\ProfilController@picture');
    Route::post('/picture', 'Member\ProfilController@updatePicture');
    Route::get('/testimonial', 'Member\ProfilController@testimonial');
    Route::post('/testimonial', 'Member\ProfilController@sendTestimonial');
    Route::get('/rekening-bank', 'Member\ProfilController@rekening')->name('index.rekening-bank');
    Route::post('/tambah-rekening-bank', 'Member\ProfilController@insertRekening');
    Route::get('/pin', 'Member\ProfilController@pin')->name('get.profile.pin');
    Route::get('/pin/request', 'Member\ProfilController@getPinSend')->name('get.profile.request.pin');
    Route::get('/pin/generate', 'Member\ProfilController@getPinGenerate')->name('get.profile.generate.pin');
    Route::post('/pin/ubah', 'Member\ProfilController@ubahPin')->name('get.profile.ubah.pin');
    Route::get('/rekening-paypal', 'Member\ProfilController@rekeningPayPal')->name('index.rekening-paypal');
    Route::post('/rekening-paypal', 'Member\ProfilController@insertRekeningPayPal');
    Route::post('/rekening-paypal/send-code', 'Member\ProfilController@sendPayPalEmailVerificationCode')->name('index.rekening-paypal.send-code');

    Route::group(['prefix' => 'membership'], function() {
        Route::get('/', 'Member\MembershipController@index');
        Route::post('/upgrade-level', 'Member\MembershipController@upgradelevel')->name('membership.upgrade.level');
        Route::post('/pay-upgrade-level', 'Member\MembershipController@payUpgradelevel')->name('pay.membership.upgrade.level');
        Route::post('/extend-level', 'Member\MembershipController@extendLevel')->name('pay.membership.extend.level');
        Route::post('/buy-periode', 'Member\MembershipController@buyperiodemembership');
    });

    Route::get('/pin/request/success', function(){
        return redirect()->route('get.profile.pin')->with('alert-success', 'Behasil Mengirim Pin ke no anda!');
    })->name('get.profile.request.pin.success');

    Route::get('/pin/generate/success', function(){
        return redirect()->route('get.profile.pin')->with('alert-success', 'Behasil Regenerate Pin dan dikirm ke no anda!');
    })->name('get.profile.generate.pin.success');

    Route::get('/pin/ubah/success', function(){
        return redirect()->route('get.profile.pin')->with('alert-success', 'Behasil Merubah Pin anda!');
    })->name('get.profile.ubah.pin.success');

    Route::get('/pin/ubah/error', function(){
        return redirect()->route('get.profile.pin')->with('alert-error', 'Gagal Merubah Pin, Password anda salah!');
    })->name('get.profile.ubah.pin.error');

    Route::get('/pin/ubah/invalid', function(){
        return redirect()->route('get.profile.pin')->with('alert-error', 'Gagal Merubah Pin, PIN harus dalam format angka 4 digit!');
    })->name('get.profile.ubah.pin.invalid');

    Route::get('/referral', 'Member\ReferralController@referral');
    Route::post('/referral/kode_referral','Member\ReferralController@kode_referral');
    Route::get('/referral-datatables', 'Member\ReferralController@referralDatatables')->name('get.referral.datatables');
    Route::get('/bonus-transaksi', 'Member\ReferralController@bonusTransaksi');
    Route::get('/komisi-trx-ref', 'Member\ReferralController@bonusKomisi');
    Route::post('/komisi-trx-ref-datatablesOne', 'Member\ReferralController@bonusKomisiDatatablesOne')->name('get.komisi-trx-ref.datatablesOne');
    Route::post('/komisi-trx-ref-datatables', 'Member\ReferralController@bonusKomisiDatatables')->name('get.komisi-trx-ref.datatables');

    Route::get('/validasi-users', 'Member\ValidationUserController@index')->name('validation.user.index');
    Route::post('/validasi-users/store', 'Member\ValidationUserController@store')->name('validation.user.store');

    Route::post('/beli/getTypehead', 'Member\PembelianController@getTypehead')->name('beli.get.typehead');
    Route::post('/beli/getTypehead/pln', 'Member\PembelianController@getTypeheadPLN')->name('beli.get.typehead.pln');
    Route::post('/bayar/getTypehead/tagihan', 'Member\PembayaranController@getTypeheadTagihan')->name('beli.get.typehead.tagihan');
    
    Route::get('/top-users', 'Member\TopUserController@index')->name('top-users');
    
});

Route::group(['prefix' => 'menu-submenu'], function() {
    Route::get('menusubmenu/member', 'MenuSubmenu\MenuSubmenuController@menuSubmenuMember');
    Route::get('menusubmenu/admin', 'MenuSubmenu\MenuSubmenuController@menuSubmenuAdmin');
});

// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

// Password Reset Routes...
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');

// Registration Routes...
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

Route::get('/{slug}', 'HomeController@staticPage');
