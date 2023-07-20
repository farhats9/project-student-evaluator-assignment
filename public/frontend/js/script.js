// This starts to produce the dropdowns with selected No.s
const numberSelect = document.getElementById('numberSelect');
const dynamicDropdowns = document.getElementById('dynamicDropdowns').children;

  // Event listener for the number select dropdown
numberSelect.addEventListener('change', toggleDynamicDropdowns);

  // Function to toggle the visibility of dynamic dropdowns
function toggleDynamicDropdowns() {
  // Get the selected number
  const selectedNumber = parseInt(numberSelect.value);

  // Hide all dropdowns
  for (let i = 0; i < dynamicDropdowns.length; i++) {
    dynamicDropdowns[i].style.display = 'none';
  }

  // Show selected number of dropdowns
  for (let i = 0; i < selectedNumber; i++) {
    dynamicDropdowns[i].style.display = 'block';
  }
}

function filterDropdown(inputId, dropdownId) {
  // Get the input and dropdown elements
  var input = document.getElementById(inputId);
  var dropdown = document.getElementById(dropdownId);

  // Get the search query
  var filter = input.value.toUpperCase();

  // Get the options inside the dropdown
  var options = dropdown.getElementsByTagName('option');

  // Loop through each option and hide/show based on the search query
  for (var i = 0; i < options.length; i++) {
    var option = options[i];
    var text = option.textContent || option.innerText;

    if (text.toUpperCase().indexOf(filter) > -1) {
      option.style.display = '';
    } else {
      option.style.display = 'none';
    }
  }
}
toggleDynamicDropdowns();
// ends the dynamic dropdowns here

//the below code is to display the table contents in the modal
var assignButtons = document.getElementsByClassName("assign-btn");

    for (var i = 0; i < assignButtons.length; i++) {
      assignButtons[i].addEventListener("click", function() {
        openModal(this);
      });
    }

    $(document).ready(function() {
      $('.assign-btn').click(function() {
        var name = $(this).closest('tr').find('td:eq(1)').text();
        var age = $(this).closest('tr').find('td:eq(2)').text();
        var city = $(this).closest('tr').find('td:eq(3)').text();

        $('#studentName').val(name);
        $('#title').val(age);
        $('#areaOfWork').val(city);

        $('#myModal').modal('show');
      });
    });// code for table contents to modal ends here

    //code start for hiding and updating the given options
    $(document).ready(function() {
      $('.custom-dropdown').change(function() {
        var selectedOptions = $('.custom-dropdown').map(function() {
          return $(this).val();
        }).get();

        $('.custom-dropdown').find('option').each(function() {
          var currentValue = $(this).val();
          if (selectedOptions.indexOf(currentValue) !== -1) {
            $(this).not(':selected').hide().prop('disabled', true);
          } else {
            $(this).show().prop('disabled', false);
          }
        });
      });
    });//code ends for hiding and updating the given options


//Keep this last to work the show of initial tables
function showTab(tabName) {
  var i, columns, navLinks;
  
  columns = document.getElementsByClassName("column");
  for (i = 0; i < columns.length; i++) {
    columns[i].style.display = "none";
  }
  
  navLinks = document.getElementsByClassName("navbar")[0].getElementsByTagName("a");
  for (i = 0; i < navLinks.length; i++) {
    navLinks[i].className = navLinks[i].className.replace(" active", "");
  }
  
  document.getElementById(tabName).style.display = "block";
  event.currentTarget.className += " active";
}

  // Show Table 1 by default
showTab('table1Container');

