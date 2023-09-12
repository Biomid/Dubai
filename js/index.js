$(document).ready(function () {
    console.log("ready!");
    //Регистрация
    // const select_owner = document.querySelector(".apart-owner");
    // select_owner.addEventListener("blur", function (e){
    //
    //     console.log("RABOTAET");
    // });


        // let Name = $('input[name = "Name"]').val();
        //
        // $.ajax({
        //     url: 'test.php',
        //     method: 'POST',
        //     dataType: 'text',
        //     data: {
        //         Name: Name
        //     },
        //     success(data) {
        //        // console.log(data);
        //         data = JSON.parse(data);
        //         localStorage.setItem("data", data.price_for_night);
        //         localStorage.setItem("month", data.month_rent);
        //         console.log(data.price_for_night);
        //
        //     }
        // });

});

$(".upload-btn").on('click', function (e) {
    e.preventDefault();

        if (window.FormData === undefined) {
            alert('В вашем браузере FormData не поддерживается')
        } else {
            var formData = new FormData();
            formData.append('file', $("#chooseFile")[0].files[0]);


            $.ajax({
                type: "POST",
                url: 'get_file.php',
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                dataType : 'json',
                success: function(data){
                   // console.log(data.status);
                    if (data.status === true){
                        $('.mess').css("display", "block");
                        $('.good').text(data.mess).removeClass("alert-danger").addClass('alert-success');
                        $(".reload-file").load(location.href + " .reload-file");
                        setTimeout(function(){
                            $('.mess').css("display", "none");
                        }, 5000);
                    }
                    else {
                        $('.mess').css("display", "block");
                        $('.good').text(data.mess).removeClass("alert-success").addClass('alert-danger');
                        setTimeout(function(){
                            $('.mess').css("display", "none");
                        }, 5000);
                    }
                }
            });
        }


});

$(".create-user").on('click', function (e) {
    e.preventDefault();

    let Name = $('input[name = "Create-name"]').val(),
        sName = $('input[name = "Create-sname"]').val(),
        Email = $('input[name = "Create-email"]').val();


        $.ajax({
            type: "POST",
            url: 'addUser.php',
            data: {
                Name: Name,
                sName: sName,
                Email: Email
            },
            dataType : 'json',
            success: function(data){
                console.log(data);

                if (data.email_status === false){
                    $('.mess-2').css("display", "block");
                    $('.good-2').text("Неверно указан email адрес").removeClass("alert-success").addClass('alert-danger');
                    setTimeout(function(){
                        $('.mess-2').css("display", "none");
                    }, 5000);
                }
                else if (data.mail_status === true){
                    $(".reload-user").load(location.href + " .reload-user");
                    $('.mess-2').css("display", "block");
                    $('.good-2').text("Пользователь успешно зарегистрирован. Информация и данные для входа высланы на указанный почтовый ящик").removeClass("alert-danger").addClass('alert-success');
                    setTimeout(function(){
                        $('.mess-2').css("display", "none");
                    }, 5000);
                }
                else if (data.mail_status === false){
                    $('.mess-2').css("display", "block");
                    $('.good-2').text("Ошибка отправки Email письма, обратитесь в поддержку").removeClass("alert-success").addClass('alert-danger');
                    setTimeout(function(){
                        $('.mess-2').css("display", "none");
                    }, 5000);
                }



            }
        });



});


const generateTable = dataArr => {
    console.log('dataArr', dataArr)
    const tableBody = document.querySelector('#apart-info-table tbody');
    const tableBodyFull = document.querySelector('#apart-info-table-full tbody');
    if (!tableBody) return;

    dataArr.forEach(dataRow => {
        const tableRow = document.createElement('tr');

        for (const dataRowKey in dataRow) {
            let tableCell = document.createElement('td');

            if (dataRowKey === 'owner') {
                tableCell = document.createElement('th');
                tableCell.style.color = '#666';
                tableCell.innerText = dataRow[`${dataRowKey}`];
                tableRow.appendChild(tableCell);
            } else if (dataRowKey === 'apart_name') {
                tableCell.style.color = '#666';
                // вот это отвечает за внутренний текст ячейки
                tableCell.innerText = dataRow[`${dataRowKey}`];
                // вот это отвечает за вставку в tr
                tableRow.appendChild(tableCell);
            }
            else if (dataRowKey === 'month'){
                tableCell.style.color = '#666';
                // вот это отвечает за внутренний текст ячейки
                tableCell.innerText = dataRow[`${dataRowKey}`];
                // вот это отвечает за вставку в tr
                tableRow.appendChild(tableCell);
            }
            else if (dataRowKey === 'nights_of_rent'){
                tableCell.style.color = '#666';
                // вот это отвечает за внутренний текст ячейки
                tableCell.innerText = dataRow[`${dataRowKey}`];
                // вот это отвечает за вставку в tr
                tableRow.appendChild(tableCell);
            }
            else if (dataRowKey === 'amount_to_be_paid'){
                tableCell.style.color = '#666';
                // вот это отвечает за внутренний текст ячейки
                tableCell.innerText = dataRow[`${dataRowKey}`];
                // вот это отвечает за вставку в tr
                tableRow.appendChild(tableCell);
            }
        }
        tableBody.appendChild(tableRow);
    });

    dataArr.forEach(dataRowFull => {
        const tableRow = document.createElement('tr');

        for (const dataRowKey in dataRowFull) {
            let tableCell = document.createElement('td');

            // if (dataRowKey === 'owner') {
            //     tableCell.innerText = dataRowFull[`${dataRowKey}`];
            //     tableRow.appendChild(tableCell);
            // } else if (dataRowKey === 'price_for_night') {
            //     tableCell.style.color = '#666';
            //     // вот это отвечает за внутренний текст ячейки
            //     tableCell.innerText = dataRowFull[`${dataRowKey}`];
            //     // вот это отвечает за вставку в tr
            //     tableRow.appendChild(tableCell);
            // }
            tableCell.innerText = dataRowFull[`${dataRowKey}`];
            // вот это отвечает за вставку в tr
            tableRow.appendChild(tableCell);
        }
        tableBodyFull.appendChild(tableRow);
    });

};

