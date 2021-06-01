<?php
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'monitoring-evaluasi','as' => 'monev.'], function(){
    Route::group(['prefix' => 'form','as' => 'form.'],function(){
        Route::get('/', 'FormController@index')->name('index');
        Route::get('/data', 'FormController@data')->name('data');
        Route::get('/create', 'FormController@create')->name('create');
        Route::post('/create', 'FormController@store')->name('store');
        Route::get('{form}/edit', 'FormController@edit')->name('edit');
        Route::get('{form}/publish', 'FormController@publish')->name('publish');
        Route::post('{form}/publish', 'FormController@publishing')->name('publishing');
        Route::put('{form}/update', 'FormController@update')->name('update');
        Route::delete('{form}/', 'FormController@destroy')->name('destroy');

        Route::group(['prefix' => '{form}/instruments','as' => 'instrument.'],function(){
            Route::get('/', 'InstrumentController@index')->name('index');
            Route::get('preview', 'InstrumentController@preview')->name('preview');
            Route::get('/data', 'InstrumentController@data')->name('data');
            Route::get('/create', 'InstrumentController@create')->name('create');
            Route::post('/create', 'InstrumentController@store')->name('store');
            Route::get('{instrument}/edit', 'InstrumentController@edit')->name('edit');
            Route::put('{instrument}/update', 'InstrumentController@update')->name('update');
            Route::delete('{instrument}', 'InstrumentController@destroy')->name('destroy');

            Route::group(['prefix' => '{instrument}/question','as' => 'question.'],function(){
                Route::get('/', 'QuestionController@index')->name('index');
                Route::get('/data', 'QuestionController@data')->name('data');
                Route::get('/create', 'QuestionController@create')->name('create');
                Route::post('/create', 'QuestionController@store')->name('store');
                Route::post('/changestatus', 'QuestionController@changestatus')->name('changestatus');
                Route::get('{question}/edit', 'QuestionController@edit')->name('edit');
                Route::put('{question}/update', 'QuestionController@update')->name('update');
                Route::delete('{question}', 'QuestionController@destroy')->name('destroy');
            });
        });
        Route::group(['prefix' => '{form}/indicators','as' => 'indicator.'],function(){
            // Route::get('/', 'Idicator@index')->name('index');
            Route::get('/data', 'IndicatorController@data')->name('data');
            Route::get('/create', 'IndicatorController@create')->name('create');
            Route::post('/create', 'IndicatorController@store')->name('store');
            Route::get('{indicator}/edit', 'IndicatorController@edit')->name('edit');
            Route::put('{indicator}/update', 'IndicatorController@update')->name('update');
            Route::delete('{indicator}', 'IndicatorController@destroy')->name('destroy');
        });

        Route::group(['prefix' => '{form}/sasaran-monitoring','as' => 'target.'],function(){
            Route::get('/', 'TargetController@index')->name('index');
            Route::get('/data', 'TargetController@data')->name('data');
            Route::get('/create', 'TargetController@create')->name('create');
            Route::get('/input/{target?}', 'TargetController@getInput')->name('input');
            Route::post('/create', 'TargetController@store')->name('store');
            Route::get('{target}/edit', 'TargetController@edit')->name('edit');
            Route::put('{target}/update', 'TargetController@update')->name('update');
            Route::get('summary', 'TargetController@summary')->name('summary');
            Route::delete('{target}', 'TargetController@destroy')->name('destroy');
        });
    });

    Route::group(['namespace' => 'Inspection'], function(){
        Route::group(['prefix' => 'pemeriksaan','as' => 'inspection.'], function(){
            Route::get('/', 'InspectionController@index')->name('index');
            Route::get('/data', 'InspectionController@data')->name('data');
            Route::get('{form}/detail', 'InspectionController@detail')->name('detail');
        });
    
        Route::group(['namespace' => 'History','prefix' => 'riwayat-pemeriksaan','as' => 'inspection-history.'], function(){
            Route::get('/', 'InspectionHistoryController@index')->name('index');
            Route::get('/data', 'InspectionHistoryController@data')->name('data');
            Route::group(['prefix' => '{form}', 'as' => 'target.'], function(){
                Route::get('/', 'TargetController@index')->name('index');
                Route::get('data', 'TargetController@data')->name('data');
                Route::get('/sasaran-monitoring/{target}', 'TargetController@detail')->name('detail');
                Route::group(['prefix' => '{target}', 'as' => 'instrument.'], function(){
                    Route::get('data', 'InstrumentController@data')->name('data');
                });
            });
           
        });
    });
    
    Route::group(['prefix' => 'laporan-indikator','as' => 'indicator-report.'], function(){
        Route::get('/', 'IndicatorReportController@index')->name('index');
        Route::get('/data', 'IndicatorReportController@data')->name('data');
        Route::get('{form}/detail', 'IndicatorReportController@detail')->name('detail');
    });
});

Route::group(['prefix' => 'management-lembaga','as' => 'institution.'], function(){
    Route::group(['prefix' => 'non-satuan-pendidikan','as' => 'non-satuan.'], function(){
        Route::get('/', 'InstitutionController@index')->name('index');
        Route::get('/data', 'InstitutionController@data')->name('data');
        Route::get('/create', 'InstitutionController@create')->name('create');
        Route::post('/create', 'InstitutionController@store')->name('store');
        Route::get('{institution}/edit', 'InstitutionController@edit')->name('edit');
        Route::put('{institution}/update', 'InstitutionController@update')->name('update');
        Route::delete('{institution}', 'InstitutionController@destroy')->name('destroy');
    });
});

Route::group(['prefix' => 'management-user','as' => 'management-user.'], function(){
    Route::get('/', 'UserController@index')->name('index');
    Route::get('/data', 'UserController@data')->name('data');
    Route::get('/create', 'UserController@create')->name('create');
    Route::post('/create', 'UserController@store')->name('store');
    Route::get('{user}/edit', 'UserController@edit')->name('edit');
    Route::put('{user}/update', 'UserController@update')->name('update');
    Route::delete('{user}', 'UserController@destroy')->name('destroy');
});