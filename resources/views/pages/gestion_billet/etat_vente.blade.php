@if(isset($error))
    <div class="mt-3">
      <p class="text-danger text-small">{{ $error; }}</p>
  </div>
@endif
<div class="row">
    <div class="col-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <h2 class="card-title text-primary" style="text-align : center">ETAT DE VENTE BILLET</h2>
                <br>
                <div class="row">
                    <div class="col-md-8">
                        <address>
                          @if(isset($totalMontantMpNecessaire))
                          <p><span>Montant total matieres 1res necessaires : </span><span class="font-weight-bold"> {{ $totalMontantMpNecessaire }} Ariary </span></p>
                          @endif
                        </address>
                    </div>
                    <div class="col-md-4">
                        <a href="export_excel_vente_pack" class="btn btn-gradient-primary">Exporter excel vente par pack</a>
                    </div>
                </div>
                <hr>
                <h4 class="card-text">Liste ventes billets par etudiant</h4>
                    <div class="table-responsive">
                      <table class="table">
                        <thead>
                          <tr>
                            <th> Etudiant </th>
                            <th> Quantite </th>
                            <th> Montant </th>
                            <th> M.1res neccessaires</th>
                            <th> Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          @if(isset($etatVente))
                          @foreach($etatVente as $item)
                          <tr>
                            <td> {{ $item->nom_etudiant.' '.$item->prenom_etudiant }} </td>
                            <td> {{ $item->quantite }} </td>
                            <td> {{ $item->montant_billet }} ariary</td>
                            <td> {{ $item->montant_mp_necessaire }} ariary</td>
                            <td>
                                <a href="detail_vente_etudiant?id_etudiant={{ $item->id_etudiant }}">
                                    <label class="badge badge-gradient-success">Voir details</label>
                                </a>                            </td>
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