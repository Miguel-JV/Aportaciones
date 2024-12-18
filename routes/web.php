<?php

use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/storage-link', function () {
    Artisan::call('storage:link');
});

Route::get('/portal/aldea','LandingController@landingAldea')->name('landing.aldea');
Route::get('/portal/general','LandingController@landingGeneral')->name('landing.general');
Route::get('/portal/videos','LandingController@cardAldea')->name('landing.card');



// MIDLEWARE POR POSIBLES ATAQUES XSS
Route::group(['middleware'=>'XSS'], function() {
// PANEL CONTROL DE MENSAJERIA
    Route::get('/panel-control','WhatsappController@panelControl')->name('panel.whatsapp');
    Route::get('/panel-control/mensajes-whatsapp','WhatsappController@mensajeriaWhatsapp')->name('mensajeria.whatsapp');
    Route::get('/panel-control/mensajes-telegram','TelegramController@mensajeriaTelegram')->name('mensajeria.telegram');
    Route::get('/panel-control/mensajes-gmail','GmailController@base')->name('mensajeria.gmail');

// PROBAR NUEVOS COMPONENTES
    // Route::get('/pruebas','PruebasController@index')->name('pruebas');
    Route::get('/pruebas','PruebasController@reporte')->name('pruebas');

// TICKETS
    // Solicitud de colecciones
    Route::get('/tickets/creacion/{id}/Casas','TicketsController@obtenerCasas');
    Route::get('/tickets/creacion/{id}/Directores','TicketsController@obtenerDirectores');
    Route::get('/tickets/creacion/{id}/Drives','TicketsController@obtenerDrives');
    Route::get('/tickets/creacion/{id}/Afecciones','TicketsController@obtenerAfecciones');
    Route::get('/tickets/creacion/{id}/Areas','TicketsController@obtenerAreas');
    Route::get('/tickets/creacion/{id}/Encargados','TicketsController@obtenerEncargados');
    Route::get('/tickets/creacion/{id_casa}/{id_afeccion}/Supervisores','TicketsController@obtenerSupervisores');
    Route::get('/tickets/creacion/{id_casa}/{id_afeccion}/Subgerentes','TicketsController@obtenerSubgerentes');
    Route::get('/tickets/creacion/{id_casa}/{id_afeccion}/Gerentes','TicketsController@obtenerGerentes');

    Route::get('/tickets/creacion/{id_entornos}/{id_casa}/Sitios','TicketsController@obtenerSitios');
    Route::get('/tickets/creacion/{id}/Espacio','TicketsController@obtenerEspacio');
    Route::get('/tickets/creacion/{id}/Objetos','TicketsController@obtenerObjetos');
    Route::get('/tickets/creacion/{id}/Elementos','TicketsController@obtenerElementos');
    Route::get('/tickets/creacion/{id}/Prioridades','TicketsController@obtenerPrioridades');

    // Solicitud de Excel
    Route::get('/exportar/cotizacion/{nombre}', 'TicketsController@exportCotizacion')->name('exportar.cotizacion');
    Route::get('/exportar/autorizacion/{nombre}', 'TicketsController@exportAutorizacion')->name('exportar.autorizacion');
    Route::get('/exportar/evidenciaPago/{nombre}', 'TicketsController@exportEvidenciaPago')->name('exportar.evidencia.pago');

    // Vistas
    Route::middleware('auth')->group(function () {
        Route::get('/tickets/creacion','TicketsController@crearTickets')->name('crear.tickets');
        Route::get('/tickets/consultar','TicketsController@consultarTickets')->name('consultar.ticket');
        Route::get('/tickets/reporte','TicketsController@generaReporteTickets')->name('reporte.ticket');
        Route::get('/tickets/pesonal/modificar','TicketsController@modificarPersonal')->name('modificar.personal');
        Route::get('/tickets/consultar/pago','TicketsController@consultarTicketsPago')->name('consultar.ticket.pago');
        Route::get('/tickets/consultar/pasados','TicketsController@consultarTicketsPasados')->name('consultar.ticket.pasado');
    });





    Route::get('/tickets/{ticket}/actualizacion','TicketsController@actualizarTickets')->name('actualizar.ticket');
    Route::get('/tickets/{ticket}/historial','TicketsController@historialTickets')->name('historial.ticket');

    Route::get('/tickets/{ticket}/{encargado}/validacion','TicketsController@validarTickets')->name('validar.ticket');
    Route::get('/tickets/{ticket}/{encargado}/cotizacion','TicketsController@cotizarTickets')->name('cotizar.ticket');
    Route::get('/tickets/{ticket}/{encargado}/modificar/cotizacion','TicketsController@modificarCotizacion')->name('modificar.cotizacion.ticket');
    Route::get('/tickets/{ticket}/{encargado}/autorizar','TicketsController@autorizarTicket')->name('autorizar.ticket');


    Route::get('/tickets/{ticket}/{encrypted}/actualizacion/finalizado','TicketsController@actualizarTicketsFinalizados')->name('actualizar.ticket.finalizado');
    Route::get('/tickets/{ticket}/{encrypted}/cotización/pendientes','TicketsController@cotizarTicketsPendientes')->name('cotizar.ticket.pendiente');

    Route::get('/tickets/{ticket}/actualizacion/pasados','TicketsController@actualizarTicketsPasados')->name('actualizar.ticket.pasado');



    // FORMULARIOS TICKETS
    // CRUD Tickets
    Route::post('tickets/create','TicketsController@crear')->name('create.ticket');
    Route::post('tickets/consult','TicketsController@consultar')->name('consult.ticket');
    Route::post('tickets/consult/historic','TicketsController@consultarHistorico')->name('consult.historic.ticket');

    Route::patch('tickets/validate/{ticket}/{usuario}','TicketsController@validar')->name('validate.ticket');
    Route::post('tickets/cancel/{ticket}','TicketsController@cancelar')->name('cancel.ticket');
    Route::patch('tickets/quote/{ticket}/{usuario}','TicketsController@cotizar')->name('quote.ticket');

    Route::patch('tickets/authorize/{ticket}/{usuario}','TicketsController@autorizar')->name('authorize.ticket');
    Route::post('tickets/invalidate/{ticket}/{usuario}','TicketsController@anular')->name('invalidate.ticket');

    Route::patch('tickets/update/{ticket}','TicketsController@actualizar')->name('update.ticket');
    Route::patch('tickets/update/{ticket}/{usuario}/finalizado','TicketsController@actualizarFinalizado')->name('update.ticket.finalized');
    Route::patch('tickets/update/{ticket}/pasado','TicketsController@actualizarPasado')->name('update.ticket.past');

    // CRUD Personal Registrado
    Route::post('tickets/update/personal/delete/relations','TicketsController@eliminarRelacionPersonal')->name('eliminar.relacion.personal');
    Route::post('tickets/update/personal/delete/person','TicketsController@eliminarPersonal')->name('eliminar.personal');
    Route::post('tickets/update/personal/assign/person','TicketsController@asignarPersonal')->name('asignar.personal');
    Route::patch('tickets/update/personal/assign/mail','TicketsController@asignarCorreo')->name('asignar.correo.casa');
    Route::post('tickets/update/personal/create/person','TicketsController@crearPersonal')->name('crear.personal');

});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// LOGIN
Route::prefix('loginTickets')->group(function(){
    Route::get('/', 'Auth\LoginTicketsController@mostrarLogin')->name('login.tickets');
    Route::post('/', 'Auth\LoginTicketsController@login')->name('login.tickets.submit');
});

