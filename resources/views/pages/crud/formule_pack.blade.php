<div class="row">
    <div class="col-8 grid-margin mx-auto">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Creation d'un nouveau pack</h4>
                <div class="mt-4">
                    <form action="save_formule_pack" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row align-items-end">
                            <div class="form-group col-md-5">
                                <label for="article">Matieres premieres</label>
                                  <select name="matiere_premiere" class="form-control form-control-sm input-height mt-2" id="itemInput">
                                    @foreach($listMatierePremiere as $item)
                                    <option value="{{ $item->id_matiere_premiere }}">{{ $item->designation }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="article">Quantite</label>
                                <input type="number" class="form-control mt-2" name="quantite" id="quantiteInput">
                            </div>
                            <div class="form-group col-md-3">
                                <label for=""></label>
                                <input type="button" onclick="addNewArticle()" class="btn btn-gradient-primary" value="Ajouter">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-8">
                                <table class="table" id="list">
                                    <tbody>
                                        <tr>
                                            <td>Tsatsiou</td>
                                            <td>5</td>
                                            <td>Unite</td>
                                            <td>
                                                <a href="" class="text-danger"><i class="mdi mdi-close action-icon"></i></a>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <div class="loader">
                                        <div class="dot"></div>
                                        <div class="dot"></div>
                                        <div class="dot"></div>
                                    </div>
                                </table>
                            </div>
                        </div>
                        @if(isset($error))
                            <div class="mt-3">
                                <p class="text-danger text-small">{{ $error; }}</p>
                            </div>
                        @endif
                        <div class="mt-3">
                            <button type="submit"
                                class="btn btn-gradient-primary px-5 me-2">Valider</button>
                            <a  href="./purchase-request-list" class="btn btn-light">Annuler</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>