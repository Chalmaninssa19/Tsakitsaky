@if(isset($message))
    <div class="mt-3">
        <p class="text-danger text-small">{{ $message; }}</p>
    </div>
@endif
<div class="row">
    <div class="col-md-4">
        <a href="page_import_vente" class="btn btn-gradient-primary">Importer csv</a>
    </div>
    <div class="col-8 grid-margin mx-auto">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Vendre billet : Information client</h4>
                <div class="mt-4">
                    <form action="save_vente_billet1" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputUsername1">Nom client</label>
                            <input type="text" name="nom_client" class="form-control" id="exampleInputUsername1">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputUsername1">Contact client</label>
                            <input type="text" name="contact_client" class="form-control" id="exampleInputUsername1">
                        </div>
                        <div class="form-group">
                            <label for="article"> Axe livraison</label>
                            <select name="axe_livraison" class="form-control form-control-sm input-height mt-2">
                                @if(isset($listAxe))
                                @foreach($listAxe as $item)
                                    <option value="{{ $item->id_axe_livraison }}">{{ $item->axe }}</option>
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
                                class="btn btn-gradient-primary px-5 me-2">Suivant</button>
                            <a  href="vendre_billet" class="btn btn-light">Annuler</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>