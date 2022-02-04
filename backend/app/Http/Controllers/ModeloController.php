<?php

namespace App\Http\Controllers;

use App\Models\Modelo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ModeloController extends Controller
{
    public function __construct(Modelo $modelo){
        $this->modelo = $modelo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $modelos = array();
        
        if($request->has('atributos_marca')){
            $atributos_marca = $request->atributos_marca;
            $modelos = $this->modelo->with('marca:id,'.$atributos_marca);
        }else{
            $modelos = $this->modelo->with('marca');
        }

        if($request->has('atributos')){
            $atributos = $request->atributos;
            $modelos = $modelos->selectRaw($atributos)->get();
        }else{
            $modelos = $modelos->with('marca')->get();
        }
        //$this->modelo->with('marca')->get()
        return response()->json($modelos,200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // client precisa informar com "accept" => "application/json" para ter um retorno de erro em json

        $request->validate($this->modelo->rules());

        $imagem = $request->file('imagem');
        $imagem_urn = $imagem->store('imagem/modelos','public');
        
        $modelo = $this->modelo->create([
            'marca_id' => $request->marca_id,
            "nome" => $request->nome,
            "imagem" => $imagem_urn,
            'numero_portas' => $request->numero_portas,
            'lugares' => $request->lugares,
            'air_bag' => $request->air_bag,
            'abs' => $request->abs
        ]);
        return response()->json($modelo,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Modelo  $modelo
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $modelo = $this->modelo->with('marca')->find($id);
        if($modelo === null){
            return response()->json(["erro" => "Recurso inexistente"], 404);
        }
        return response()->json($modelo, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Modelo  $modelo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        // Adcionar no body da requisição _method = put ou _method = patch e enviar a requisição por POST para usar form-data
        $modelo = $this->modelo->find($id);
        
        if($modelo === null){
            return response()->json(["erro" => "Recurso inexistente"], 404);
        }

        if($request->method() === "PATCH"){
            
            $regrasDinamicas = array();
            foreach($modelo->rules() as $input => $rule){
                if(array_key_exists($input, $request->all())){
                    $regrasDinamicas[$input] = $rule;
                }
            }
            
            $request->validate($regrasDinamicas);
        }else{
            $request->validate($this->modelo->rules());
        }

        //Exclui a imagem do disco
        if($request->file('imagem')){
            Storage::disk('public')->delete($modelo->imagem);
        }
 
        $modelo->fill($request->all());
        
        if($request->file('imagem')){
            $imagem = $request->file('imagem');
            $imagem_urn = $imagem->store('imagem/modelos','public');
            $modelo->imagem = $imagem_urn;
        }

        $modelo->save();
        
        return response()->json($modelo, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Modelo  $modelo
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $modelo = $this->modelo->find($id);
        if($modelo === null){
            return response()->json(["erro" => "Recurso inexistente"], 404);
        }
        Storage::disk('public')->delete($modelo->imagem); //Exclui a imagem do disco
        
        $modelo->delete();
        return response()->json(["msg" => "A modelo foi Excluida com sucesso"],200) ;
    }
}
