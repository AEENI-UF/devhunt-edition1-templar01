<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Api\BaseController as BaseController;

use App\Http\Controllers\Controller;
use App\Http\Requests\EtudiantRequest;
use App\Http\Resources\EtudiantResource;
use App\Models\Etudiant;
use Illuminate\Http\Request;

class EtudiantController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $etudiants = Etudiant::all();
        return $this->handleResponse(EtudiantResource::collection($etudiants),'Listes Etudiants');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EtudiantRequest $request)
    {
        $etudiant = new Etudiant();
        $etudiant ->matricule = $request ->matricule;
        $etudiant ->name = $request ->name;
        if($etudiant->save()){
            return new EtudiantResource($etudiant);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $etudiant = Etudiant::find($id);
        return new EtudiantResource($etudiant);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EtudiantRequest $request, $id)
    {
        $etudiant = Etudiant::find($id);
        $etudiant->matricule = $request ->matricule;
        $etudiant->name = $request->name;
        $etudiant->save();
        return new EtudiantResource($etudiant);
        

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Etudiant::destroy($id)) {
            return $this->handleResponse(new EtudiantResource(null),'etudiant supprimer');
        }
    }
}
