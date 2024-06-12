$(function () {
  // Fonction pour récupérer les données depuis le servlet Java
  function fetchData() {
    $.ajax({
      url: 'graphe_camembert', // Remplacez par l'URL réelle de votre servlet
      type: 'GET',
      dataType: 'json',
      success: function (data) {
        // Mettez à jour les données du graphique avec les nouvelles données reçues
        updateChartData(data);
      },
      error: function (error) {
        console.error('Erreur lors de la récupération des données : ', error);
      }
    });
  }

  // Fonction pour mettre à jour les données du graphique
  function updateChartData(newData) {
    // Mettez à jour les données du graphique avec les nouvelles données reçues
    doughnutPieData.datasets[0].data = newData.data;
    doughnutPieData.labels = newData.label;
    data.datasets[0].data = newData.labelCourbe;
    data.labels = newData.dataCourbe;
    
    // Mettez à jour d'autres propriétés du graphique si nécessaire

    // Mettez à jour le graphique
    pieChart.update();
    lineChart.update();
  }
 


  var data = {
    labels: ["2013", "2014", "2015"],
    datasets: [{
      label: '# of Votes',
      data: [23, 19, 3],
      backgroundColor: [
        'rgba(255, 99, 132, 0.2)',
        'rgba(54, 162, 235, 0.2)',
        'rgba(255, 206, 86, 0.2)',
        'rgba(75, 192, 192, 0.2)',
        'rgba(153, 102, 255, 0.2)',
        'rgba(255, 159, 64, 0.2)'
      ],
      borderColor: [
        'rgba(255,99,132,1)',
        'rgba(54, 162, 235, 1)',
        'rgba(255, 206, 86, 1)',
        'rgba(75, 192, 192, 1)',
        'rgba(153, 102, 255, 1)',
        'rgba(255, 159, 64, 1)'
      ],
      borderWidth: 2,
      fill: true
    }]
  };
  var options = {
    scales: {
      yAxes: [{
        ticks: {
          beginAtZero: true
        }
      }]
    },
    legend: {
      display: false
    },
    elements: {
      point: {
        radius: 0
      }
    }

  };


  var doughnutPieData = {
    datasets: [{
      data: [],
      backgroundColor: [
        'rgba(255, 99, 132, 0.5)',
        'rgba(54, 162, 235, 0.5)',
        'rgba(255, 206, 86, 0.5)',
        'rgba(75, 192, 192, 0.5)',
        'rgba(153, 102, 255, 0.5)',
        'rgba(255, 159, 64, 0.5)'
      ],
      borderColor: [
        'rgba(255,99,132,1)',
        'rgba(54, 162, 235, 1)',
        'rgba(255, 206, 86, 1)',
        'rgba(75, 192, 192, 1)',
        'rgba(153, 102, 255, 1)',
        'rgba(255, 159, 64, 1)'
      ],
    }],

    // These labels appear in the legend and in the tooltips when hovering different arcs
    labels: []
  };
  var doughnutPieOptions = {
    responsive: true,
    animation: {
      animateScale: true,
      animateRotate: true
    }
  };

  
  if ($("#lineChart").length) {
    var lineChartCanvas = $("#lineChart").get(0).getContext("2d");
    var lineChart = new Chart(lineChartCanvas, {
      type: 'line',
      data: data,
      options: options
    });
  }

  if ($("#pieChart").length) {
    var pieChartCanvas = $("#pieChart").get(0).getContext("2d");
    var pieChart = new Chart(pieChartCanvas, {
      type: 'pie',
      data: doughnutPieData,
      options: doughnutPieOptions
    });

    // Appel initial pour récupérer les données
    fetchData();

    // Mise en place d'une temporisation pour actualiser périodiquement les données
    setInterval(fetchData, 60000); // Actualisation toutes les 60 secondes (ajustez selon vos besoins)
  }

});