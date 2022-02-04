<?php
namespace App\Http\Controllers;

use App\Models\Marca;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;
use SebastianBergmann\Environment\Console;

class MarcaController extends Controller
{

    public function __construct(Marca $marca){
        $this -> marca = $marca;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $marcas = $this->marca->with('modelos')->get();
        return response()->json($marcas, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // client precisa informar com "accept" => "application/json" para ter um retorno de erro em json
        
        $request->validate($this->marca->rules(),$this->marca->feedback());
        
        $imagem = $request->file('imagem');
        $imagem_urn = $imagem->store('imagem','public');
        $marca = $this->marca->create([
            "nome" => $request->nome,
            "imagem" => $imagem_urn
        ]);
        return response()->json($marca,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function show($id){

        $marca = $this->marca->with('modelos')->find($id);
        if($marca === null){
            return response()->json(["erro" => "Recurso inexistente"], 404);
        }
        return response()->json($marca, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Adcionar no body da requisição _method = put ou _method = patch e enviar a requisição por POST para usar form-data
        $marca = $this->marca->find($id);
        if($marca === null){
            return response()->json(["erro" => "Recurso inexistente"], 404);
        }

        if($request->method() === "PATCH"){
            
            $regrasDinamicas = array();
            foreach($marca->rules() as $input => $rule){
                if(array_key_exists($input, $request->all())){
                    $regrasDinamicas[$input] = $rule;
                }
            }

            $request->validate($regrasDinamicas,$marca->feedback());
        }else{
            $request->validate($this->marca->rules(),$marca->feedback());
        }

        //Exclui a imagem do disco
        if($request->file('imagem')){
            Storage::disk('public')->delete($marca->imagem);
        }

        $marca->fill($request->all());

        if($request->file('imagem')){
           $imagem = $request->file('imagem');
            $imagem_urn = $imagem->store('imagem','public');
            $marca->imagem = $imagem_urn;
        }
        
        $marca->save();
        return response()->json($marca, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   
        $marca = $this->marca->find($id);
        if($marca === null){
            return response()->json(["erro" => "Recurso inexistente"], 404);
        }
        Storage::disk('public')->delete($marca->imagem); //Exclui a imagem do disco
        
        $marca->delete();
        return response()->json(["msg" => "A marca foi Excluida com sucesso"],200) ;
    }
}