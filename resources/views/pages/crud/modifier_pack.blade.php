@if(isset($pack))
<div class="row">
    <div class="col-5 grid-margin mx-auto">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Modification de pack</h4>
                <div class="mt-4">
                    <form action="update_pack" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputUsername1">Nom</label>
                            <input type="text" name="nom" class="form-control" id="exampleInputUsername1"
                                value="{{ $pack->nom }}">
                        </div>
                        <input type="hidden" name="id_pack" class="form-control" id="exampleInputUsername1" value="{{ $pack->id_pack }}">
                        <div class="form-group">
                            <label for="exampleInputUsername1">Prix unitaire</label>
                            <input type="number" step="0.01" name="prix_unitaire" class="form-control" id="exampleInputUsername1"
                                value="{{ $pack->prix_unitaire }}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputUsername1">Photo</label>
                            <input type="file" name="photo" class="form-control" id="fileInput"
                            value="{{ $pack->photo }}">
                            <p id="fileNameDisplay"></p>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Description</label>
                            <textarea name="description" class="form-control" id="" cols="30" rows="10">{{ $pack->description }}</textarea>
                        </div>
                        
                        @if(isset($error))
                            <div class="mt-3">
                                <p class="text-danger text-small">{{ $error; }}</p>
                            </div>
                        @endif
                        <div class="mt-3">
                            <button type="submit"
                                class="btn btn-gradient-primary px-5 me-2">Modifier</button>
                            <a  href="liste_pack" class="btn btn-light">Retour</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="col-7 grid-margin mx-auto">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Creer la formule du pack</h4>
                <div class="mt-4">
                    <form action="add-matiere-premiere-quantite" method="POST">
                        @csrf
                        <div class="row align-items-end">
                            <div class="form-group col-md-5">
                                <label for="article">Matieres premieres</label>
                                  <select name="id_matiere_premiere" class="form-control form-control-sm input-height mt-2" id="itemInput">
                                    @foreach($listMatierePremiere as $item)
                                    <option value="{{ $item->id_matiere_premiere }}">{{ $item->designation }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="article">Quantite</label>
                                <input type="number" step="0.01" class="form-control mt-2" name="quantite" id="quantiteInput">
                            </div>
                            <input type="hidden" name="id_pack" class="form-control" id="exampleInputUsername1" value="{{ $pack->id_pack }}">
                            <div class="form-group col-md-3">
                                <label for=""></label>
                                <input type="submit" class="btn btn-gradient-primary" value="Ajouter">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-8">
                                <table class="table" id="list">
                                    <tbody>
                                        @if(isset($listMPQtePack))
                                        @foreach($listMPQtePack as $item)
                                       <tr>
                                            <td>{{ $item->designation }}</td>
                                            <td>{{ $item->quantite }}</td>
                                            <td>{{ $item->unite }}</td>
                                            <td>
                                                <a href="delete-mpqte-pack?id_pack={{ $pack->id_pack }}&id_matiere_premiere={{ $item->id_matiere_premiere }}" class="text-danger"><i class="mdi mdi-close action-icon"></i></a>
                                            </td>
                                       </tr>
                                       @endforeach
                                       @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endif