const generateTableOwner = dataArr => {
    console.log('dataArr', dataArr)
    const tableBodyOwner = document.querySelector('#owner-info-table tbody');
    const tableBodyFullOwner = document.querySelector('#owner-info-table-full tbody');
    if (!tableBodyOwner) return;

    dataArr.forEach(dataRow => {
        const tableRow = document.createElement('tr');

        for (const dataRowKey in dataRow) {
            let tableCell = document.createElement('td');

            if (dataRowKey === 'apart_name') {
                tableCell = document.createElement('th');
                tableCell.style.color = '#666';
                tableCell.innerText = dataRow[`${dataRowKey}`];
                tableRow.appendChild(tableCell);
            } else if (dataRowKey === 'price_for_night') {
                tableCell.style.color = '#666';
                // вот это отвечает за внутренний текст ячейки
                tableCell.innerText = dataRow[`${dataRowKey}`];
                // вот это отвечает за вставку в tr
                tableRow.appendChild(tableCell);
            }
            else if(dataRowKey === 'amount_tobe_paid'){
                tableCell.style.color = '#666';
                // вот это отвечает за внутренний текст ячейки
                tableCell.innerText = dataRow[`${dataRowKey}`];
                // вот это отвечает за вставку в tr
                tableRow.appendChild(tableCell);
            }
        }
        tableBodyOwner.appendChild(tableRow);
    });

    dataArr.forEach(dataRowFull => {
        const tableRow = document.createElement('tr');

        for (const dataRowKey in dataRowFull) {
            let tableCell = document.createElement('td');

            // if (dataRowKey === 'owner') {
            //     tableCell.innerText = dataRowFull[`${dataRowKey}`];
            //     tableRow.appendChild(tableCell);
            // } else if (dataRowKey === 'price_for_night') {
            //     tableCell.style.color = '#666';
            //     // вот это отвечает за внутренний текст ячейки
            //     tableCell.innerText = dataRowFull[`${dataRowKey}`];
            //     // вот это отвечает за вставку в tr
            //     tableRow.appendChild(tableCell);
            // }
            tableCell.innerText = dataRowFull[`${dataRowKey}`];
            // вот это отвечает за вставку в tr
            tableRow.appendChild(tableCell);
        }
        tableBodyFullOwner.appendChild(tableRow);
    });

};

$(".menu-btn").on('click', function (e) {
    e.preventDefault();
    var formData = $(".menu-form").serializeArray();
    $.ajax({
        url: 'menu_resp.php',
        method: 'POST',
        dataType: 'text',
        data: {
          formData: formData
        },
        success(data) {
            console.log(data);
            generateTable(JSON.parse(data));
        }
    });
});

const ctx = document.getElementById('myChart'),
    ctxx = document.getElementById('myChart2');


var densityData = {
    label: 'Kvartira',
    data: [],
    backgroundColor: 'rgba(0, 99, 132, 0.6)',
    borderColor: 'rgba(0, 99, 132, 1)',
    yAxisID: "y-axis-density"
};
// var gravityData = {
//     label: 'Gravity of Planet (m/s2)',
//     data: [3.7, 8.9, 9.8, 3.7, 23.1, 9.0, 8.7, 11.0],
//     backgroundColor: 'rgba(99, 132, 0, 0.6)',
//     borderColor: 'rgba(99, 132, 0, 1)',
//     yAxisID: "y-axis-gravity"
// };
var planetData = {
    labels: [],
    datasets: [densityData]
};
var chartOptions = {
    scales: {

    }
};

const firstGraphic = new Chart(ctx, {
    type: 'line',
    data: {
        labels: [],
        datasets: [{
            label: 'Hata',
            data: [],
            borderWidth: 3
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

const secondGraphic = new Chart(ctxx, {
    type: 'bar',
    data: planetData,
    options: chartOptions
});


$(".form-select").on('change',function (e) {
    let sel_val =  {keyname:$('.form-select option:selected').text()};
    let Name = $('input[name = "Name"]').val();
    $.ajax({
        url: 'apart_owner.php',
        method: 'POST',
        dataType: 'text',
        data: {
            sel_val: sel_val,
            Name: Name
        },
        success(data) {
            data = JSON.parse(data);
            console.log(data.month, data.price_for_night)
            firstGraphic.data.labels = data.month;
            firstGraphic.data.datasets[0].data = data.price_for_night;
            densityData.data = data.price_for_night;
            planetData.labels = data.month;
            secondGraphic.update();
            firstGraphic.update();
            generateTableOwner(data.total);

            $("#hide-info").css("display", "block");
        }
    });

});