<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Parking Slots</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      margin: 0;
      padding: 20px;
    }
    h2 {
      text-align: center; /* Center align the heading */
    }
    table {
      border-collapse: collapse;
      width: 50%;
      margin: 20px auto;
    }
    th, td {
      border: 1px solid #dddddd;
      text-align: left;
      padding: 8px;
    }
    th {
      background-color: #f2f2f2;
    }
    .allocated {
      background-color: #ffcccc; /* Red for allocated slots */
      cursor: pointer;
    }
    .available {
      background-color: #ccffcc; /* Green for available slots */
      cursor: pointer;
    }
    .popup {
      display: none;
      position: fixed;
      left: 50%;
      top: 50%;
      transform: translate(-50%, -50%);
      background-color: white;
      padding: 20px;
      border: 1px solid #ccc;
      border-radius: 5px;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
      z-index: 1000;
    }
    .popup input[type="text"] {
      width: 100%;
      padding: 8px;
      margin-bottom: 10px;
      box-sizing: border-box;
    }
    .popup button {
      padding: 10px 20px;
      background-color: #4CAF50;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
    .popup button.cancel {
      background-color: #ccc;
      margin-left: 10px;
    }
  </style>
</head>
<body>
  <h2>Parking Slots</h2>
  <table>
    <tr>
      <th>Parking Slot ID</th>
      <th>Status</th>
    </tr>
    <?php
      // Database connection details (replace with your actual credentials)
      $servername = "localhost";
      $username = "root";
      $password = "";
      $database = "apartment_management";

      // Create connection
      $conn = new mysqli($servername, $username, $password, $database);

      // Check connection
      if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }

      // Generate parking slots
      $total_slots = 20;

      for ($i = 1; $i <= $total_slots; $i++) {
        // Check if the slot is allocated
        $sql = "SELECT owner_id FROM parking_slot WHERE slot_number = $i";
        $result = $conn->query($sql);

        $status_class = ($result->num_rows > 0) ? 'allocated' : 'available';
        $status_text = ($result->num_rows > 0) ? 'Allocated' : 'Available';

        // Output row with slot information and status
        echo "<tr>";
        echo "<td>$i</td>";
        echo "<td class='$status_class' onclick='openPopup($i)'>$status_text</td>";
        echo "</tr>";
      }

      // Close database connection
      $conn->close();
    ?>
  </table>

  
  <div class="popup" id="allotPopup">
    <h3>Allot Parking Slot</h3>
    <form id="allotForm" onsubmit="allotSlot(event)">
      <h3>Select Employee:</h3>
      <select id="employeeId" name="employeeId"></select>
      <button type="submit">Allot Slot</button>
      <button class="cancel" onclick="closePopup()">Cancel</button>
    </form>
  </div>

  <!-- JavaScript for popup functionality and employee dropdown -->
  <script>
    function openPopup(slotNumber) {
      var popup = document.getElementById('allotPopup');
      popup.style.display = 'block';
      popup.setAttribute('data-slot', slotNumber);
      populateEmployees(); // Populate employee dropdown when popup is opened
    }

    function closePopup() {
      var popup = document.getElementById('allotPopup');
      popup.style.display = 'none';
    }

    function populateEmployees() {
      var xhr = new XMLHttpRequest();
      xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
          var employees = JSON.parse(xhr.responseText);
          var select = document.getElementById('employeeId');
          select.innerHTML = ''; // Clear previous options
          employees.forEach(function(employee) {
            var option = document.createElement('option');
            option.value = employee.employee_id;
            option.textContent = employee.first_name + ' ' + employee.last_name;
            select.appendChild(option);
          });
        }
      };
      xhr.open('GET', 'get_employees.php', true);
      xhr.send();
    }

    function allotSlot(event) {
  event.preventDefault();
  var slotNumber = document.getElementById('allotPopup').getAttribute('data-slot');
  var employeeId = document.getElementById('employeeId').value;

  // Check if slotNumber and employeeId are not empty
  if (slotNumber && employeeId) {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
      if (xhr.readyState == 4) {
        if (xhr.status == 200) {
          alert(xhr.responseText);
          location.reload(); // Reload the page after successful slot allotment
        } else {
          alert('Error: ' + xhr.status);
        }
      }
    };
    xhr.open('POST', 'allotparkingslot.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.send('slotNumber=' + slotNumber + '&employeeId=' + employeeId);
    closePopup(); // Close the popup after form submission
  } else {
    alert('Please select a slot and an employee.');
  }
}

  </script>
</body>
</html>
