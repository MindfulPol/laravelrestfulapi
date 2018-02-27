<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Politician;
use App\Http\Middleware\VerifyAccessKey;

class PoliticianController extends Controller
{
    public function __construct()
    {
        $this->middleware(VerifyAccessKey::class);
    }
    // 3 casos segons els paràmetres de la url
    //  - Cap paràmetre: retorna TOTS els polítics de la BD
    //  - Sol el paràmetre 'name': retorna UN SOL polític
    //  - Combinació de paràmetres: retorna un/s polític segons coincidència amb els paràmetres
    public function show(Request $request)
    {
        if ($request->input() == null) :
            // Url sense especificar cap paràmetre per tant els retornem tots
            $politicians = Politician::All();
        elseif ($request->input('nom') !== null && count($request->input()) ==1) :
            // Si sol tenim el nom retornem UN polític
            $politicians = Politician::where($request->input())->first();
        else :
            // segons els parametres
            $politicians = Politician::where($request->input())->get();
        endif;
        if (is_null($politicians)) :
            return ['error' => 'Polític/s no trobat'];
        else :
            return $politicians;
        endif;
    }
}
