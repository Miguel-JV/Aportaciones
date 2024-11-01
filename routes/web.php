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

Route::get('/propuesta','PruebasController@propuesta')->name('propuesta.index');



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
    Route::get('/exportar/historico/tickets', 'TicketsController@export_historico')->name('tickets.historico');
    Route::get('/exportar/status/tickets', 'TicketsController@export_status')->name('tickets.status');
    Route::get('/exportar/consulta/tickets', 'TicketsController@export_dinamic_ticket')->name('tickets.consulta');

    Route::get('/exportar/cotizacion/{nombre}', 'TicketsController@exportCotizacion')->name('exportar.cotizacion');
    Route::get('/exportar/autorizacion/{nombre}', 'TicketsController@exportAutorizacion')->name('exportar.autorizacion');

    // Vistas
    Route::get('/tickets/creacion','TicketsController@crearTickets')->name('crear.tickets');
    Route::get('/tickets/consultar','TicketsController@consultarTickets')->name('consultar.ticket');
    Route::get('/tickets/reporte','TicketsController@generaReporteTickets')->name('reporte.ticket');


    Route::get('/tickets/{ticket}/actualizacion','TicketsController@actualizarTickets')->name('actualizar.ticket');
    Route::get('/tickets/{ticket}/historial','TicketsController@historialTickets')->name('historial.ticket');
    Route::get('/tickets/{ticket}/validacion','TicketsController@validarTickets')->name('validar.ticket');

    Route::get('/tickets/{ticket}/{encargado}/cotizacion','TicketsController@cotizarTickets')->name('cotizar.ticket');
    Route::get('/tickets/{ticket}/{encargado}/modificar/cotizacion','TicketsController@modificarCotizacion')->name('modificar.cotizacion.ticket');

    Route::get('/tickets/{ticket}/{encargado}/autorizar','TicketsController@autorizarTicket')->name('autorizar.ticket');


    Route::get('/tickets/pesonal/modificar','TicketsController@modificarPersonal')->name('modificar.personal');

    // FORMULARIOS TICKETS
    // CRUD Tickets
    Route::post('tickets/create','TicketsController@crear')->name('create.ticket');
    Route::post('tickets/consult','TicketsController@consultar')->name('consult.ticket');
    Route::patch('tickets/validate/{ticket}','TicketsController@validar')->name('validate.ticket');
    Route::post('tickets/cancel/{ticket}','TicketsController@cancelar')->name('cancel.ticket');
    Route::patch('tickets/quote/{ticket}/{usuario}','TicketsController@cotizar')->name('quote.ticket');
    Route::patch('tickets/authorize/{ticket}/{usuario}','TicketsController@autorizar')->name('authorize.ticket');
    Route::patch('tickets/update/{ticket}','TicketsController@actualizar')->name('update.ticket');

    // CRUD Personal Registrado
    Route::post('tickets/update/personal/delete/relations','TicketsController@eliminarRelacionPersonal')->name('eliminar.relacion.personal');
    Route::post('tickets/update/personal/delete/person','TicketsController@eliminarPersonal')->name('eliminar.personal');
    Route::post('tickets/update/personal/assign/person','TicketsController@asignarPersonal')->name('asignar.personal');
    Route::post('tickets/update/personal/create/person','TicketsController@crearPersonal')->name('crear.personal');

});
