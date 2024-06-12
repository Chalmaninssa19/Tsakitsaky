@if(isset($error))
    <div class="mt-3">
      <p class="text-danger text-small">{{ $error; }}</p>
  </div>
@endif
<div class="row">
    <div class="col-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <h2 class="card-title text-primary" style="text-align : center">ETAT DE PAIEMENT BILLET</h2>
                <br>
                <div class="row">
                    <div class="col-md-6">
                      @if(isset($totalEtatPaiement))
                        <address>
                          <p><span>Total a payer : </span><span class="font-weight-bold"> {{ $totalEtatPaiement->total_paye }} Ar </span></p>
                          <p><span>Deja payer : </span><span class="font-weight-bold"> {{ $totalEtatPaiement->total_deja_paye }} Ar </span></p>
                          <p><span>Reste a payer : </span><span class="font-weight-bold"> {{ $totalEtatPaiement->total_reste_paye }} Ar </span></p>
                        </address>
                      @endif
                    </div>
                </div>
                <hr>
                <h4 class="card-text">Liste paiements par etudiant</h4>
                    <div class="table-responsive">
                      <table class="table">
                        <thead>
                          <tr>
                            <th> Etudiant </th>
                            <th> Total a payer </th>
                            <th> Deja payer </th>                            
                            <th> Reste a payer </th>
                            <th> Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          @if(isset($listPaiementEtudiant))
                          @foreach($listPaiementEtudiant as $item)
                          <tr>
                            <td> {{ $item->nom_etudiant.' '.$item->prenom_etudiant }} </td>
                            <td> {{ $item->montant_total_paye }} Ar </td>
                            <td>  {{ $item->montant_deja_paye }} Ar </td>
                            <td> {{ $item->montant_reste_paye }} Ar</td>
                            <td>
                                <a href="historique_paiement_etudiant?id_etudiant={{ $item->id_etudiant }}">
                                    <label class="badge badge-gradient-success">Historiques</label>
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