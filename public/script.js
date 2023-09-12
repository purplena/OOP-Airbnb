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

//Here I initialize y Bootstrap DatePicker Plugin
// I block all the dates before today and I highlight today
$(document).ready(function () {
  $('.datepicker').datepicker({
    format: 'dd/mm/yyyy',
    startDate: new Date(),
    todayHighlight: true,
  });
  $('#date_finish').on('changeDate', function (e) {
    var startDateString = $('#date_start').datepicker('getDate');
    var endDateString = $('#date_finish').datepicker('getDate');

    // Step 2: Convert the date strings to Date objects
    var startDate = new Date(startDateString);
    var endDate = new Date(endDateString);

    // Step 3: Calculate the difference in milliseconds
    var timeDiff = Math.abs(endDate.getTime() - startDate.getTime());

    // Step 4: Convert the difference to the number of nights
    var numberOfNights = Math.ceil(timeDiff / (1000 * 3600 * 24));

    // Step 5: Display the number of nights
    // $('#number_of_nights').text(numberOfNights + ' nights');
    document.getElementById('number_nights').innerText =
      numberOfNights + ' night(s)';

    var price = document.getElementById('price-span').innerText;
    var total = price * numberOfNights;
    document.getElementById('total').innerText = total + ' €';
  });
});

// console.log($('.datepicker').datepicker('getStartDate'));

//Here all the treatment for reservation form
// var reservDateStart = new Date(document.getElementById('date_start').value);

// var reservDateStart = document.getElementById('date_start').innerText;
// var reservDateFinish = document.getElementById('date_finish').innerText;
// const inputNumNights = document.getElementById('number_nights');

// console.log(reservDateStart);
// console.log(reservDateFinish);
