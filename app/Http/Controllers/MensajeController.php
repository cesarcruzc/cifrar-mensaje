<?php

namespace App\Http\Controllers;

use App\Http\Repositories\MensajeRepository;
use App\Http\Requests\CreateMensajeRequest;
use App\Http\Requests\MensajeRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class MensajeController extends Controller
{

    /**
     * @var MensajeRepository
     */
    private $mensajeRepository;

    public function __construct(MensajeRepository $mensajeRepository)
    {
        $this->mensajeRepository = $mensajeRepository;
    }

    public function cifrar(CreateMensajeRequest $request)
    {
        DB::beginTransaction();

        try {

            $path               = 'public/';
            $nombreArchivo      = Carbon::now()->timestamp.".txt";
            $ruta               = $path.$nombreArchivo;
            $mensajeEncriptado  = Crypt::encryptString($request->get('mensaje'));

            Storage::disk('local')->put($ruta, $mensajeEncriptado);

            $data = [
                'nombre_archivo' => $nombreArchivo,
                'ruta'           => $ruta
            ];

            $this->mensajeRepository->store($data);

            $respuesta = ['respuesta' => true, 'razon' => 'Mensaje cifrado con éxito descargar archivo: ', 'ruta' => $ruta, 'archivo' => $nombreArchivo];

        } catch (\Exception $e) {
            DB::rollBack();
            $respuesta = ['respuesta' => false, 'razon' => "Ocurrio un error al al cifrar el archivo, por favor contacte al administrador del sistema en informele del siguiente error: Mensaje: {$e->getMessage()} Código: {$e->getCode()} Archivo: {$e->getFile()} Linea: {$e->getLine()}"];
        }

        DB::commit();

        return redirect()->back()->with($respuesta);
    }

    public function descargarArchivo($archivo)
    {

        try {
            $consulta = $this->mensajeRepository->getByNombreArchivo($archivo);
            return Storage::download($consulta->ruta);
        } catch (\Exception $e) {
            DB::rollBack();
            $respuesta = ['respuesta' => false, 'razon' => "Ocurrio un error al buscar el archivo, por favor contacte al administrador del sistema en informele del siguiente error: Mensaje: {$e->getMessage()} Código: {$e->getCode()} Archivo: {$e->getFile()} Linea: {$e->getLine()}"];
        }

        return redirect()->back()->with($respuesta);
    }

    public function descifrar(MensajeRequest $request)
    {
        $archivo = File::get($request->file('archivo'));
        $mensajeDescifrado = Crypt::decryptString($archivo);

        return redirect()->back()->with(['mensajeDescifrado' => $mensajeDescifrado]);
    }

}
