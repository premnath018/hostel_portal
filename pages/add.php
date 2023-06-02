<!DOCTYPE html>
<html>
<head>
	<title>Add Student</title>
</head>
<body>
	<h1>Add Student</h1>
	<form>
		<label for="rollno">Roll No:</label>
		<input type="text" id="rollno" name="rollno"><br>

		<label for="name">Name:</label>
		<input type="text" id="name" name="name"><br>

		<label for="email">Email:</label>
		<input type="email" id="email" name="email"><br>

		<label for="year">Year:</label>
		<select id="year" name="year">
			<option value="I">First Year</option>
			<option value="II">Second Year</option>
			<option value="III">Third Year</option>
			<option value="IV">Fourth Year</option>
		</select><br>

		<label for="hostel">Hostel:</label>
		<select id="hostel" name="hostel">
			<option value="Sapphire">Sapphire</option>
			<option value="Ruby">Ruby</option>
			<option value="Diamond">Diamond</option>
			<option value="Pearl">Pearl</option>
            <option value="Coral">Coral</option>
            <option value="Emerald">Emerald</option>
		</select><br>

		<label for="room_no">Room No:</label>
		<input type="text" id="room_no" name="room_no"><br>

		<label for="floor">Floor:</label>
		<select id="floor" name="floor">
            <option value="G">Ground Floor</option>
			<option value="1">First Floor</option>
			<option value="2">Second Floor</option>
			<option value="3">Third Floor</option>
        </select><br>

		<button onclick="AddStudent()" type="button">Add Student</button>
	</form>
	<h1>Add Faculty</h1>
	<form>
		<label for="fno">Faculty Id:</label>
		<input type="text" id="fno" name="rollno"><br>

		<label for="name">Name:</label>
		<input type="text" id="name" name="name"><br>

		<label for="email">Email:</label>
		<input type="email" id="email" name="email"><br>
		<label for="hostel">Hostel:</label>
		<select id="hostel" name="hostel">
			<option value="Sapphire">Sapphire</option>
			<option value="Ruby">Ruby</option>
			<option value="Diamond">Diamond</option>
			<option value="Pearl">Pearl</option>
            <option value="Coral">Coral</option>
            <option value="Emerald">Emerald</option>
		</select><br>

		<label for="role_2">Role 2:</label>
		<select id="role" name="floor">
            <option value="G">Warden</option>
			<option value="1">SuperVisor (Care Taker)</option>
			<option value="2">Admin</option>
			<option value="3">Super Admin</option>
        </select><br>


		<label for="room_no">Room No:</label>
		<input type="text" id="room_no" name="room_no"><br>

		<label for="floor">Floor:</label>
		<select id="floor" name="floor">
            <option value="G">Ground Floor</option>
			<option value="1">First Floor</option>
			<option value="2">Second Floor</option>
			<option value="3">Third Floor</option>
        </select><br>

		<button onclick="AddFaculty()" type="button">Add Student</button>
	</form>
</body>
</html>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
        function AddStudent(){
            var rollno = $('#rollno').val().trim().toUpperCase();
            var name= $('#name').val().trim().toUpperCase();
            var email= $('#email').val().trim().toLowerCase();
			var year= $('#year').val().trim();
			var hostel= $('#hostel').val().trim();
			var room_no= $('#room_no').val().trim();
			var floor= $('#floor').val().trim();
            var form_data = new FormData();
            form_data.append('rollno',rollno);
            form_data.append('name',name);
			form_data.append('email',email);
			form_data.append('year',year);
			form_data.append('hostel',hostel);
			form_data.append('room_no',room_no);
			form_data.append('floor',floor);
            $.ajax({
                url : './../api/test/add_student.php',
                method : 'POST',
                dataType : 'json',
                cache : false,
                contentType : false,
                processData: false,
                data : form_data,
                success: function (result) {
                        console.log(result);
                        console.log(result.success);
                        if (result.success === true) {
                          alert(result.message);
                        } else if (result.success === false) {
                             alert(result.message);
                        }
                },
                 error: function (err) {
                    console.log(err);
                }
            });
        }
		function AddFaculty(){
            var rollno = $('#rollno').val().trim().toUpperCase();
            var name= $('#name').val().trim().toUpperCase();
            var email= $('#email').val().trim().toLowerCase();
			var year= $('#year').val().trim();
			var hostel= $('#hostel').val().trim();
			var room_no= $('#room_no').val().trim();
			var floor= $('#floor').val().trim();
            var form_data = new FormData();
            form_data.append('rollno',rollno);
            form_data.append('name',name);
			form_data.append('email',email);
			form_data.append('year',year);
			form_data.append('hostel',hostel);
			form_data.append('room_no',room_no);
			form_data.append('floor',floor);
            $.ajax({
                url : './../api/test/add_student.php',
                method : 'POST',
                dataType : 'json',
                cache : false,
                contentType : false,
                processData: false,
                data : form_data,
                success: function (result) {
                        console.log(result);
                        console.log(result.success);
                        if (result.success === true) {
                          alert(result.message);
                        } else if (result.success === false) {
                             alert(result.message);
                        }
                },
                 error: function (err) {
                    console.log(err);
                }
            });
        }
</script>