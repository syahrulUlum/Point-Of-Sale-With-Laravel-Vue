// Banyak barang terjual

var ctx = $("#chart-line");
var coloR = [];

var dynamicColors = function () {
    var r = Math.floor(Math.random() * 255);
    var g = Math.floor(Math.random() * 255);
    var b = Math.floor(Math.random() * 255);
    return "rgb(" + r + "," + g + "," + b + ")";
};

for (var i in label_barang_dijual) {
    coloR.push(dynamicColors());
}

var myLineChart = new Chart(ctx, {
    type: "pie",
    data: {
        labels: JSON.parse(label_barang_dijual),
        datasets: [
            {
                data: JSON.parse(banyak_barang_dijual),
                backgroundColor: coloR,
            },
        ],
    },
});

// Banyak barang diminati
var ctx = $("#chart-line2");
var coloR = [];

var dynamicColors = function () {
    var r = Math.floor(Math.random() * 255);
    var g = Math.floor(Math.random() * 255);
    var b = Math.floor(Math.random() * 255);
    return "rgb(" + r + "," + g + "," + b + ")";
};

for (var i in label_barang_diminati) {
    coloR.push(dynamicColors());
}

var myLineChart = new Chart(ctx, {
    type: "pie",
    data: {
        labels: JSON.parse(label_barang_diminati),
        datasets: [
            {
                data: JSON.parse(banyak_barang_diminati),
                backgroundColor: coloR,
            },
        ],
    },
});
