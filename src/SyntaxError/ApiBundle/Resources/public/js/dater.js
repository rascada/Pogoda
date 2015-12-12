if(location.href.indexOf('date') == -1) {
    var dateBuffer = today;
} else {
    dateBuffer = location.href.match(/date=.*/)[0].replace('date=', '').match(/\d+-\d+-\d+/)[0];
}

var $parent = document.getElementById('date');
var $dateInput = $parent.getElementsByTagName('input')[0];
$dateInput.addEventListener('change', function() {
    if(this.value != dateBuffer) {
        var connector = '';
        var params = location.search.replace('?', '').replace(/date=\d+-\d+-\d+/, '').split('&');
        params.length > 1 ? connector += '&' : connector += "?";
        location.href = location.href.replace(/(&|\?)date=\d+-\d+-\d+/, '')+connector+"date="+this.value;
        dateBuffer = this.value;
    }

});

var isToday = location.href.indexOf('date') == -1;
if(!isToday) {
    var selectedDate = location.href.match(/date=.*/)[0].replace('date=', '');
    $dateInput.style.display = 'block';
    $dateInput.setAttribute('value', selectedDate.match(/\d+-\d+-\d+/)[0]);
} else {
    $dateInput.setAttribute('value', today);
}
