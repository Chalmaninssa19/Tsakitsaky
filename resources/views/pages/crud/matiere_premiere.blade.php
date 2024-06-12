<div class="row">
    <div class="col-md-12 mx-auto grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                    @if(isset($matierePremiere))
                        <h4 class="card-title">Modification matiere premiere</h4>
                        <form class="forms-sample" action="update_matiere_premiere" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="exampleInputUsername1">Designation</label>
                                <input type="text" name="designation" class="form-control" id="exampleInputUsername1" 
                                value="{{ $matierePremiere->designation }}">
                            </div>
                            <input type="hidden" name="id_matiere_premiere" class="form-control" id="exampleInputUsername1" value="{{ $matierePremiere->id_matiere_premiere }}">

                            <div class="form-group">
                                <label for="article">Unite</label>
                                  <select name="unite_id" class="form-control form-control-sm input-height mt-2" id="articleInput">
                                    @foreach ($uniteList as $item)
                                        @if($item->id_unite == $matierePremiere->unite_id)
                                            <option selected value="{{ $item->id_unite }}">{{ $item->nom }}</option>
                                        @else
                                            <option value="{{ $item->id_unite }}">{{ $item->nom }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Prix unitaire</label>
                                <input type="number" step="0.01" name="prix_unitaire" class="form-control" 
                                id="exampleInputEmail1" value="{{ $matierePremiere->prix_unitaire }}">
                            </div>
                            @if(isset($error))
                            <div class="mt-3">
                                <p class="text-danger text-small">{{ $error; }}</p>
                            </div>
                            @endif
                            <button type="submit" data-bs-toggle="modal" data-bs-target="#exampleModal"
                                    class="btn btn-gradient-primary me-2">Modifier matiere premiere
                                </button>
                            <a href="./reception-list" class="btn btn-light">Cancel</a>
                        </form>
                    @else
                        <h4 class="card-title">Insertion nouvelle matiere premiere</h4>
                        <form class="forms-sample" action="save_matiere_premiere" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="exampleInputUsername1">Designation</label>
                                <input type="text" name="designation" class="form-control" id="exampleInputUsername1">
                            </div>
                            <div class="form-group">
                                <label for="article">Unite</label>
                                  <select name="unite_id" class="form-control form-control-sm input-height mt-2" id="articleInput">
                                    @foreach ($uniteList as $item)
                                    <option value="{{ $item->id_unite }}">{{ $item->nom }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Prix unitaire</label>
                                <input type="number" step="0.2" name="prix_unitaire" class="form-control" id="exampleInputEmail1"
                                       placeholder="">
                            </div>
                           
                            @if(isset($error))
                            <div class="mt-3">
                                <p class="text-danger text-small">{{ $error; }}</p>
                            </div>
                            @endif
                            <button type="submit" data-bs-toggle="modal" data-bs-target="#exampleModal"
                                    class="btn btn-gradient-primary me-2">Creer matiere premiere
                                </button>
                            <a href="./reception-list" class="btn btn-light">Cancel</a>
                        </form>
                    @endif
                    </div>
                    <div class="col-md-6">
                        <h4 class="card-title">Liste matieres premieres crée</h4>
                        <table class="table table-no-border align-middle" id="tableau">
                            <thead>
                                <tr class="table-primary">
                                    <th data-colonne="designation">Designation <span class="arrow">&#x25B2</span></th>
                                    <th data-colonne="prix_unitaire">Prix unitaire <span class="arrow">&#x25B2</span></th>
                                    <th data-colonne="unite">Unite <span class="arrow">&#x25B2</span></th>
                                    <td></td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($list as $item)
                                <tr>
                                    <td>{{ $item->designation }}</td>
                                    <td>{{ $item->prix_unitaire }} Ar</td>
                                    <td>{{ $item->unite }}</td>
                                    <td><a href="edit_matiere_premiere?id_matiere_premiere={{ $item->id_matiere_premiere }}&page={{ $page }}" class="text-warning"><i
                                                class="mdi mdi-settings action-icon me-5"></i></a>
                                        <a href="delete_matiere_premiere?id_matiere_premiere={{ $item->id_matiere_premiere }}" class="text-danger"><i class="mdi mdi-close action-icon"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $list->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>