

<div class="row">
    <div class="col-md-12 mx-auto grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="card-title">Insertion axe de livraison</h4>
                        <form class="forms-sample" action="save_axe_livraison" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="exampleInputUsername1">Nom</label>
                                <input type="text" name="nom" class="form-control" id="exampleInputUsername1">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputUsername1">Axe</label>
                                <input type="text" name="axe" class="form-control" id="exampleInputUsername1">
                            </div>
                            
                            @if(isset($error))
                            <div class="mt-3">
                                <p class="text-danger text-small">{{ $error; }}</p>
                            </div>
                            @endif
                            <button type="submit" data-bs-toggle="modal" data-bs-target="#exampleModal"
                                    class="btn btn-gradient-primary me-2">Creer Axe livraison
                                </button>
                            <a href="./reception-list" class="btn btn-light">Cancel</a>
                        </form>
                    </div>
                    <div class="col-md-6">
                        <h4 class="card-title">Liste axe livraison</h4>
                        <table class="table table-no-border align-middle">
                            <thead>
                                <tr class="table-primary">
                                    <td>Nom</td>
                                    <td>Axe</td>
                                    <td></td>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($listAxeLivraison))
                                @foreach ($listAxeLivraison as $item)
                                <tr>
                                    <td>{{ $item->nom }}</td>
                                    <td>{{ $item->axe }}</td>
                                    <td>
                                        <a href="delete_axe_livraison?id_axe_livraison={{ $item->id_axe_livraison }}" class="text-danger"><i class="mdi mdi-close action-icon"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>