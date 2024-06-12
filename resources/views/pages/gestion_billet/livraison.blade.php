<div class="row">
    <div class="col-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <h2 class="card-title text-primary" style="text-align : center">ETAT DE LiVRAISON PACK</h2>
                <br>
                <div class="row">
                    <div class="col-md-6">
                        <address>
                          <p><span>Total livraison : </span><span class="font-weight-bold"> 150 </span></p>
                          <p><span>Total deja livrer : </span><span class="font-weight-bold"> 50 </span></p>
                        </address>
                    </div>
                    <div class="col-md-6">
                        <address>
                            <p><span>Total reste livrer : </span><span class="font-weight-bold"> 100 </span></p>
                        </address>
                    </div>
                  </div>
                  <hr>
                  <h4 class="card-text">Liste des livraisons par axe</h4>
                    <div class="table-responsive">
                      <table class="table">
                        <thead>
                          <tr>
                            <th> # </th>
                            <th> Axe </th>
                            <th> Quantite </th>
                            <th> Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          @if(isset($listLivraison))
                          @foreach($listLivraison as $item)
                          <tr>
                            <td> {{ $item->nom }} </td>
                            <td> {{ $item->axe }} </td>
                            <td> {{ $item->quantite }}</td>
                            <td>
                                <a href="detail_livraison?id_axe_livraison={{ $item->id_axe_livraison }}">
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