<div class="row">
    <div class="col-12 grid-margin">
        <div class="card">
            <div class="card-body">
                @if(isset($error))
                <div class="mt-3">
                    <p class="text-danger text-small">{{ $error; }}</p>
                </div>
                @endif
                <h4 class="card-title">Listes des packs crees</h4>
                <div class="mt-4 d-flex align-items-center justify-content-between">
                    <div>
                        <a href="{{ route('nouveau_pack') }}" class="btn btn-gradient-primary">Nouveau pack</a>
                    </div>
                    @if(!isset($id_helper))
                    <div>
                        <a href="liste_deleted_pack" class="btn btn-gradient-primary">Packs supprimes</a>
                    </div>
                    @else
                    <div>
                        <a href="liste_pack" class="btn btn-gradient-primary">Packs dispos</a>
                    </div>
                    @endif
                </div>
                    <div class="table-responsive">
                      <table class="table">
                        <thead>
                          <tr>
                            <th> Nom </th>
                            <th> Description </th>
                            <th> Prix unitaire </th>
                            <th></th>
                            <th></th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($list as $item)
                            @if(isset($id_helper))
                            <tr>
                              <td>
                                <img src="{{ asset('images/faces/'.$item->photo) }}" class="me-2"> {{ $item->nom }}
                              </td>
                              <td>{{ $item->description }}</td>
                              <td> {{ $item->getFormatMonetaire($item->prix_unitaire) }} </td>
                              <td><a href="restaurer_pack?id_pack={{ $item->id_pack }}" class="text-danger action-icon">Restaurer</a></td>
                            </tr>
                            @else
                            <tr>
                              <td>
                                <img src="{{ asset('images/faces/'.$item->photo) }}" class="me-2"> {{ $item->nom }}
                              </td>
                              <td>{{ $item->description }}</td>
                              <td> {{ $item->getFormatMonetaire($item->prix_unitaire) }} </td>
                              <td><a href="modifier_pack?id_pack={{ $item->id_pack }}" class="text-warning action-icon"><i class="mdi mdi-settings"></i></a></td>
                              <td><a href="delete_pack?id_pack={{ $item->id_pack }}" class="text-danger action-icon"><i class="mdi mdi-delete"></i></a></td>
                            </tr>
                            @endif
                          @endforeach
                        </tbody>
                      </table>
                    </div>
            </div>
        </div>
    </div>
</div>