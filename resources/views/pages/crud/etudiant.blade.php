

<div class="row">
    <div class="col-md-12 mx-auto grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        @if(isset($etudiant))
                            <h4 class="card-title">Modification etudiant</h4>
                            <form class="forms-sample" action="update_etudiant" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="exampleInputUsername1">Nom</label>
                                    <input type="text" name="nom" class="form-control" id="exampleInputUsername1" value="{{ $etudiant->nom }}">
                                </div>
                                <input type="hidden" name="id_etudiant" class="form-control" id="exampleInputUsername1" value="{{ $etudiant->id_etudiant }}">
                                <div class="form-group">
                                    <label for="exampleInputUsername1">Prenom</label>
                                    <input type="text" name="prenom" class="form-control" id="exampleInputUsername1" value="{{ $etudiant->prenom }}">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputUsername1">Email</label>
                                    <input type="text" name="email" class="form-control" id="exampleInputUsername1" value="{{ $etudiant->email }}">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputUsername1">Contact</label>
                                    <input type="text" name="contact" class="form-control" id="exampleInputUsername1" value="{{ $etudiant->contact }}">
                                </div>
                                @if(isset($error))
                                <div class="mt-3">
                                    <p class="text-danger text-small">{{ $error; }}</p>
                                </div>
                                @endif
                                <button type="submit" data-bs-toggle="modal" data-bs-target="#exampleModal"
                                        class="btn btn-gradient-primary me-2">Modifier etudiant
                                    </button>
                                <a href="./reception-list" class="btn btn-light">Cancel</a>
                            </form>
                        @else
                            <h4 class="card-title">Insertion etudiant</h4>
                            <form class="forms-sample" action="save_etudiant" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="exampleInputUsername1">Nom</label>
                                    <input type="text" name="nom" class="form-control" id="exampleInputUsername1">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputUsername1">Prenom</label>
                                    <input type="text" name="prenom" class="form-control" id="exampleInputUsername1">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputUsername1">Email</label>
                                    <input type="text" name="email" class="form-control" id="exampleInputUsername1">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputUsername1">Contact</label>
                                    <input type="text" name="contact" class="form-control" id="exampleInputUsername1">
                                </div>
                                @if(isset($error))
                                <div class="mt-3">
                                    <p class="text-danger text-small">{{ $error; }}</p>
                                </div>
                                @endif
                                <button type="submit" data-bs-toggle="modal" data-bs-target="#exampleModal"
                                        class="btn btn-gradient-primary me-2">Creer etudiant
                                    </button>
                                <a href="./reception-list" class="btn btn-light">Cancel</a>
                            </form>
                        @endif
                    </div>
                    <div class="col-md-8">
                        <h4 class="card-title">Liste etudiants</h4>
                        <table class="table table-no-border align-middle">
                            <thead>
                                <tr class="table-primary">
                                    <td>Etudiant</td>
                                    <td>Email</td>
                                    <td>Contact</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($list as $item)
                                <tr>
                                    <td>{{ $item->nom.' '.$item->prenom }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>{{ $item->contact }}</td>
                                    <td><a href="edit_etudiant?id_etudiant={{ $item->id_etudiant }}" class="text-warning"><i
                                                class="mdi mdi-settings action-icon me-5"></i></a>
                                        <a href="delete_etudiant?id_etudiant={{ $item->id_etudiant }}" class="text-danger"><i class="mdi mdi-close action-icon"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>