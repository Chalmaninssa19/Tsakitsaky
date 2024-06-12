<!-- Modal -->
<div class="modal fade" id="paiementModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Effectuer votre paiement</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="payer_billet" method="POST">
                @csrf
                <div class="form-group">
                    <label for="exampleInputUsername1">Montant a payer</label>
                    <input type="number" step="0.01" name="montant_payer" class="form-control" id="exampleInputUsername1">
                </div>
                @if(isset($etudiant))
                    <input type="hidden" name="id_etudiant" value="{{ $etudiant->id_etudiant }}" />
                @endif
                <div class="form-group">
                    <label for="exampleInputUsername1">Date paiement</label>
                    <input type="date" name="date_paiement" class="form-control" id="exampleInputUsername1">
                </div>    
                @if(isset($error))
                    <div class="mt-3">
                        <p class="text-danger text-small">{{ $error; }}</p>
                    </div>
                @endif  
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Payer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="template-demo">
                    <button type="button" class="btn btn-outline-primary btn-fw" >Historiques</button>
                    <button type="button" class="btn btn-outline-primary btn-fw"
                    data-bs-toggle="modal" data-bs-target="#paiementModal" >Effectuer paiement</button>
                    <button type="button" class="btn btn-outline-primary btn-fw"
                    data-bs-toggle="modal" data-bs-target="#exampleModal" >Effectuer livraison</button>
                    <button type="button" class="btn btn-outline-primary btn-fw"
                    data-bs-toggle="modal" data-bs-target="#exampleModal" >Valider livraison</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <h2 class="card-title text-primary" style="text-align : center">VENTE DE JEAN RABE</h2>
                <br>
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="card-text">Informations du vendeur</h4>
                        <address>
                        @if(isset($etudiant))
                          <p class="card-text"> <span>Nom : </span><span class="font-weight-bold"> {{ $etudiant->nom }} </span></p>
                          <p class="card-text"> <span>Prenom : </span><span class="font-weight-bold"> {{ $etudiant->prenom }} </span></p>
                          <p class="card-text"> <span>Contact : </span><span class="font-weight-bold"> {{ $etudiant->contact }} </span></p>
                          <p class="card-text"> <span>Email : </span><span class="font-weight-bold"> {{ $etudiant->email }} </span></p>
                        @endif
                        </address>
                    </div>
                    <div class="col-md-6">
                        <h4 class="card-text">Rapport des ventes</h4>
                            <address>
                            @if(isset($etatVente))
                                <p class="card-text"> <span>Montant total vendu : </span><span class="font-weight-bold"> {{ $etatVente->montant_billet }} Ar</span></p>
                                <p class="card-text"> <span>Montant matieres 1res necessaires : </span><span class="font-weight-bold"> {{ $etatVente->montant_mp_necessaire }} Ar </span></p>
                                @if(isset($benefice))
                                <p class="card-text"> <span>Benefice : </span><span class="font-weight-bold"> {{ $benefice }} Ar </span></p>
                                @endif
                                <p class="card-text"> <span>Quantite vendu : </span><span class="font-weight-bold"> {{ $etatVente->quantite }} </span></p>
                            @endif
                            </address>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8 grid-margin stretch-card">
                        <div class="card">
                        <div class="card-body">
                            <h4 class="card-text">Billets vendus</h4>
                            <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th> Billet </th>
                                    <th> Quantite </th>
                                    <th> Prix unitaire </th>
                                    <th> Montant </th>
                                    <th> MM1re necessaires </th>
                                </tr>
                            </thead>
                            <tbody>
                            @if(isset($billetVenduEtudiant))
                            @foreach($billetVenduEtudiant as $item)
                                <tr>
                                    <td> {{ $item->pack }} </td>
                                    <td> {{ $item->quantite }} </td>
                                    <td> {{ $item->prix_unitaire }} </td>
                                    <td>  {{ $item->montant }} </td>
                                    <td>  {{ $item->getMontantMp() }} </td>
                                </tr>
                            @endforeach
                            @endif
                            </tbody>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>