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
fetch(
  'https://raw.githubusercontent.com/russ666/all-countries-and-cities-json/master/countries.json'
)
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

//Test for multiple images download
// Get a reference to the file input element
const inputElement = document.getElementById('fileInputFilepond');

// Create a FilePond instance
const pond = FilePond.create(inputElement);

pond.setOptions({
  server: {
    url: '/addNewEstatePost',
  },
});
