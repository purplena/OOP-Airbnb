// Menu toggle
const menuBurgerBtn = document.getElementById('menu-burger-container');
const menuItemnsContainer = document.getElementById('menu-items-container');

menuBurgerBtn.addEventListener('click', function (event) {
  event.stopPropagation();
  menuItemnsContainer.classList.toggle('show');
});

//Close menu when click outside of the menu
document.addEventListener('click', function () {
  menuItemnsContainer.classList.remove('show');
});

//Code for autocomplete of City and Country
fetch('countries.json')
  .then((response) => response.json())
  .then((data) => {
    let countries = Object.keys(data);
    // console.log(countries);
    const inputCountry = document.getElementById('inputCountry');
    new Awesomplete(inputCountry, {
      list: countries,
    });

    const inputCity = document.getElementById('inputCity');
    const cities = Object.values(data).flat();

    const uniqueCities = [];
    const history = {};
    for (let i = 0; i < cities.length; i++) {
      const city = cities[i];
      if (!history[city]) {
        uniqueCities.push(city);
        history[city] = true;
      }
    }
    new Awesomplete(inputCity, {
      list: uniqueCities,
    });
  })
  .catch((error) => console.error('Error:', error));

document.getElementById('number_nights').innerText = '0 night(s)';

var reservationForm = document.getElementById('reservation-form');
var dataAttributeReservationForm = reservationForm.getAttribute(
  'data-unavailable-dates'
);
console.log(dataAttributeReservationForm);

function getDatesInRange(start, end) {
  var dates = [];
  var currentDate = new Date(start);
  var lastDate = new Date(end);

  while (currentDate <= lastDate) {
    dates.push(new Date(currentDate));
    currentDate.setDate(currentDate.getDate() + 1);
  }

  return dates;
}

// var dateRanges = [
//   ['2023-09-13', '2023-09-15'],
//   ['2023-09-24', '2023-09-27'],
//   ['2023-11-01', '2023-11-04'],
// ];

var dateRanges = JSON.parse(dataAttributeReservationForm).map(function (range) {
  return [new Date(range[0]), new Date(range[1])];
});

console.log(dateRanges);
var disabledDates = [];

dateRanges.forEach(function (range) {
  var dates = getDatesInRange(range[0], range[1]);
  dates.forEach(function (date) {
    disabledDates.push(
      date.getDate() + '/' + (date.getMonth() + 1) + '/' + date.getFullYear()
    );
  });
});
console.log(disabledDates);

//Here I initialize y Bootstrap DatePicker Plugin
// I block all the dates before today and I highlight today
$(document).ready(function () {
  $('.datepicker').datepicker({
    format: 'dd/mm/yyyy',
    startDate: new Date(),
    todayHighlight: true,
    datesDisabled: disabledDates,
  });
  $('#date_finish').on('changeDate', function (e) {
    var startDateString = $('#date_start').datepicker('getDate');
    var endDateString = $('#date_finish').datepicker('getDate');
    var startDate = new Date(startDateString);
    var endDate = new Date(endDateString);
    var timeDiff = Math.abs(endDate.getTime() - startDate.getTime());
    var numberOfNights = Math.ceil(timeDiff / (1000 * 3600 * 24));
    document.getElementById('number_nights').innerText =
      numberOfNights + ' night(s)';
    var price = document.getElementById('price-span').innerText;
    var total = price * numberOfNights;
    document.getElementById('total').innerText = total + ' €';
  });
});
