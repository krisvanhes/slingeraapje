$("#imagebtn").click(function () {
    $("#image").trigger('click');
});

function CheckDate() {
    var input = document.getElementById('date');
    var today = moment().format('yyyy-MM-DD');
    var date = moment(input.value).format('yyyy-MM-DD');

    if (date < today) {
        input.value = today;
    } else {
        input.value = date;
    }
}