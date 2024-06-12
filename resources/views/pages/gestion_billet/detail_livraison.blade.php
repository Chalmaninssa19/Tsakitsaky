@if(isset($error))
    <div class="mt-3">
      <p class="text-danger text-small">{{ $error; }}</p>
  </div>
@endif
<div class="row">
    <div class="col-12 grid-margin">
        <div class="card">
            <div class="card-body">
                @if(isset($infoAxe))
                <h2 class="card-title text-primary" style="text-align : center">ETAT DE LIVRAISON DANS {{ $infoAxe->nom_axe }}</h2>
              
                <br>
                <div class="row">
                    <div class="col-md-9">
                        <address>
                          <p><span>Axe : </span><span class="font-weight-bold"> {{ $infoAxe->axe }} </span></p>
                          <p><span>Total livraison : </span><span class="font-weight-bold"> {{ $infoAxe->total_livraison }} </span></p>
                          <p><span>Total montant : </span><span class="font-weight-bold"> {{ $infoAxe->total_montant }} Ar</span></p>
                        </address>
                    </div>
                    <div class="col-md-3">
                        <a href="export_livraison_pdf?id_axe_livraison={{ $infoAxe->id_axe_livraison }}" class="btn btn-gradient-primary">Exporter PDF</a>
                    </div>
                </div>
                <hr>
                <h4 class="card-text">Details livraison</h4>
                    <div class="table-responsive">
                      <table class="table">
                        <thead>
                          <tr>
                            <th> Client </th>
                            <th> Contact </th>
                            <th> Vendeur </th>
                            <th> Pack </th>
                            <th> nb Pack</th>
                            <th> Montant </th>
                          </tr>
                        </thead>
                        <tbody>
                        @if(isset($listLivraison))
                        @foreach($listLivraison as $item)
                          <tr>
                            <td> {{ $item->nom_client }} </td>
                            <td> {{ $item->contact_client }} </td>
                            <td> {{ $item->nom_etudiant.' '.$item->prenom_etudiant }} </td>
                            <td> {{ $item->pack }} </td>
                            <td> {{ $item->quantite}} </td>
                            <td> {{ $item->montant}} </td>
                          </tr>
                        @endforeach
                        @endif
                        </tbody>
                      </table>
                    </div>
                @else
                    <h2 class="card-title text-info" style="text-align : center">Aucune livraison effectue</h2>
                @endif
            </div>
        </div>
    </div>
</div>