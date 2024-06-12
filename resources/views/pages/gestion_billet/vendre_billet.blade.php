<div class="row">
    <div class="col-8 grid-margin mx-auto">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Vendre billet : Information de la vente</h4>
                <div class="mt-4">
                    <form action="save_vente_billet" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputUsername1">Date vente</label>
                            <input type="date" name="date_vente" class="form-control" id="exampleInputUsername1">
                        </div>
                        <div class="form-group">
                            <label for="article"> Billet vendu </label>
                            <select name="billet_vendu" class="form-control form-control-sm input-height mt-2">
                                @if(isset($listPack))
                                @foreach($listPack as $item)
                                    <option value="{{ $item->id_pack }}">{{ $item->nom }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputUsername1">Quantite vendu</label>
                            <input type="number" name="quantite" class="form-control" id="exampleInputUsername1">
                        </div>
                        <div class="form-group">
                            <label for="article"> Etudiant vendeur</label>
                                <select name="etudiant" class="form-control form-control-sm input-height mt-2">
                                @if(isset($listEtudiant))
                                @foreach($listEtudiant as $item)
                                    <option value="{{ $item->id_etudiant }}">{{ $item->nom.' '.$item->prenom }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        @if(isset($error))
                            <div class="mt-3">
                                <p class="text-danger text-small">{{ $error; }}</p>
                            </div>
                        @endif
                        <div class="mt-3">
                            <button type="submit"
                                class="btn btn-gradient-primary px-5 me-2">Vendre</button>
                            <a  href="vendre_billet1" class="btn btn-light">Annuler</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>