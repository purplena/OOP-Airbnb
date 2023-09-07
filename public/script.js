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

//MODAL LOGIN

const btn = document.getElementById('login-button');
// const modalPanel = document.getElementById('modal-panel');

// btn.addEventListener('click', function () {
//   console.log('here');
//   modalPanel.classList.remove('modal-hidden');
// });

// modalButton = document.getElementById('btn-modal-modal');
// modalButton.addEventListener('click', function () {
//   modalPanel.classList.add('modal-hidden');
// });

var modal = document.getElementById('loginModal');

// Get the button that opens the modal

// Get the <span> element that closes the modal
var span = document.getElementsByClassName('close-button')[0];

// When the user clicks the button, open the modal
btn.onclick = function () {
  modal.style.display = 'block';
};

// When the user clicks on <span> (x), close the modal
span.onclick = function () {
  modal.style.display = 'none';
};

// When the user clicks anywhere outside of the modal, close it
window.onclick = function (event) {
  if (event.target == modal) {
    modal.style.display = 'none';
  }
};

$('#ajaxform').submit(function (e) {
  e.preventDefault(); // avoid to execute the actual submit of the form.
  var formData = $(this).serialize();

  $.ajax({
    type: 'POST',
    url: '/loginPost',
    data: $('#ajaxform').serialize(), // serializes the form's elements.
  });
});
