<div class="row">
    <div class="col-8 grid-margin mx-auto">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Creation d'un nouveau pack</h4>
                <div class="mt-4">
                    <form action="save_pack" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputUsername1">Nom</label>
                            <input type="text" name="nom" class="form-control" id="exampleInputUsername1"
                                placeholder="Nom du pack">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputUsername1">Prix unitaire</label>
                            <input type="number" step="0.01" name="prix_unitaire" class="form-control" id="exampleInputUsername1"
                                placeholder="Prix du pack">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputUsername1">Photo</label>
                            <input type="file" name="photo" class="form-control" id="exampleInputUsername1">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Description</label>
                            <textarea name="description" class="form-control" id="" cols="30" rows="10"></textarea>
                        </div>
                        
                        @if(isset($error))
                            <div class="mt-3">
                                <p class="text-danger text-small">{{ $error; }}</p>
                            </div>
                        @endif
                        <div class="mt-3">
                            <button type="submit"
                                class="btn btn-gradient-primary px-5 me-2">Creer</button>
                            <a  href="liste_pack" class="btn btn-light">Retour</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>