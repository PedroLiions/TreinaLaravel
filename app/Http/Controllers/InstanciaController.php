<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Instancia;

class InstanciaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('instancias.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('instancias.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nome' => 'required|max:255',
            'email' => 'required',
        ]);

        // store
        $instancia = new Instancia;
        $instancia->nome        = $request->nome;
        $instancia->email       = $request->email;
        $instancia->mensalidade = $request->mensalidade;
        $instancia->telefone    = $request->telefone;
        $instancia->save();

        echo json_encode(['status' => true, 'id' => $instancia->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('products.edit',compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        // $product = Product::findOrFail($id);
        $product->name        = $request->name;
        $product->description = $request->description;
        $product->quantity    = $request->quantity;
        $product->price       = $request->price;
        $product->save();
        return redirect()->route('products.index')->with('message', 'Product updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $instancia = Instancia::findOrFail($id);
        $instancia->delete();

        echo(json_encode(['status' => true]));
    }

    public function listar_instancias() {
        $instancias = Instancia::orderBy('created_at', 'desc')->paginate(10);

        if(empty($instancias)) {
            $instancias['status'] = false; 
        }

        echo(json_encode($instancias));
    }

    public function excluir_instancia(Request $request) {
        $instancia = Instancia::find($request->id_instancia);
        $instancia->delete();

        echo(json_encode(['status' => true]));
    }
}
