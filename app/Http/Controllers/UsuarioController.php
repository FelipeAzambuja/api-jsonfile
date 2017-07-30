<?php

namespace App\Http\Controllers;

use Storage;
use App\Usuario;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{

	protected $filename;
	
	/**
	 * Inicia os atributos
	 */
	public function __construct()
	{
        $this->filename = 'db.json';
     
        $exists = Storage::disk('local')->exists($this->filename);
        
        if (! $exists) {
            Storage::disk('local')->put($this->filename, '');   
        }
	}

	/**
	 * Retorna todos os itens armazenados dentro de db.json
	 * @return JSON
	 */
	public function index()
	{
		$collection = $this->getCollection(); 

		return response()->json($collection->all(), 200);
	}

	/**
	 * Retorna um item específico de acordo com o ID
	 * @param  int $id 
	 * @return JSON
	 */
	public function show($id)
	{
		$item = $this->findItem($id);

		return response()->json($item, 200);
	}

    /**
     * Armazena os dados enviados pelo usuário em arquivo json
     * @param  Request $request 
     * @return  JSON         
     */
	public function store(Request $request)
    {
        $collection = $this->getCollection(); 

        $user = $this->createItem($request);

        $collection->push($user);

        Storage::disk('local')->put($this->filename, $collection->toJson());

        return response()->json($user, 201);
    }

    /**
     * Atualiza um item da collection 
     * @param  Request $request 
     * @param  int     $id      
     * @return JSON          
     */
    public function update(Request $request, $id)
    {
    	$selected = $this->findItem($id);

    	if ($selected == false) {
    		return response()->json($user, 409);
    	}

    	$collection = $this->getCollectionWithout($selected->id);
  
        $user = $this->createItem($request, $id);

    	$collection->push($user);

    	Storage::disk('local')->put($this->filename, $collection->toJson());

    	return response()->json($user, 201);
    }

    /**
     * Remove um item da collection e atualiza o arquivo db.json
     * @param  int $id [description]
     * @return JSON
     */
    public function destroy($id)
    {
    	$collection = $this->getCollectionWithout($id);

    	Storage::disk('local')->put($this->filename, $collection->toJson());

    	return response()->json($id, 201);
    }


    /**
     * Retorna os itens salvos no db.json em forma de Collection
     * @return Collection
     */
    protected function getCollection()
    {
    	$file = Storage::disk('local')->get($this->filename);

    	$json = json_decode($file);

    	return collect($json);
    }

    /**
     * 
     * @return [type] [description]
     */
    public function createItem($request, $id = null)
    {
        $user = new Usuario();

        $user->id    = ($id == null) ? rand() : $id;
        $user->nome  = $request->nome;
        $user->email = $request->email;  

        return $user;
    }

    /**
     * Retorna um item do 
     * @param  Collection $collection 
     * @return Bool|Model             
     */
    protected function findItem($id)
    {
    	$collection = $this->getCollection();

    	foreach ($collection as $item) {

    		if ($item->id == $id) {
    			return $item;
    		}
    	}

    	return false;
    }

    /**
     * Retorna a collection mas sem o item do ID específicado
     * @param  int $id 
     * @return Collection
     */
    protected function getCollectionWithout($id)
    {
    	$collection = $this->getCollection();
    	$updated    = [];

    	foreach ($collection as $item) {

    		if ($item->id == $id) {
    			continue;
    		}

    		$updated[] = $item;
    	}

    	return collect($updated);	
    }
}
