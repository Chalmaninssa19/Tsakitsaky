@if(isset($error))
    <div class="mt-3">
        <p class="text-danger text-small">{{ $error }}</p>
    </div>
@endif
<div class="page-header">
    <h3 class="page-title">
        <span class="page-title-icon bg-gradient-primary text-white me-2">
            <i class="mdi mdi-home"></i>
        </span> Tableau de bord
    </h3>
</div>
@if(isset($totalEtatVente))
<div class="row">
    <div class="col-md-4 stretch-card grid-margin">
        <div class="card bg-gradient-danger card-img-holder text-white">
            <div class="card-body">
                <h4 class="font-weight-normal mb-3">Nombre total billets vendus
                </h4>
                <h2 class="mb-5">{{ $totalEtatVente->quantite_total}} unites</h2>
            </div>
        </div>
    </div>
    <div class="col-md-4 stretch-card grid-margin">
        <div class="card bg-gradient-info card-img-holder text-white">
            <div class="card-body">
                <h4 class="font-weight-normal mb-3">Montant total vendus</h4>
                <h2 class="mb-5">{{ $totalEtatVente->montant_billet_total }} Ar</h2>
            </div>
        </div>
    </div>
    <div class="col-md-4 stretch-card grid-margin">
        <div class="card bg-gradient-success card-img-holder text-white">
            <div class="card-body">
                <h4 class="font-weight-normal mb-3">Benefice total</h4>
                <h2 class="mb-5">{{ $totalEtatVente->total_benefice }} Ar</h2>
            </div>
        </div>
    </div>
</div>
@endif
    
<div class="row">
    <div class="col-lg-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Montants des ventes par pack</h4>
                <canvas id="pieChart" style="height:250px"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Statistiques</h4>
                <canvas id="lineChart" style="height:250px"></canvas>
            </div>
        </div>
    </div>
</div>